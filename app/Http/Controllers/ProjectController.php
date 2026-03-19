<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Project;
use BladeUI\Icons\BladeIconsServiceProvider;
use BladeUI\Icons\IconsManifest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        return view('project', compact('project'));
    }

    public function create(Request $request)
    {
        Gate::authorize('create', Project::class);

        $hosts = Host::all();
        $icons = $this->getProjectIcons();
        $icons->shift(); // remove the one just called 'icon', should be the first one

        return view('project.create', compact('hosts', 'icons'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Project::class);

        $input = $request->validate([
            'host_id' => 'integer|exists:hosts,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'required|string',
            'links' => [
                'nullable',
                'array',
                [
                    'name' => 'required|string',
                    'url' => 'required|url',
                    'icon' => 'nullable|string',
                ]
            ]
        ]);

        if (is_string($input['tags'])) {
            $input['tags'] = explode(',', $input['tags']);
        }

        /** @var Project $project */
        $project = Project::create([
            'host_id' => $input['host_id'] ?? null,
            'name' => $input['name'],
            'description' => $input['description'],
            'tags' => $input['tags'] ?? [],
        ]);

        $existingIcons = $this->getProjectIcons();
        foreach ($input['links'] as $link) {
            // Check if the icon exists
            if (!in_array($link['icon'], $existingIcons->toArray())) {
                $link['icon'] = 'heroicon-o-link';
            }
            $project->links()->create([
                'name' => $link['name'],
                'url' => $link['url'],
                'icon' => $link['icon'],
            ]);
        }

        return redirect()
            ->route('project.show', $project)
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        Gate::authorize('update', $project);

        $hosts = Host::all();
        $icons = $this->getProjectIcons();
        $icons->shift(); // remove the one just called 'icon', should be the first one

        return view('project.edit', compact('project', 'hosts', 'icons'));
    }

    public function update(Request $request, Project $project)
    {
        Gate::authorize('update', $project);

        $input = $request->validate([
            'host_id' => 'integer|exists:hosts,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'required|string',
            'links' => [
                'nullable',
                'array',
                [
                    'id' => 'integer',
                    'name' => 'required|string',
                    'url' => 'required|url',
                    'icon' => 'string',
                ]
            ]
        ]);

        if (is_string($input['tags'])) {
            $input['tags'] = explode(',', $input['tags']);
        }

        /** @var Project $project */
        $project->update([
            'host_id' => $input['host_id'] ?? null,
            'name' => $input['name'],
            'description' => $input['description'],
            'tags' => $input['tags'] ?? [],
        ]);

        // Delete links that were removed
        $existingLinks = $project->links;
        $modifiedLinkIds = collect($input['links'])
            ->map(fn ($link) => $link['id'] ?? null)
            ->filter()
            ->toArray();
        foreach ($existingLinks as $link) {
            if (!in_array($link['id'], $modifiedLinkIds)) {
                $link->delete();
            }
        }

        $existingIcons = $this->getProjectIcons();
        foreach ($input['links'] as $link) {
            // Check if the icon exists
            if (!in_array($link['icon'], $existingIcons->toArray())) {
                $link['icon'] = 'heroicon-o-link';
            }
            if (isset($link['id'])) {
                $project->links()->find($link['id'])->update([
                    'name' => $link['name'],
                    'url' => $link['url'],
                    'icon' => $link['icon'],
                ]);
            } else {
                $project->links()->create([
                    'name' => $link['name'],
                    'url' => $link['url'],
                    'icon' => $link['icon'],
                ]);
            }
        }

        return redirect()
            ->route('project.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    public function featured()
    {
        $featuredProject = Project::all()->first(fn($project) => $project->tags->contains('featured'));
        if (!$featuredProject) {
            abort(404);
        }
        return $this->show($featuredProject);
    }

    public function image(Project $project)
    {
        return response()->file($project->generateImage());
    }

    public function featuredImage()
    {
        $featuredProject = Project::all()->first(fn($project) => $project->tags->contains('featured'));
        if (!$featuredProject) {
            abort(404);
        }
        return $this->image($featuredProject);
    }

    /**
     * @return Collection<string>
     */
    public function getProjectIcons(): Collection
    {
        return cache()
            ->remember(
                'project.icons',
                60 * 5,
                fn() => collect(Blade::getClassComponentAliases())
                    ->filter(fn($alias) => Str::contains($alias, 'BladeUI'))
                    ->map(fn($value, $key) => $key)
                    ->values(),
            );
    }
}

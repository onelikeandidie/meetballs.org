<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        return view('project', [
            'project' => $project,
        ]);
    }

    public function featured()
    {
        $featuredProject = Project::all()->first(fn($project) => $project->tags->contains('featured'));
        if (!$featuredProject) {
            abort(404);
        }
        return view('project', [
            'project' => $featuredProject,
        ]);
    }

    public function image(Project $project)
    {
        return response()->file($project->generateImage());
    }
}

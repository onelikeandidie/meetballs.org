<?php

namespace App\Libraries\Importer;

use App\Libraries\Importer\Project as ParsedProject;
use App\Libraries\Importer\ProjectLink as ParsedProjectLink;
use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/// The projects were listed in the README.md file in a specific format.
/// The format is:
/// ```markdown
/// ## Projects
/// - [Project Name](project-url) - Project description _#tag1_ _#tag2_
///     [Repository](repository-url)
/// - [Project Name](repository-url) - Project long description, very much
///     long description _#tag1_ _#tag2_
/// ```
class Parser
{
    public function parse(string $content): \Illuminate\Support\Collection
    {
        $projects = collect();
        $inProjectsSection = false;
        /** @var Project|null $lastProject */
        $lastProject = null;

        // Split the content into lines
        $lines = collect(explode("\n", $content));
        foreach ($lines as $line) {
            if (Str::startsWith($line, "## Projects")) {
                $inProjectsSection = true;
                continue;
            }
            if (!$inProjectsSection) {
                continue;
            }
            // Trim line and skip empty lines
            $line = trim($line);
            if (empty($line)) {
                continue;
            }
            // If a line starts with a # then we should be out of the projects section
            if (Str::startsWith($line, "#")) {
                break;
            }

            // If the line starts with a - then it's a new project
            if (Str::startsWith($line, "- ")) {
                // Remove the dash and the space
                $line = Str::substr($line, 2);
                // If a line does not start with a [ it's just a list item
                if (!Str::startsWith($line, "[")) {
                    continue;
                }
                // Extract the project name
                $nameEnd = Str::position($line, "]");
                $name = Str::substr($line, 1, $nameEnd - 1);
                // Extract the project URL
                $urlEnd = Str::position($line, ") - ", $nameEnd);
                $url = Str::substr($line, $nameEnd + 2, $urlEnd);
                // Extract the project description, should be the rest of the line
                $description = Str::substr($line, $urlEnd + 4);
                // If there is already a project being parsed, add it to the projects
                if ($lastProject) {
                    // Parse tags and links
                    $tags = $this->extractTags($lastProject->description);
                    $links = $this->extractLinks($lastProject->description);
                    $lastProject->tags = $tags;
                    $lastProject->links->push(...$links);
                    $projects->push($lastProject);
                }
                // Create a new project object
                $lastProject = new ParsedProject(
                    name: $name,
                    description: $description,
                    links: collect([
                        new ParsedProjectLink(
                            name: $name,
                            url: $url,
                            icon: $this->getIcon($url),
                        ),
                    ]),
                    tags: collect(),
                    featured: false,
                );
            } else {
                // If the line is not a new project and there is currently a
                // project being parsed, then this line must be a continuation
                // of the description
                if ($lastProject) {
                    $lastProject->description .= " " . $line;
                    continue;
                }
                // If there is no project being parsed, then this line is no
                // longer part of the projects section
                break;
            }
        }

        // If there is already a project being parsed, add it to the projects
        if ($lastProject) {
            // Parse tags and links
            $tags = $this->extractTags($lastProject->description);
            $links = $this->extractLinks($lastProject->description);
            $lastProject->tags = $tags;
            $lastProject->links->push(...$links);
            $projects->push($lastProject);
        }

        return $projects;
    }

    public function import(Collection $projects): \Illuminate\Support\Collection
    {
        return $projects->map(function (ParsedProject $project) {
            $newProject = Project::updateOrCreate([
                'name' => $project->name,
                'description' => $project->description,
                'host_id' => null,
            ], [
                'tags' => $project->tags,
            ]);
            foreach ($project->links as $link) {
                $newProject->links()->updateOrCreate([
                    'name' => $link->name,
                    'url' => $link->url,
                ], [
                    'icon' => $link->icon,
                ]);
            }
            return $newProject;
        })->filter();
    }

    private function getIcon($url): string
    {
        if (Str::contains($url, 'github.com')) {
            return 'tabler-brand-github';
        }
        return 'heroicon-o-link';
    }

    private function extractTags(string &$description): \Illuminate\Support\Collection
    {
        // Tags are in the format _#tag1_ _#tag2_, we find them and remove them
        // from the description
        $tags = collect();
        $matches = [];
        preg_match_all('/_#([^_]+)_/', $description, $matches);
        foreach ($matches[1] as $tag) {
            $tags->push($tag);
            $description = str_replace("_#{$tag}_", "", $description);
        }
        return $tags;
    }

    private function extractLinks(string &$description): \Illuminate\Support\Collection
    {
        // Links are in the format [Link Name](link-url), we find them and remove
        // them from the description
        $links = collect();
        $matches = [];
        preg_match_all('/\[([^]]+)]\(([^)]+)\)/', $description, $matches);
        foreach ($matches[1] as $index => $name) {
            $url = $matches[2][$index];
            $links->push(new ProjectLink($name, $url, $this->getIcon($url)));
            $description = str_replace("[{$name}]({$url})", "", $description);
        }
        return $links;
    }
}

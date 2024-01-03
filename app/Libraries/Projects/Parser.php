<?php

namespace App\Libraries\Projects;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Parser
{
    // The projects are listed in the README.md file in the root of the project
    // The format is:
    // # Projects
    // - [Project Name](repository-url) - Project description _#tag1_ _#tag2_
    // - [Project Name](repository-url) - Project description _#tag1_ _#tag2_
    public static function parse(string $path): array
    {
        $projects = [];
        $file = File::get($path);
        $lines = explode("\n", $file);
        $projectsSection = false;
        $lastProject = null;
        foreach ($lines as $line) {
            if (Str::startsWith($line, '## Projects')) {
                $projectsSection = true;
                continue;
            }
            if (!$projectsSection) {
                continue;
            }
            // Trim the line, just so you can make the list look nice in the README.md file
            $line = trim($line);
            // Skip empty lines and new sections
            if (empty($line) || Str::startsWith($line, '#')) {
                $lastProject = null;
                continue;
            }
            if (Str::startsWith($line, '- ')) {
                if (!Str::contains($line, '[')) {
                    // This is not a project, just a list item
                    continue;
                }
                $name = Str::between($line, '[', ']');
                $url = Str::between($line, '(', ')');
                $description = Str::after($line, ') - ');
                $projects[] = new Project($name, $description, [
                    'link' => $name,
                    'type' => self::extractType($url),
                    'url' => $url,
                ]);
                $lastProject = count($projects) - 1;
            } else {
                if ($lastProject !== null) {
                    $projects[$lastProject]->description .= ' ' . $line;
                    continue;
                }
                break;
            }
        }
        // Tag the projects
        foreach ($projects as $project) {
            $project->tags = self::extractTags($project->description);
        }
        // // Extract types
        // foreach ($projects as $project) {
        //     $project->type = self::extractType($project);
        // }
        // Extract links
        foreach ($projects as $project) {
            $project->links->push(...self::extractLinks($project->description));
        }
        return $projects;
    }

    private static function extractTags(string &$description): Collection
    {
        $tags = collect();
        $words = explode(' ', $description);
        foreach ($words as $word) {
            $tag = trim($word, '_');
            if (Str::startsWith($tag, '#')) {
                $tag = Str::after($tag, '#');
                $tags->push($tag);
                $description = Str::replaceFirst($word, '', $description);
            }
        }
        return $tags;
    }

    private static function extractLinks(string &$description): array
    {
        $links = [];
        $temp_description = $description;
        while (Str::contains($temp_description, ["[", "]", "(", ")"])) {
            $link = Str::between($temp_description, '[', ']');
            $url = Str::between($temp_description, '(', ')');
            $links[] = [
                'link' => $link,
                'type' => self::extractType($url),
                'url' => $url,
            ];
            $temp_description = Str::replaceFirst("[$link]($url)", '', $temp_description);
        }
        // Remove the links from the description
        $description = $temp_description;
        return $links;
    }

    private static function extractType(string $link): string
    {
        $type = 'unkown';
        // If the link is just the protocol and the domain, it's a website
        $domain = Str::after($link, '://');
        if (Str::contains($link, ['http://', 'https://']) && !Str::contains($domain, '/')) {
            $type = 'website';
        }
        if (Str::contains($link, 'github.com')) {
            $type = 'github';
        }
        return $type;
    }
}

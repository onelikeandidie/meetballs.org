<?php

namespace App\Libraries\Projects;

use Illuminate\Support\Collection;

class Project
{
    public string $name;
    public string $description;
    public Collection $links;
    public Collection $tags;

    public function __construct(string $name, string $description, array $url, array $tags = [])
    {
        $this->name = $name;
        $this->description = $description;
        $this->links = collect([$url]);
        $this->tags = collect($tags);
    }

    public static function all(): array
    {
        return Parser::parse(base_path('README.md'));
    }
}

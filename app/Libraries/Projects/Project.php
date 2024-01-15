<?php

namespace App\Libraries\Projects;

use Illuminate\Support\Collection;
use Illuminate\Support\Env;
use Illuminate\Support\Str;

class Project
{
    public string $name;
    public string $description;
    public Collection $links;
    public Collection $tags;
    public bool $featured = false;
    public string $image = '';

    public function __construct(string $name, string $description, array $url, array $tags = [], bool $featured = false)
    {
        $this->name = $name;
        $this->description = $description;
        $this->links = collect([$url]);
        $this->tags = collect($tags);
        $this->featured = $featured;

        //check if image with slugged name exists in public/images/projects folder
        $this->image = $this->getImageSource($name);
    }

    public function getImageSource(string $name): string
    {
        $image = Str::slug($name) . '.jpg';
        $path = public_path('/img/projects/' . $image);
        if (file_exists($path)) {
            return $image;
        }
        return Env::get('DEFAULT_PROJECT_IMAGE', '/img/default.jpg');
    }

    public static function all(): array
    {
        return Parser::parse(base_path('README.md'));
    }
}

<?php

namespace App\Libraries\Importer;

use Illuminate\Support\Collection;

class Project
{
    public function __construct(
        public string     $name,
        public string     $description,
        public Collection $links,
        public Collection $tags,
        public bool       $featured,
    )
    {
        // ...
    }
}

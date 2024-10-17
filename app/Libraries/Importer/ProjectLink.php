<?php

namespace App\Libraries\Importer;

class ProjectLink
{
    public function __construct(
        public string $name,
        public string $url,
        public string $icon,
    )
    {
        // ...
    }
}

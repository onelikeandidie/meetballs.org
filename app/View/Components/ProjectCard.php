<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Libraries\Projects\Project;

class ProjectCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct( public Project $project ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.project-card');
    }
}

<?php

namespace App\View\Components;

use App\Libraries\Projects\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedProject extends Component
{
    /**
     * Create a new component instance.
     * @param Project|null $featuredProject
     */
    public function __construct(
        public ?Project $featuredProject
    ) {}

    /**
     * Determine if the component should be rendered.
     * Renders if there's a featured project.
     *
     * TODO: implement this method based on readme content
     *
     * @return boolean
     */
    public function shouldRender()
    {
        return $this->featuredProject !== null  && $this->featuredProject->featured;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.featured-project');
    }
}

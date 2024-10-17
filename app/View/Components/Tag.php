<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tag extends Component
{
    public ?\App\Models\Tag $tag;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
    )
    {
        $this->tag = \App\Models\Tag::where('name', $name)->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.tag');
    }
}

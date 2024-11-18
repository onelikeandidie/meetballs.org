<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class AutoToggleFeaturedProject implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // This job will fetch the featured projects and remove the "featured" tag
        $projects = Project::all();
        $featuredProjects = $projects->where(fn($project) => $project->tags->contains('featured'));
        // Remove the "featured" tag from all featured projects
        foreach ($featuredProjects as $project) {
            $project->tags = $project->tags->filter(fn($tag) => $tag !== 'featured');
            $project->save();
        }
    }
}

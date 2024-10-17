<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Next meetup is on wednesday at 7pm
        $now = now();
        if ($now->isThursday()) {
            $next_meetup = $now->setTime(19, 0, 0);
        } else {
            $next_meetup = $now->next('Thursday')->setTime(19, 0, 0);
        }
        $projects = Project::all();
        return view('home', [
            'projects' => $projects,
            'featured_project' => $projects->first(fn($project) => $project->tags->contains('featured')),
            'next_meetup' => $next_meetup,
        ]);
    }
}

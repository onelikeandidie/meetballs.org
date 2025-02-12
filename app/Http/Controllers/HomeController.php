<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        // Next meetup is on wednesday at 7pm
        $now = now();
        if ($now->isWednesday()) {
            $next_meetup = $now->setTime(19, 0, 0);
        } else {
            $next_meetup = $now->next('Wednesday')->setTime(19, 0, 0);
        }
        /** @var Collection<Project> $projects */
        $projects = Project::query()
            ->with('host')
            ->with('links')
            ->orderBy('event_date', 'desc')
            ->get();
        // Chunk them by month with the month name as the key
        $months = $projects->groupBy(function (Project $project) {
            return $project->event_date?->format('F Y') ?? 'Unsorted';
        });
        return view('home', [
            'months' => $months,
            'next_meetup' => $next_meetup,
        ]);
    }
}

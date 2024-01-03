<?php

namespace App\Http\Controllers;

use App\Libraries\Projects\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(Request $request)
    {
        if (config('app.env') === 'local') {
            $projects = Project::all();
        } else {
            $projects = cache()->remember('projects', 60, function () {
                return Project::all();
            });
        }
        return view('home', [
            'projects' => $projects,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Host;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HostController extends Controller
{
    public function show(Host $host)
    {
        return view('host.show', compact('host'));
    }

    public function create(Request $request)
    {
        Gate::authorize('create', Host::class);

        return view('host.show');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Host::class);

        $input = $request->validate([
            'name'
        ]);
    }
}

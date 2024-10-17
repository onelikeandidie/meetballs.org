@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-96 py-28 bg-neutral-800 text-white">
        <div class="font-mono">
            <h1 class="text-4xl sm:text-6xl mb-8">
                <span>&lt;</span>Meetballs<span>/&gt;</span>
            </h1>
            <p class="uppercase text-xl">
                Premium meet
                <br/>
                from local
                <br/>
                tech suppliers
                <br/>
                <br/>
                Brewed with
                <br/>
                geek love
                <x-heroicon-o-heart class="h-6 w-6 inline-block"/>
            </p>
        </div>
    </div>
    <div class="bg-amber-800 text-white p-4 text-center text-xl">
        <p>
            Wednesdays at 19:00, IKEA Loulé
        </p>
        <p class="font-bold">
            <span>Next meet:</span>
            @if($next_meetup->isToday() && $next_meetup->isFuture())
                <span>Today</span>
                <span>{{ $next_meetup->diffForHumans() }}</span>
                ({{ $next_meetup->format('H:i') }})
            @else
                <span>{{ $next_meetup->format('l, F jS') }}</span>
            @endif
        </p>
        @if($featured_project)
            <div class="flex items-center justify-center p-4">
                <x-project.featured :project="$featured_project"/>
            </div>
        @endif
    </div>
    <div class="container mx-auto my-8">
        <h2 class="text-3xl font-bold text-center mb-8">
            Projects
        </h2>
        <div class="columns-1 sm:columns-2 md:columns-3 xl:columns-4">
            @foreach($projects as $project)
                <x-project.card :project="$project"
                                class="w-full inline-block"/>
            @endforeach
        </div>
    </div>
@endsection

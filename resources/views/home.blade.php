@extends('layouts.app')

@section('meta')
    <meta name="title" content="Meetballs - Premium meet from local tech suppliers">
    <meta name="description" content="A community of tech enthusiasts that meet weekly to share their projects and ideas.">
    <meta name="keywords" content="meetballs, tech, community, projects, ideas">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    @if($featured_project)
        <meta property="image" content="{{ route('project.image', $featured_project) }}">
        <meta property="og:image" content="{{ route('project.image', $featured_project) }}">
    @endif
@endsection

@section('nav')
@endsection

@section('body-class')
    bg-neutral-900 text-white
@endsection

@section('content')
    <div class="flex items-center justify-center min-h-96 py-28 bg-transparent text-white">
        <div class="flex items-end font-mono">
            <div class="">
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
            <p class="bg-amber-800 text-white p-4 font-bold">
                    Wednesdays @ 19:00, IKEA Loulé
            </p>
        </div>
    </div>
    <div class="bg-gradient-to-b from-amber-800 to-transparent text-white p-4 text-center text-xl">
        <p class="font-bold">
            <span>Next meet:</span>
            @if($next_meetup->isToday() && $next_meetup->isFuture())
                <span>{{ __("Today") }}</span>
                <span>{{ $next_meetup->diffForHumans() }}</span>
                ({{ $next_meetup->format('H:i') }})
            @else
                <span>{{ $next_meetup->format('F jS') }}</span>
            @endif
        </p>
        @if($featured_project)
            <div class="flex items-center justify-center p-4">
                <x-project.featured :project="$featured_project"/>
            </div>
        @endif
    </div>
    @if($featured_project)

    @endif
    <div class="container mx-auto my-8 text-white">
        <h2 class="text-3xl font-bold text-center mb-8">
            Past Sessions
        </h2>
        <div class="columns-1 md:columns-2 lg:columns-3 2xl:columns-4">
            @foreach($projects as $project)
                <x-project.card :project="$project"
                                class="w-full inline-block"/>
            @endforeach
        </div>
    </div>
@endsection

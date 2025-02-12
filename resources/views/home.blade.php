@extends('layouts.app')

@section('meta')
    <meta name="title" content="Meetballs - A GeekSessions meetup in Algarve">
    <meta name="description"
          content="A community of tech enthusiasts that meet weekly to share their projects and ideas. Part of the GeekSessions network.">
    <meta name="keywords" content="meetballs, tech, community, projects, ideas">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    @if($months->isNotEmpty() && $months->first()->first()->event_date?->isFuture())
        <meta property="image" content="{{ route('project.image', $featured_project) }}">
        <meta property="og:image" content="{{ route('project.image', $featured_project) }}">
    @endif
@endsection

@section('nav')
@endsection

@section('body-class')
    bg-gray-900 bg-dots-gray-700 bg-size-[40px] text-white
@endsection

@section('content')
    <nav
        class="flex items-center justify-around h-48 md:h-72 bg-white text-gray-900 fixed left-0 top-0 right-0 transition-[height] duration-500"
        x-bind:class="{'h-48 md:h-72': isAtTop, 'h-12 md:h-16': !isAtTop}"
        x-data="{
            isAtTop: true,
            init() {
                window.addEventListener('scroll', () => {
                    this.isAtTop = window.scrollY < 100;
                });
            }
        }">
        <div class="flex gap-2 transition-[opacity]" x-bind:class="{'opacity-100': isAtTop, 'opacity-0': !isAtTop}">
            {{-- Probably put some links in here --}}
        </div>
        <a class="text-center flex-1 relative"
           href="{{ route('home') }}">
            <h1 class="text-4xl md:text-8xl font-display transition-[font-size] duration-750"
                x-bind:class="{'text-4xl md:text-8xl': isAtTop, 'text-2xl md:text-2xl': !isAtTop}">
                <span class="text-amber-800">&lt;</span>Meetballs<span class="text-amber-800">/&gt;</span>
            </h1>
            <p class="text-lg md:text-2xl font-display transition-[opacity] duration-750 absolute w-full"
               x-bind:class="{'opacity-100': isAtTop, 'opacity-0': !isAtTop}">
                A GeekSessions meetup in Algarve
            </p>
        </a>
        <div class="flex gap-2 transition-[opacity] justify-end"
             x-bind:class="{'opacity-100': isAtTop, 'opacity-0': !isAtTop}">
            {{-- Probably put some links in here --}}
        </div>
    </nav>
    <div class="h-48 md:h-72">

    </div>
    <div class="p-8">
        @foreach($months as $month => $projects)
            <div>
                <div class="sticky top-18">
                    <h2 class="text-3xl font-bold">
                        <span class="h-6 w-6 bg-gray-200 border-2 border-gray-200 rounded-full outline-4 outline-gray-900 inline-block"></span>
                        {{ $month }}
                    </h2>
                </div>
                <div class="flex">
                    <div class="w-1 mx-2.5 bg-gray-200 rounded"></div>
                    <div class="flex-1">
                        @foreach($projects as $project)
                            <x-project.card :project="$project"/>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

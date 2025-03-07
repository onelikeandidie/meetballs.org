@extends('layouts.app')

@section('meta')
    <meta name="title" content="Meetballs - A GeekSessions meetup in Algarve">
    <meta name="description"
          content="A community of tech enthusiasts that meet weekly to share their projects and ideas. Part of the GeekSessions network.">
    <meta name="keywords" content="meetballs, tech, community, projects, ideas">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    @if($next_project)
        <meta property="image" content="{{ route('project.image', $next_project) }}">
        <meta property="og:image" content="{{ route('project.image', $next_project) }}">
    @endif
@endsection

@section('nav')
@endsection

@section('body-class')
    bg-gray-900 bg-dots-gray-700 bg-repeat bg-[length:40px_40px] text-white
@endsection

@section('content')
    <nav
        class="flex items-center justify-around h-48 md:h-72 bg-white text-gray-900 fixed left-0 top-0 right-0 transition-[height] duration-500 z-20"
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
    <div class="h-48 md:h-72 bg-white">
    </div>
    {{-- Show off the next meetup --}}
    <div class="p-8 bg-white text-black z-10">
        <div class="mx-auto container relative">
            <span class="hidden md:inline-block h-6 w-6 absolute left-8 top-0 bg-gray-900 rounded-full"></span>
            <div class="hidden md:block w-1 absolute left-8 top-8 -bottom-8 mx-2.5 bg-gray-600 rounded-t"></div>
            <div class="flex flex-col items-center justify-center gap-4">
                @if($next_project)
                    <div x-data='{ eventDate: new Date(@json($next_project->event_date)) }'>
                        <h2 class="text-3xl font-bold">
                            {{ __("Next Meetup") }}
                            <noscript>
                                <span>
                                    {{ $next_project->event_date->diffForHumans() }}
                                </span>
                            </noscript>
                            <span x-text="window.utils.formatHumanDuration((new Date() - eventDate) / 1000)">
                                {{ $next_project->event_date->diffForHumans() }}
                            </span>
                        </h2>
                        <p class="text-center" x-text="eventDate.toLocaleString()">
                            {{ $next_project->event_date->format('d-m-Y H:i') }}
                        </p>
                    </div>
                    <x-project.poster class="w-full md:w-2/3 lg:w-1/2"
                        :project="$next_project"/>
                @else
                    <h2 class="text-3xl font-bold">{{ __("No Meetups Scheduled") }}</h2>
                    <p class="text-lg">{{ __("Check back later for more meetups.") }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="p-8 mx-auto container">
        @foreach($months as $month => $projects)
            <div>
                @if($loop->first)
                    <div class="w-1 h-12 mx-2.5 bg-gray-600 -mt-8 rounded-b"></div>
                @endif
                <div class="sticky top-20">
                    <h2 class="text-3xl font-bold">
                        <span
                            class="h-6 w-6 bg-gray-50 border-2 border-gray-50 rounded-full inline-block align-middle"></span>
                        <span class="bg-gray-50 font-display text-black inline-block px-2 py-1 rounded shadow">
                            {{ $month }}
                        </span>
                    </h2>
                </div>
                <div class="flex">
                    <div class="w-1 mx-2.5 bg-gray-600 rounded"></div>
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

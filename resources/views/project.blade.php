@extends('layouts.app')

@section('meta')
    <meta name="title" content="{{ $project->name }} - Meetballs">
    <meta name="description" content="{{ $project->description }}">
    <meta name="keywords" content="meetballs, tech, community, projects, ideas, {{ $project->tags->implode(', ') }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    @if($project)
        <meta property="image" content="{{ route('project.image', $project) }}">
        <meta property="og:image" content="{{ route('project.image', $project) }}">
    @endif
@endsection

@section('body-class')
    bg-neutral-900 text-white
@endsection

@section('content')
    <div class="min-h-96 my-4 container mx-auto">
        <article class="prose prose-invert mx-auto p-2">
            <h1>
                {{ $project->name }}
            </h1>
            <p>
                {{ $project->description }}
            </p>
        </article>
        <div class="w-full md:w-[65ch] mx-auto p-2">
            <div class="text-sm text-neutral-200 m-2">
                <div class="inline-block">
                    @foreach($project->tags as $index => $tag)
                        <x-tag :name="$tag"/>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center mt-2">
                @if($project->host)
                    <div>
                        <p class="text-sm text-neutral-200">
                            {{ __("Hosted by") }}
                        </p>
                        <x-avatar :host="$project->host"/>
                    </div>
                @endif
                <div class="flex flex-1 items-center justify-end gap-2 m-2">
                    @foreach($project->links as $index => $link)
                        <a href="{{ $link->url }}" class="text-neutral-400 hover:text-white">
                            @svg($link->icon, 'w-6 h-6')
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

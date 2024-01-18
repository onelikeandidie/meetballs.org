<x-layouts.app>
    <div class="flex items-center justify-center min-h-96 py-28 bg-neutral-800 text-white">
        <div class="font-mono">
            <h1 class="text-6xl mb-8">
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
                <x-icon.heroicon.outline.heart class="inline-block w-5 h-5 text-white-500"/>
            </p>
        </div>
    </div>
    <div class="bg-amber-800 text-white p-4 text-center text-xl">
        <p>
            Wednesdays at IKEA Loulé
        </p>
        {{-- Time till next meet --}}
        {{-- Meetings are on Wednesdays from 19:00 to 21:00 --}}
        <p class="font-bold">
            <span>Next meet:</span>
            {{-- Format: Wednesday 20th, 19:00 --}}
            {{-- Check if today is wednesday --}}
            @if(\Carbon\Carbon::now()->isWednesday())
                @php($nextMeet = \Carbon\Carbon::parse('today 19:00'))
            @else
                @php($nextMeet = \Carbon\Carbon::parse('next wednesday 19:00'))
            @endif
            <span>{{ $nextMeet->format('l jS, H:i') }}</span>
        </p>
        @if ($featuredProject)
            <div class="flex items-center justify-center p-4">
                <x-featured-project :featured_project="$featuredProject"></x-featured-project>
            </div>
        @endif
    </div>
    <div class="container mx-auto my-8">
        <h2 class="text-3xl font-bold text-center mb-8">
            Projects
        </h2>
        <div class="flex flex-wrap">
            @foreach($projects as $project)
                <x-project-card :project="$project"></x-project-card>
            @endforeach
        </div>
    </div>
</x-layouts.app>

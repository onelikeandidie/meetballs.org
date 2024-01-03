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
            <span>{{ \Carbon\Carbon::parse('next wednesday 19:00')->format('l jS, H:i') }}</span>
        </p>
    </div>
    <div class="container mx-auto my-8">
        <h2 class="text-3xl font-bold text-center mb-8">
            Projects
        </h2>
        <div class="flex flex-wrap">
            @foreach($projects as $project)
                <div class="flex-shrink basis-full sm:basis-1/2 lg:basis-1/3 xl:basis-1/4 p-2">
                    <div class="rounded-lg border border-neutral-400 p-2">
                        <a class="text-xl font-bold text-blue-600 hover:underline"
                           href="{{ $project->links->first()['url'] }}">
                            {{ $project->name }}
                        </a>
                        <p class="text-sm text-neutral-600">
                            @foreach($project->tags as $tag)
                                <span>{{ $tag }}</span>
                                @if(!$loop->last)
                                    <span class="rounded-full inline-block align-middle bg-neutral-600 w-1 h-1"></span>
                                @endif
                            @endforeach
                        </p>
                        <p class="text-sm text-neutral-800">
                            {{ $project->description }}
                        </p>
                        <div class="flex items-center justify-end gap-2 m-2">
                            @foreach($project->links as $link)
                                <a href="{{ $link['url'] }}" class="text-neutral-600 hover:text-neutral-800">
                                    @if($link['type'] === "website")
                                        <x-icon.heroicon.outline.globe-alt class="inline-block w-5 h-5"/>
                                    @endif
                                    @if($link['type'] === "github")
                                        <x-icon.fontawesome.github class="inline-block w-5 h-5"/>
                                    @endif
                                    @if($link['type'] === "unknown")
                                        <x-icon.heroicon.outline.arrow-top-right-on-square class="inline-block w-5 h-5"/>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>

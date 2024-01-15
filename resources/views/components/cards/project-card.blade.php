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

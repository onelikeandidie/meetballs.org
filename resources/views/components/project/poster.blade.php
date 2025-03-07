<div {{ $attributes->merge(['class' => 'relative']) }}>
    @if($project->host)
        <div class="absolute top-4 right-4">
            <img class="w-16 h-16 rounded-full border-2 border-amber-300 bg-white"
                 src="{{ $project->host->image->url }}"
                 alt="{{ $project->host->name }} profile picture"/>
        </div>
    @endif
    <div class="rounded-lg shadow-sm border border-neutral-600 bg-neutral-100">
        @if($project->image)
            <img class="w-full h-48 object-cover rounded-t-lg"
                 src="{{ $project->image->url }}"
                 alt="{{ $project->name }} project image"/>
        @else
            <img class="w-full h-48 object-cover rounded-t-lg"
                 src="{{ asset('images/default.jpg') }}"
                 alt="{{ $project->name }} project image"/>
        @endif
        <div class="p-4">
            <div class="text-sm my-1">
                <div class="inline-block">
                    @foreach($project->tags as $index => $tag)
                        <x-tag :name="$tag"/>
                    @endforeach
                </div>
            </div>
            <a class="text-xl font-bold text-blue-600 hover:underline"
               href="@if($project->links){{ $project->links->first()?->url }}@endif">
                {{ $project->name }}
            </a>
            <p class="text-sm text-wrap">
                {{ $project->description }}
            </p>
            <div class="flex items-center justify-between mt-2">
                <a href="{{ route('project.show', $project) }}" class="hover:text-blue-600">
                    {{ __("details") }}
                    <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4 inline-block"/>
                </a>
                <div class="flex flex-1 items-center justify-end gap-2 m-2">
                    @foreach($project->links as $index => $link)
                        <a href="{{ $link->url }}" class="hover:text-blue-600">
                            @svg($link->icon, 'w-6 h-6')
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

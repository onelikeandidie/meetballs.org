<div class="max-w-sm w-full lg:max-w-lg lg:flex text-left">
    <div class="rounded-lg bg-neutral-800 text-white p-4 flex flex-col justify-between leading-normal space-y-4">
        @if($project->host)
            <div class="flex-wrap">
                <x-avatar :size="'w-12 h-12'" :host="$project->host">
                    <span class="text-neutral-200">{{ __("is hosting") }}</span>
                </x-avatar>
            </div>
        @else
            {{-- Just show the dummy pic --}}
            <div
                class="h-48 lg:h-auto lg:w-48 -mx-4 -mt-4 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                style="background-image: url('{{ asset('images/default.jpg') }}')" title="featured project image">
            </div>
        @endif
        <div class="font-bold text-xl my-2">
            <a class="text-2xl font-bold text-blue-600 hover:underline"
               href="@if($project->links){{ $project->links->first()?->url }}@endif">
                {{ $project->name }}
            </a>
        </div>
        <p class="text-neutral-200 text-base mb-2">
            {{ $project->description }}
            <a href="{{ route('project.show', $project) }}" class="text-neutral-400 hover:text-white">
                    {{ __("details") }}
                <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4 inline-block"/>
            </a>
        </p>
        <p class="text-sm text-neutral-400 mb-2">
            @foreach($project->tags as $index => $tag)
                <x-tag class="mb-1 mr-1"
                       :name="$tag"/>
            @endforeach
        </p>
        <div class="flex items-center mt-2">
            <div class="flex flex-1 items-center justify-end gap-2 m-2">
                @foreach($project->links as $index => $link)
                    <a href="{{ $link->url }}" class="text-neutral-600 hover:text-neutral-800">
                        @svg($link->icon, 'w-6 h-6')
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

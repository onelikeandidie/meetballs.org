<div class="max-w-sm w-full lg:max-w-lg lg:flex text-left">
    <div class="border rounded-lg bg-white p-4 flex flex-col justify-between leading-normal ">
        @if($project->host)
            <div class="text-gray-900 flex-wrap">
                <x-avatar :host="$project->host">
                    <span class="text-gray-700">{{ __("is hosting") }}</span>
                </x-avatar>
            </div>
        @else
            {{-- Just show the dummy pic --}}
            <div
                class="h-48 lg:h-auto lg:w-48 -mx-4 -mt-4 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                style="background-image: url('{{ asset('images/default.jpg') }}')" title="featured project image">
            </div>
        @endif
        <div class="text-gray-900 font-bold text-xl my-2">
            <a class="text-2xl font-bold text-blue-600 hover:underline"
               href="@if($project->links){{ $project->links->first()?->url }}@endif">
                {{ $project->name }}
            </a>
        </div>
        <p class="text-gray-700 text-base mb-2">
            {{ $project->description }}
        </p>
        <p class="text-sm text-gray-600 mb-2">
            @foreach($project->tags as $index => $tag)
                <x-tag :name="$tag"/>
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

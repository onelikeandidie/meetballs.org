<div {{ $attributes->merge(['class' => 'p-2']) }}>
    <div class="rounded-lg shadow bg-neutral-800  p-2">
        <div class="text-sm text-neutral-400 my-1">
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
        <p class="text-sm text-neutral-200">
            {{ \Illuminate\Support\Str::limit($project->description, 160) }}
            <a href="{{ route('project.show', $project) }}" class="text-neutral-400 hover:text-white">
                @if(strlen($project->description) > 160)
                    {{ __("read more") }}
                @else
                    {{ __("details") }}
                @endif
                <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4 inline-block"/>
            </a>
        </p>
        <div class="flex items-center mt-2">
            @if($project->host)
                <div>
                    <p class="text-sm text-neutral-400">
                        {{ __("Hosted by") }}
                    </p>
                    <x-avatar class="text-neutral-200"
                        :host="$project->host"/>
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

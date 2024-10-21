<div {{ $attributes->merge(['class' => 'p-2']) }}>
    <div class="rounded-lg border border-neutral-400 p-2">
        <div class="text-sm text-neutral-600 my-1 -mt-6">
            <div class="bg-white inline-block">
                @foreach($project->tags as $index => $tag)
                    <x-tag :name="$tag"/>
                @endforeach
            </div>
        </div>
        <a class="text-xl font-bold text-blue-600 hover:underline"
           href="@if($project->links){{ $project->links->first()?->url }}@endif">
            {{ $project->name }}
        </a>
        <p class="text-sm text-neutral-800">
            {{ \Illuminate\Support\Str::limit($project->description, 160) }}
            @if(strlen($project->description) > 160)
                <a href="{{ route('project.show', $project) }}" class="text-blue-600 hover:underline">
                    {{ __("read more") }}
                </a>
            @endif
        </p>
        <div class="flex items-center mt-2">
            @if($project->host)
                <div>
                    <p class="text-sm text-neutral-600">
                        {{ __("Hosted by") }}
                    </p>
                    <x-avatar :host="$project->host"/>
                </div>
            @endif
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

<div {{ $attributes->merge(["class" => "flex items-center gap-2"]) }}>
    @if($host->image)
        <img class="w-8 h-8 rounded-full" src="{{ $host->image->url }}" alt="{{ $host->name }} profile picture">
    @endif
    <span>{{ $host->name }}</span>
    {{ $slot }}
</div>

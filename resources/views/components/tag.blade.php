<span {{ $attributes->merge(['class' => 'rounded-xl inline-block align-middle border px-2 py-1']) }}
      style="color: {{ $tag?->color }}; border-color: {{ $tag?->color }}; background-color: {{ $tag?->color }}20">
    @if($tag?->icon)
        @svg($tag?->icon, 'w-5 h-5 inline-block')
    @endif
    {{ $name }}
</span>

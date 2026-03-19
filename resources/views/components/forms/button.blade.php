@php($type = 'button')
@if($attributes->has('href'))
    @php($type = 'a')
@endif

<{{$type}} {{ $attributes->merge([
    'class' => 'px-2 py-1 bg-white text-black border-b-2 border-neutral-400 outline outline-1 outline-neutral-600 rounded hover:border-b-transparent hover:-translate-y-0.5 active:translate-y-0.5',
]) }}>
    {{ $slot }}
</{{$type}}>

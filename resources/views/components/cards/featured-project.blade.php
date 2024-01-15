<div class="max-w-sm w-full lg:max-w-lg lg:flex text-left">
    <div
        class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
        style="background-image: url('{{ $featuredProject->image }}')"
        title="meatballs featured project">
    </div>
    <div
        class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white
        rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal ">
        <div>
            <p class="text-sm text-gray-600 mb-2">
                <x-icon.others.cloudmeatballs class="inline-block w-5 h-5" />
                @foreach($featuredProject->tags as $tag)
                    <span>{{ $tag }}</span>
                    @if(!$loop->last)
                        <span class="rounded-full inline-block align-middle bg-neutral-600 w-1 h-1"></span>
                    @endif
                @endforeach
            </p>
            <div class="text-gray-900 font-bold text-xl mb-2">
                <a class="text-xl font-bold text-blue-600 hover:underline"
            href="{{ $featuredProject->links->first()['url'] }}">
                {{ $featuredProject->name }}
                </a>
            </div>
            <p class="text-gray-700 text-base mb-2">
                {{ $featuredProject->description }}
            </p>
        </div>
    </div>
  </div>

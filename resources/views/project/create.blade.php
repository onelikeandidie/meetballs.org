@extends('layouts.app')

@section('body-class')
    bg-neutral-900 text-white
@endsection

@section('content')
    <div class="min-h-96 my-4 container mx-auto">
        <form class="space-y-2"
              action="{{ route('project.store') }}"
              method="POST">
            @csrf
            @method('POST')
            <h1 class="text-lg font-bold">
                Create a new Project/Session
            </h1>
            <x-forms.label>
                <p>
                    Name:
                </p>
                <x-forms.input type="text" name="name"/>
            </x-forms.label>
            @error('name')
            <p class="text-red-600">
                {{ $message }}
            </p>
            @enderror
            <x-forms.label>
                <p>
                    Description:
                </p>
                <x-forms.input.textarea class="min-w-96 resize" name="description"></x-forms.input.textarea>
                <p class="text-neutral-400">
                    You can use markdown in the description
                </p>
            </x-forms.label>
            @error('description')
            <p class="text-red-600">
                {{ $message }}
            </p>
            @enderror
            <x-forms.label>
                <p>
                    Tags:
                </p>
                <x-forms.input type="text" name="tags"/>
                <p class="text-neutral-400">
                    Use a comma-separated list
                </p>
            </x-forms.label>
            @error('tags')
            <p class="text-red-600">
                {{ $message }}
            </p>
            @enderror
            <x-forms.label>
                <p>
                    Host:
                </p>
                @if($hosts->count() > 0)
                    <x-forms.input.select name="host_id">
                        @foreach($hosts as $host)
                            <option value="{{ $host->id }}">
                                {{ $host->name }}
                            </option>
                        @endforeach
                    </x-forms.input.select>
                @else
                    <p class="text-amber-400">
                        There are no hosts configured
                    </p>
                @endif
                <x-forms.button href="{{ route('host.create') }}">
                    Create new Host
                </x-forms.button>
            </x-forms.label>
            <x-forms.label>
                <p>
                    Links:
                </p>
                <div x-data='{ links: [], icons: @json($icons) }'>
                    <ul class="p-2 flex align-top gap-2">
                        <template x-for="(link, index) in links">
                            <li class="border border-neutral-300 inline-block p-2 rounded-lg">
                                <x-forms.label>
                                    <p>
                                        Name:
                                    </p>
                                    <x-forms.input type="text"
                                                   x-bind:name="'links[' + index + '][name]'"
                                                   x-model="link.name"/>
                                </x-forms.label>
                                <x-forms.label>
                                    <p>
                                        Url:
                                    </p>
                                    <x-forms.input type="text"
                                                   x-bind:name="'links[' + index + '][url]'"
                                                   x-model="link.url"/>
                                </x-forms.label>
                                <x-forms.label x-data="{
                                                   search: '',
                                                   searchResults: [],
                                                   updateResults(s) {
                                                       console.log(icons);
                                                       let r = icons
                                                          .filter((i) => i.includes(s))
                                                          .slice(0, 25);
                                                       if (link.icon) {
                                                          r.unshift(link.icon);
                                                      }
                                                      this.searchResults = r;
                                                   }
                                               }"
                                               x-effect="updateResults(search)">
                                    <p>
                                        Icon:
                                    </p>
                                    @if($icons->count() > 0)
                                        <div class="flex flex-col">
                                            <x-forms.input.select class="rounded-b-none"
                                                                  x-bind:name="'links[' + index + '][icon]'"
                                                                  x-model="link.icon">
                                                <option value="null">Select icon</option>
                                                <template x-for="icon in searchResults">
                                                    <option x-bind:value="icon" x-text="icon"></option>
                                                </template>
                                            </x-forms.input.select>
                                            <x-forms.input type="text"
                                                           class="rounded-t-none"
                                                           placeholder="search for icon here"
                                                           x-model.debounce="search"/>
                                            <x-forms.button class="bg-amber-400 border-b-amber-200"
                                                            x-on:click="links.splice(index, 1)"
                                                            type="button">
                                                Remove
                                            </x-forms.button>
                                        </div>
                                    @else
                                        <p class="text-amber-400">
                                            There are no icons installed
                                        </p>
                                    @endif
                                </x-forms.label>
                            </li>
                        </template>
                    </ul>
                    <x-forms.button type="button" title="Add link"
                                    x-on:click="links.push({name:'',url:'',icon:''})">
                        <x-tabler-plus class="size-4 inline-block"/>
                        Add link
                    </x-forms.button>
                </div>
            </x-forms.label>
            <x-forms.button type="submit">
                Create
            </x-forms.button>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('body-class')
    bg-neutral-900 text-white
@endsection

@section('content')
    <div class="min-h-96 my-4 container mx-auto">
        <form class="space-y-2"
              action="{{ route('auth.login') }}"
              method="POST">
            @method('POST')
            @csrf
            <h1>
                Please enter your credentials
            </h1>
            <x-forms.label>
                <p>
                    Username:
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
                    Password:
                </p>
                <x-forms.input type="password" name="password"/>
            </x-forms.label>
            @error('password')
            <p class="text-red-600">
                {{ $message }}
            </p>
            @enderror
            <x-forms.button type="submit">
                Login
            </x-forms.button>
        </form>
    </div>
@endsection

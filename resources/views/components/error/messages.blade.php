@if(isset($errors) && $errors->any())
    <div class="container mx-auto">
        @foreach($errors->all() as $error)
            <x-error.message :error="$error"/>
        @endforeach
    </div>
@endif

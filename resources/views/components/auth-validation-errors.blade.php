@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }} class="alert alert-danger">
        <div class="font-medium">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

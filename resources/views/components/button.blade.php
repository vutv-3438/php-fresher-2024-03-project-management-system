<button
    {{ $attributes->merge(
    [
        'type' => 'submit',
        'class' => 'btn btn-primary btn-sm fw-bold
        text-uppercase d-inline-flex align-items-center
        rounded-md text-xs text-white hover:bg-gray-700
        active:bg-gray-900 focus:outline-none
        focus:border-gray-900 focus:ring ring-gray-300
         disabled:opacity-25 transition ease-in-out
         duration-150'
    ]) }}
>
    {{ $slot }}
</button>

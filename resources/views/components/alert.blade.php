@if(isset($type) && $type == Alert::DANGER)
    <div
        class="alert alert-danger d-flex align-items-center p-2 mb-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
        role="alert" style="color: red;">
        <svg
            class="flex-shrink-0 me-2"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            width="16"
            height="16"
            viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5
                9.5A9.51 9.51 0 0 0 10 .5ZM9.5
                4a1.5 1.5 0 1 1 0 3 1.5 1.5 0
                0 1 0-3ZM12 15H8a1 1 0 0 1
                0-2h1v-3H8a1 1 0 0 1 0-2h2a1
                1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z">
            </path>
        </svg>
        <div>
            <span class="font-medium">Danger alert!</span> {{$message}}
        </div>
    </div>
@elseif(isset($type) && $type == Alert::SUCCESS)
    <div class="alert alert-success
        d-flex align-items-center p-2
        mb-2 text-sm text-green-800
        rounded-lg bg-green-50
        dark:bg-gray-800
        dark:text-green-400"
         role="alert"
         style="color: green;"
    >
        <svg
            class="flex-shrink-0 me-2"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            width="16"
            height="16"
            viewBox="0 0 20 20"
        >
            <path d="M10 .5a9.5 9.5 0 1 0
            9.5 9.5A9.51 9.51 0 0 0 10
            .5ZM9.5 4a1.5 1.5 0 1 1 0
            3 1.5 1.5 0 0 1 0-3ZM12
            15H8a1 1 0 0 1 0-2h1v-3H8a1
            1 0 0 1 0-2h2a1 1 0 0 1 1
            1v4h1a1 1 0 0 1 0 2Z"
            >
            </path>
        </svg>
        <div>
            <span class="font-medium">Success alert!</span> {{$message}}
        </div>
    </div>
@endif

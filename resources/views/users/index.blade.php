<x-app-layout>
    @push('styles')
        <style>
            .status-square {
                width: 20px;
                height: 20px;
                display: inline-block;
                margin-right: 5px;
                border: 1px solid #ccc;
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('Admin page') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden fs-5">
                <div class="p-6 border-bottom border-gray-200">
                    {{ __('crud.list', ['object' => 'Users']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button onclick="window.location='{{ route('users.create') }}'">
                    {{ __('crud.create', ['object' => 'user']) }}
                </x-button>
            </div>

            <div class="mt-2 mb-2">
                @if(session('type') && session('msg'))
                    <x-alert :type="session('type')" :message="session('msg')" class="mt-4"/>
                @endif
            </div>

            <div class="overflow-x-auto w-full border p-3">
                <div class="hint mb-2">
                    <div class="d-flex">
                        <span class="status-square bg-danger-subtle me-2"></span>
                        {{ __('Lock') }}
                    </div>
                    <div class="d-flex">
                        <span class="status-square bg-secondary-subtle me-2"></span>
                        {{ __('Soft deleted') }}
                    </div>
                </div>
                <table id="users-table" class="divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50 p-2">
                    <tr>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Name')}}
                        </th>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Email')}}
                        </th>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Phone')}}
                        </th>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Actions')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/pages/users/index.js') }}" type="module"></script>
        <script type="module">
            const DATA = {!! json_encode($users) !!};
            const CSRF = "{{ csrf_token() }}";
            const EDIT_URL = "{{ route('users.edit', ['user' => ':id']) }}";
            const TOGGLE_LOCK_URL = "{{ route('users.toggleLock', ['user' => ':id']) }}";
            const DELETE_URL = "{{ route('users.destroy', ['user' => ':id', 'projectId' => ':projectId']) }}";
            const RESTORE_URL = "{{ route('users.restore', ['user' => ':id']) }}";

            renderDataTable(DATA, EDIT_URL, DELETE_URL, CSRF, {
                msg: {
                    edit: '{{ __('Edit')}}',
                    delete: '{{ __('Delete')}}',
                    restore: '{{ __('Restore') }}',
                    toggleLock: '{{ __('Toggle lock') }}',
                },
                url: {
                    restore: RESTORE_URL,
                    toggleLock: TOGGLE_LOCK_URL,
                }
            });
        </script>
    @endpush
</x-app-layout>

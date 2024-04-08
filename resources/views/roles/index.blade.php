<x-app-layout class="d-flex">
    {{--  Sidebar  --}}
    @include('layouts.sidebar')

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('crud.list', ['object' => 'Roles']) }}</h2>
        </div>
    </x-slot>

    <div class="py-12 flex-grow-1">
        <div class="sm:pr-6 lg:pr-8">
            <div class="overflow-hidden fs-5">
                <div class="p-6 border-bottom border-gray-200">
                    {{ __('crud.list', ['object' => 'Roles']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button
                    onclick="window.location='{{ route('roles.create', ['projectId' => getRouteParam('projectId')]) }}'">
                    {{ __('crud.create', ['object' => 'role']) }}
                </x-button>
            </div>

            <div class="mt-2 mb-2">
                @if(session('type') && session('msg'))
                    <x-alert :type="session('type')" :message="session('msg')" class="mt-4"/>
                @endif
            </div>

            <div class="overflow-x-auto w-full border p-3 w-full col-12">
                <table id="roles-table" class="cell-border table table-bordered" style="width:100%">
                    <thead class="bg-gray-50 p-2">
                    <tr>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Name') }}
                        </th>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Description') }}
                        </th>
                        <th scope="col"
                            class="border px-6 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Actions') }}
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
        <script src="{{ asset('js/pages/roles/index.js') }}" type="module"></script>
        <script type="module">
            const DATA = {!! json_encode($roles) !!};
            const CSRF = "{{ csrf_token() }}";
            const EDIT_URL = "{{ route('roles.edit', ['role' => ':id', 'projectId' => ':projectId']) }}";
            const DELETE_URL = "{{ route('roles.destroy', ['role' => ':id', 'projectId' => ':projectId']) }}";

            renderDataTable(DATA, EDIT_URL, DELETE_URL, CSRF, {
                msg: {
                    edit: '{{ __('Edit')}}',
                    delete: '{{ __('Delete')}}',
                },
                changeRoleDefaultLink: '{{ route('roles.changeDefaultRole', [
                    'projectId' => getRouteParam('projectId'),
                    'role' => ':id'
                ]) }}'
            });
        </script>
    @endpush
</x-app-layout>

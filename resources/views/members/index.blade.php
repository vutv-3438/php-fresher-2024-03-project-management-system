<x-app-layout class="d-flex">
    {{--  Sidebar  --}}
    @include('layouts.sidebar')

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('crud.list', ['object' => 'Member']) }}</h2>
        </div>
    </x-slot>

    <div class="py-12 flex-grow-1">
        <div class="sm:pr-6 lg:pr-8">
            <div class="overflow-hidden fs-5">
                <div class="p-6 border-bottom border-gray-200">
                    {{ __('crud.list', ['object' => 'Member']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button
                    onclick="window.location='{{ route('members.create', ['projectId' => getRouteParam('projectId')]) }}'">
                    {{ __('crud.invite', ['object' => 'member']) }}
                </x-button>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-2 mb-2">
                @if(session('type') && session('msg'))
                    <x-alert :type="session('type')" :message="session('msg')" class="mt-4"/>
                @endif
            </div>

            <div class="overflow-x-auto w-full border p-3 w-full col-12">
                <table id="members-table" class="cell-border table table-bordered" style="width:100%">
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
                            {{__('Role')}}
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
        <script src="{{ asset('js/pages/members/index.js') }}" type="module"></script>
        <script type="module">
            const DATA = {!! json_encode($members) !!};
            const CSRF = "{{ csrf_token() }}";
            const EDIT_URL = "{{ route('members.update', ['member' => ':id', 'projectId' => $projectId]) }}";
            const DELETE_URL = "{{ route('members.destroy', ['member' => ':id', 'projectId' => $projectId]) }}";
            const ROLES = {!! json_encode($roles) !!};

            renderDataTable(DATA, EDIT_URL, DELETE_URL, CSRF, {
                roles: ROLES,
                projectId: {{ $projectId }},
                renderDeleteFormSection: (data) => {
                    return `<input type="hidden" name="role_id" value="${data.roles[0].id}">`;
                },
                msg: {
                    delete: '{{ __('Delete')}}'
                }
            });
        </script>
    @endpush
</x-app-layout>

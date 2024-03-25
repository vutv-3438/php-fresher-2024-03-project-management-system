<x-app-layout class="d-flex container mt-5">
    <x-slot name="navigation">
        @include('layouts.navigation', ['extendedClasses' => '!max-w-none'])
    </x-slot>

    {{--  Sidebar  --}}
    @include('layouts.sidebar')

    <x-slot name="header">
        <h2 class="font-weight-bold h5 text-dark mb-0 fs-4 py-2">
            {{ __('crud.list', ['object' => 'Workflow']) }}
        </h2>
    </x-slot>

    <div class="py-12 flex-grow-1">
        <div class="sm:pr-6 lg:pr-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('crud.list', ['object' => 'Workflow']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button
                    onclick="window.location='{{ route('workFlows.create', ['projectId' => request()->route()->parameter('projectId')]) }}'">
                    {{ __('crud.create', ['object' => 'workflow']) }}
                </x-button>
            </div>

            <div class="mt-2 mb-2">
                @if(session('type') && session('msg'))
                    <x-alert :type="session('type')" :message="session('msg')" class="mt-4"/>
                @endif
            </div>

            <div class="overflow-x-auto w-full border p-3 w-full col-12">
                <table id="workflow-table" class="border-separate divide-y divide-gray-200 border w-100">
                    <thead class="bg-gray-50 p-2">
                    <tr>
                        <th scope="col"
                            class="border px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="border px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Title')}}
                        </th>
                        <th scope="col"
                            class="border px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Description')}}
                        </th>
                        <th scope="col"
                            class="border px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
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
        <script type="module">
            $(document).ready(function () {
                $('#workflow-table').DataTable({
                    processing: true,
                    serverSide: false,
                    data: {!! json_encode($workFlows) !!},
                    columnDefs: [
                        {"className": "text-center", "targets": "_all"}
                    ],
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'title', name: 'title'},
                        {data: 'description', name: 'description'},
                        {
                            data: null,
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            render: function (data, type, full, meta) {
                                let editUrl = "{{ route('workFlows.edit', ['workFlow' => ':id', 'projectId' => ':projectId']) }}";
                                editUrl = editUrl.replace(':id', data.id).replace(':projectId', data.project_id);

                                let deleteUrl = "{{ route('workFlows.destroy', ['workFlow' => ':id', 'projectId' => ':projectId']) }}";
                                deleteUrl = deleteUrl.replace(':id', data.id).replace(':projectId', data.project_id);

                                return '<a href="' + editUrl + '" class="btn btn-sm btn-info mr-2 text-blue">Edit</a>' +
                                    '<form method="POST" action="' + deleteUrl + '" class="inline">' +
                                    '@csrf' +
                                    '@method("DELETE")' +
                                    '<button type="submit" class="btn btn-danger btn-sm">Delete</button>' +
                                    '</form>';
                            }
                        }
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>

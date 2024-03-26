<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('crud.update', ['object' => 'work flow']) }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ __('crud.update', ['object' => 'Work flow']) }}
                            </h5>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>
                                                <x-alert type="danger" :message="$error"/>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('type') && in_array(session('type'), ['success', 'danger']) && session('msg'))
                                <x-alert :type="session('type')" :message="session('msg')"/>
                            @endif
                            <form
                                action="{{ route('workFlows.update', ['workFlow' => $workFlow->id, 'projectId' => request()->route()->parameter('projectId')]) }}"
                                method="POST"
                                class="border p-3 rounded"
                            >
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="title" class="form-label">{{__('Title')}}</label>
                                    <input type="text" id="title" name="title" class="form-control"
                                           value="{{ $workFlow->title }}">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">{{__('Description')}}</label>
                                    <textarea id="description" name="description"
                                              class="form-control">{{ $workFlow->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="steps" class="form-label">{{__('Steps list')}}</label>
                                    <div class="overflow-x-auto w-full border p-3 w-full col-12">
                                        <table id="steps-table" class="cell-border table table-bordered"
                                               style="width:100%">
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
                                                    {{__('Description')}}
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
                                <a href="{{ route('workFlowSteps.create', ['workFlowId' => $workFlow->id, 'projectId' => getRouteParam('projectId')]) }}"
                                   class="underline text-primary">{{ __('Add work flow step') }}</a>
                                <div class="mt-4 mb-4">
                                    <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                                    <a class="underline"
                                       href="{{ route('workFlows.index', ['projectId' => request()->route()->parameter('projectId')]) }}">{{ __('Go Back') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="module">
            const columns = [
                {title: ''},
            ]
            $(document).ready(function () {
                $('#steps-table').DataTable({
                    processing: true,
                    serverSide: false,
                    data: {!! json_encode($workFlow->workFlowSteps) !!},
                    columnDefs: [
                        {"className": "text-center", "targets": "_all"},
                    ],
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'description', name: 'description'},
                        {
                            data: null,
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            render: function (data, type, full, meta) {
                                let editUrl = "{{ route('workFlowSteps.edit', ['workFlowId' => $workFlow->id, 'workFlowStep' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
                                editUrl = editUrl.replace(':id', data.id);

                                let deleteUrl = "{{ route('workFlowSteps.destroy', ['workFlowId' => $workFlow->id, 'workFlowStep' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
                                deleteUrl = deleteUrl.replace(':id', data.id);

                                return `<a href = "${editUrl}" class="d-inline-block mr-2 text-blue underline">Edit</a>
                                <a class="btn btn-reset text-danger text-decoration-underline delete-record" onclick="deleteRecord(${data.id})">Delete</button>
                                <form id="delete-form-${data.id}" method="POST" action="${deleteUrl}">
                                    @csrf
                                @method("DELETE")
                                </form>`;
                            }
                        }
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>

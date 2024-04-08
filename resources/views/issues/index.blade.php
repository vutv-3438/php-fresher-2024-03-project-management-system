<x-app-layout class="d-flex" :wFull="true">
    {{--  Sidebar  --}}
    @include('layouts.sidebar')

    @push('styles')
        <style>
            td:not(:nth-child(5)) {
                vertical-align: middle;
            }
        </style>
    @endpush

    <div class="py-12 flex-grow-1">
        <div class="sm-6 lg-8">
            <div class="overflow-hidden fs-5">
                <div class="p-6 border-bottom border-gray-200">
                    {{ __('crud.list', ['object' => 'Issue']) }}
                </div>
            </div>

            <div class="mt-4 mb-4">
                <x-button onclick="window.location='{{ route('issues.create', ['projectId' => $project->id]) }}'">
                    {{ __('crud.create', ['object' => 'issue']) }}
                </x-button>
            </div>

            <div class="mt-2 mb-2">
                @if(session('type') && session('msg'))
                    <x-alert :type="session('type')" :message="session('msg')" class="mt-4"/>
                @endif
            </div>

            <div class="table-responsive overflow-auto">
                <table id="issues-table" class="table table-bordered" style="width: 100%;">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="text-center text-uppercase">#</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Type')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Status')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Priority')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Subject')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Assignee')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Due date')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Est time')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('% Done')}}</th>
                        <th scope="col" class="text-center text-uppercase">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/pages/issues/index.js') }}" type="module"></script>
        <script type="module">
            const CSRF = "{{ csrf_token() }}";
            const DETAIL_URL = "{{ route('issues.show', ['issue' => ':id', 'projectId' => ':projectId']) }}";
            const DELETE_URL = "{{ route('issues.destroy', ['issue' => ':id', 'projectId' => ':projectId']) }}";
            const GET_URL = "{{ route('issues.getAllByProjectId', ['projectId' => $project->id]) }}";

            renderDataTable(null, DETAIL_URL, DELETE_URL, CSRF, {
                msg: {
                    edit: '{{ __('Detail') }}', delete: '{{ __('Delete') }}'
                },
                getUrl: GET_URL,
            });
        </script>
    @endpush
</x-app-layout>

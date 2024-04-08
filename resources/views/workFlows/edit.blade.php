<x-app-layout>
    {{-- Page navigation--}}
    <x-slot name="navigation"></x-slot>

    <style>
        td {
            width: 150px; /* Đặt độ rộng của các cột */
        }
    </style>

    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ __('crud.update', ['object' => 'flow']) }}
                            </h5>

                            @if ($errors->any())
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            <x-alert type="danger" :message="$error"/>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            @if (session('type') && in_array(session('type'), ['success', 'danger']) && session('msg'))
                                <x-alert :type="session('type')" :message="session('msg')"/>
                            @endif
                            <form
                                action="{{ route('workFlows.update', ['workFlow' => $workFlow->id, 'projectId' => getRouteParam('projectId')]) }}"
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
                                    <label for="description"
                                           class="form-label">{{__('Description')}}</label>
                                    <textarea id="description" name="description"
                                              class="form-control">{{ $workFlow->description }}</textarea>
                                </div>
                                <input name="project_id" type="hidden"
                                       value="{{getRouteParam('projectId')}}"/>
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
                                    <a href="{{ route('workFlowSteps.create', ['workFlowId' => $workFlow->id, 'projectId' => getRouteParam('projectId')]) }}"
                                       class="underline text-primary">{{ __('Add work flow step') }}</a>
                                </div>
                                <div class="mb-3">
                                    <label for="steps" class="form-label">{{__('Setting next steps')}}</label>
                                    <div>
                                        <table class="table table-borderless">
                                            <thead>
                                            <tr>
                                                <th class="border text-center"
                                                    style="width: 150px;">{{ __('Current Status') }}</th>
                                                <th
                                                    class="border text-center"
                                                    colspan="{{ count($workFlow->workFlowSteps) }}">
                                                    {{ __('Next Statuses Allowed') }}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="border"></td>
                                                @foreach($workFlow->workFlowSteps as $step)
                                                    <td class="border text-center">{{ $step->name }}</td>
                                                @endforeach
                                            </tr>
                                            @foreach($workFlow->workFlowSteps as $currentStep)
                                                <tr>
                                                    <td class="border text-center">{{ $currentStep->name }}</td>
                                                    @foreach($workFlow->workFlowSteps as $nextStep)
                                                        <td class="border text-center">
                                                            <input
                                                                name="next_steps[{{$currentStep->id}}][]"
                                                                value="{{$nextStep->id}}"
                                                                type="checkbox"
                                                                style="transform: scale(1.5);"
                                                                {{ in_array($currentStep->id, $nextStep->previousStatuses->pluck('id')->all()) ? 'checked' : '' }}
                                                            >
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="mt-4 mb-4">
                                    <button type="submit" class="btn btn-primary me-2">{{__('Update')}}</button>
                                    <a class="underline"
                                       href="{{ route('workFlows.index', ['projectId' => getRouteParam('projectId')]) }}">{{ __('Go Back') }}</a>
                                </div>
                            </form>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
            <script src="{{ asset('js/pages/workFlows/edit.js') }}" type="module"></script>
            <script type="module">
                const EDIT_URL = "{{ route('workFlowSteps.edit', ['workFlowId' => $workFlow->id, 'workFlowStep' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
                const DELETE_URL = "{{ route('workFlowSteps.destroy', ['workFlowId' => $workFlow->id, 'workFlowStep' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
                const DATA = {!! json_encode($workFlow->workFlowSteps) !!};
                const CSRF = "{{ csrf_token() }}";

                renderDataTable(DATA, EDIT_URL, DELETE_URL, CSRF, {
                    edit: '{{ __('Edit') }}',
                    delete: '{{ __('Delete') }}'
                });
            </script>
    @endpush
</x-app-layout>

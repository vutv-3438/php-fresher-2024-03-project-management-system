<x-app-layout :wFull="true">
    @push('links')
        <link rel="stylesheet" href="{{asset('css/quill.bubble.css')}}">
        <link rel="stylesheet" href="{{asset('css/quill.snow.css')}}">
        <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
        <script src="{{asset('js/quill.js')}}" type="module"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>
    @endpush
    @push('styles')
        <style>
            #editor {
                width: 100%;
                margin: 0 auto;
            }

            div[id^="editor"] .ql-editor {
                width: 100%;
                min-height: 200px;
            }

            .ql-toolbar {
                background-color: white;
            }

            td:not(:nth-child(5)) {
                vertical-align: middle;
            }
        </style>
    @endpush
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold text-dark mb-0 fs-4 py-2">{{ __('crud.update', ['object' => 'Issue']) }}</h2>
        </div>
    </x-slot>

    <div class="py-12 mb-4">
        <div class="row">
            <div>
                <div class="card shadow-sm">
                    <div class="card-body bg-white">
                        <h5 class="card-title">
                            {{ __('crud.update', ['object' => 'Issue']) }}
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

                        @if (session('type') && session('msg'))
                            <x-alert type="danger" :message="session('msg')"/>
                        @endif
                        <form
                            action="{{
                                route('issues.update',
                                ['projectId' => getRouteParam('projectId'), 'issue' => getRouteParam('issue')])
                            }}"
                            method="POST"
                            class="border p-3 rounded"
                            style="padding: 10px;"
                        >
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="form-group col-2">
                                    <label for="type">{{ __('Type') }}:</label>
                                    <span class="star-maker">*</span>
                                    <select class="form-control bg-white" id="issueType" name="issue_type_id">
                                        <option value=""
                                                disabled {{ is_null($issue->issueType) ? 'selected' : '' }}
                                        >
                                            {{ __('Choose type') }}
                                        </option>
                                        @foreach($issueTypes as $index => $issueType)
                                            <option
                                                value="{{ $issueType->id }}"
                                                {{ !is_null($issue->issueType) &&
                                                $issueType->id == $issue->issueType->id ? 'selected' : '' }}
                                            >
                                                {{ $issueType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }}</label>
                                <span class="star-maker">*</span>
                                <input type="text" id="title" name="title" class="form-control bg-white" required
                                       value="{{$issue->title}}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <input type="hidden" name="description" id="description">
                                <div id="editorDescContent" class="bg-white">
                                    {{$issue->description}}
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="status">{{ __('Status') }}:</label>
                                        <span class="star-maker">*</span>
                                        <select class="form-control bg-white" id="status" name="status_id">
                                            <option value="" disabled
                                                {{ is_null($issue->status) ? 'selected' : '' }}>{{ __('Choose status') }}
                                            </option>
                                            @foreach($statuses as $index => $status)
                                                <option
                                                    value="{{ $status->id }}"
                                                    {{ !is_null($issue->status) &&
                                                    $status->id == $issue->status->id ? 'selected' : '' }}
                                                >
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="priority">{{ __('Priority') }}:</label>
                                        <span class="star-maker">*</span>
                                        <select class="form-control bg-white" id="priority" name="priority">
                                            <option value="" disabled
                                                {{ is_null($issue->priority) ? 'selected' : '' }}>
                                                {{ __('Choose priority') }}
                                            </option>
                                            @foreach(App\Common\Enums\Priority::toArray() as $index => $priority)
                                                <option
                                                    value="{{ $priority }}"
                                                    {{ !is_null($issue->priority) && $priority == $issue->priority ? 'selected' : '' }}
                                                >
                                                    {{$priority}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="assignee">{{ __('Assignee') }}:</label>
                                        <select class="form-control select2 assignee" id="assignee" name="assignee_id">
                                            <option
                                                value="" {{ is_null($issue->assignee) ? 'selected' : '' }}>
                                                {{ __('Choose assignee') }}
                                            </option>
                                            @foreach($assignees as $index => $assignee)
                                                <option
                                                    value="{{ $assignee->id }}"
                                                    {{ !is_null($issue->assignee) &&
                                                    $assignee->id == $issue->assignee->id ? 'selected' : '' }}
                                                >
                                                    {{ $assignee->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="parent">{{ __('Parent task') }}:</label>
                                        <select class="form-control select2 parent-task d-block" id="parent"
                                                name="parent_issue_id">
                                            <option value="" {{ is_null($issue->parentIssue) ? 'selected' : '' }}
                                            >
                                                {{ __('None') }}
                                            </option>
                                            @foreach($issues as $index => $issueItem)
                                                @if($issueItem->id === $issue->id ||
                                                    in_array($issueItem->id, $issue->childIssues->pluck('id')->toArray()))
                                                    @continue
                                                @endif
                                                <option
                                                    value="{{ $issueItem->id }}"
                                                    {{ !is_null($issue->parentIssue) &&
                                                    $issueItem->id == $issue->parentIssue->id ? 'selected' : '' }}
                                                >
                                                    {{ $issueItem->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-4 mb-3">
                                        <label for="startDate">{{ __('Start date') }}:</label>
                                        <input class="d-block w-full" type="date" name="start_date" id="startDate"
                                               value="{{date('Y-m-d', strtotime($issue->start_date))}}"/>
                                    </div>
                                    <div class="form-group col-4 mb-3">
                                        <label for="dueDate">{{ __('Due date') }}:</label>
                                        <input class="d-block w-full" type="date" name="due_date" id="dueDate"
                                               value="{{date('Y-m-d', strtotime($issue->due_date))}}"/>
                                    </div>
                                    <div class="form-group col-4 mb-3">
                                        <label for="estTime">{{ __('Estimated time') }}:</label>
                                        <div class="d-flex align-items-center">
                                            <input class="flex-grow-1 me-2 w-full" type="number" step="0.01"
                                                   name="estimated_time" id="estTime" min="0" max="8"
                                                   value="{{$issue->estimated_time}}"/>
                                            <span>Hours</span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="progress">{{ __('%Done') }}:</label>
                                        <select class="form-control bg-white" id="progress" name="progress">
                                            @for ($i = 0; $i <= 100; $i += 10)
                                                <option
                                                value="{{ $i }}" {{ $issue->progress == $i ? 'selected' : '' }}
                                                >
                                                    {{ $i }} %
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pull_request_link" class="form-label">{{__('Pull request link')}}</label>
                                <input type="hidden" name="pull_request_link" id="pull_request_link"
                                       value="{{$issue->pull_request_link}}">
                                <div id="editorPRLinkContent" class="bg-white">
                                </div>
                            </div>
                            <input name="projectId" type="hidden"
                                   value="{{getRouteParam('projectId')}}"/>

                            <div class="mb-3">
                                <label for="steps" class="form-label">{{__('Sub tasks list')}}</label>
                                <div class="overflow-x-auto w-full border p-3 w-full col-12">
                                    <table id="child-issues-table" class="cell-border table table-bordered"
                                           style="width:100%">
                                        <thead class="bg-gray-50 p-2">
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
                            <a href="{{ route('issues.create',
                                ['projectId' => getRouteParam('projectId'), 'parentId' => getRouteParam('issue')]) }}"
                                class="underline text-primary"
                            >
                                {{ __('Add sub task') }}
                            </a>
                            <div class="mt-4 mb-4">
                                <button type="submit" class="btn btn-primary me-2">{{__('Save')}}</button>
                                <a class="underline"
                                   href="{{route('issues.index',
                                   ['projectId' => getRouteParam('projectId')])}}">{{ __('Go Back') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/pages/issues/edit.js') }}" type="module"></script>
        <script type="module">
            $(document).ready(function () {
                // Configurations
                $('.select2.parent-task').select2();
                $('.select2.assignee').select2();
                let prQuill = new Quill('#editorPRLinkContent', {
                    theme: 'snow'
                });
                let descQuill = new Quill('#editorDescContent', {
                    theme: 'snow'
                });

                // Quill
                document.querySelector('form').addEventListener('submit', function (e) {
                    e.preventDefault();
                    document.querySelector('#editorDescContent').value =
                        document.querySelector('#editorDescContent .ql-editor').innerHTML;
                    document.querySelector('#editorPRLinkContent').value =
                        document.querySelector('#editorPRLinkContent .ql-editor').innerHTML;
                });

                // Datatable
                const EDIT_URL = "{{ route('issues.edit',
                                    ['issue' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
                const DELETE_URL = "{{ route('issues.destroy',
                                    ['issue' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
                const DATA = {!! json_encode($issue->childIssues) !!};
                const CSRF = "{{ csrf_token() }}";
                renderDataTable(DATA, EDIT_URL, DELETE_URL, CSRF, {
                    edit: '{{ __('Edit') }}',
                    delete: '{{ __('Delete') }}'
                });
            });
        </script>
    @endpush
</x-app-layout>

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
        </style>
    @endpush

    {{-- Page navigation--}}
    <x-slot name="navigation"></x-slot>

    <div class="py-12 mb-4">
        <div class="row">
            <div>
                <div class="card shadow-sm">
                    <div class="card-body bg-white">
                        <h5 class="card-title">
                            {{ __('crud.create', ['object' => 'Issue']) }}
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
                            action="{{ route('issues.store', ['projectId' => getRouteParam('projectId')]) }}"
                            method="POST"
                            class="border p-3 rounded"
                            style="padding: 10px;"
                        >
                            @csrf
                            <div class="mb-3">
                                <div class="form-group col-2">
                                    <label for="type">{{ __('Type') }}:</label>
                                    <span class="star-maker">*</span>
                                    <select class="form-control bg-white" id="issueType" name="issue_type_id">
                                        <option value="" disabled selected>{{ __('Choose type') }}</option>
                                        @foreach($issueTypes as $index => $issueType)
                                            <option value="{{$issueType->id}}">{{$issueType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }}</label>
                                <span class="star-maker">*</span>
                                <input type="text" id="title" name="title" class="form-control bg-white" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <input type="hidden" name="description" id="description">
                                <div id="editorDescContent" class="bg-white">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="status">{{ __('Status') }}:</label>
                                        <span class="star-maker">*</span>
                                        <select class="form-control bg-white" id="status" name="status_id">
                                            <option value="" disabled selected>{{ __('Choose status') }}</option>
                                            @foreach($statuses as $index => $status)
                                                <option value="{{$status->id}}">{{$status->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="priority">{{ __('Priority') }}:</label>
                                        <span class="star-maker">*</span>
                                        <select class="form-control bg-white" id="priority" name="priority">
                                            <option value="" disabled selected>{{ __('Choose priority') }}</option>
                                            @foreach(App\Common\Enums\Priority::toArray() as $index => $priority)
                                                <option value="{{$priority}}">{{$priority}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="assignee">{{ __('Assignee') }}:</label>
                                        <select class="form-control select2 assignee" id="assignee" name="assignee_id">
                                            <option value="" selected>{{ __('Choose assignee') }}</option>
                                            @foreach($assignees as $index => $assignee)
                                                <option value="{{$assignee->id}}">{{$assignee->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="parent">{{ __('Parent task') }}:</label>
                                        <select class="form-control select2 parent-task d-block"
                                                id="parent"
                                                name="parent_issue_id"
                                        >
                                            <option value="" selected>{{ __('Choose parent task') }}</option>
                                            @foreach($issues as $index => $issue)
                                                <option value="{{$issue->id}}"
                                                    {{ !is_null(request()->query('parentId')) &&
                                                    request()->query('parentId') == $issue->id ? 'selected' : ''}}
                                                >
                                                    {{$issue->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-4 mb-3">
                                        <label for="startDate">{{ __('Start date') }}:</label>
                                        <input class="d-block w-full" type="date" name="start_date" id="startDate"/>
                                    </div>
                                    <div class="form-group col-4 mb-3">
                                        <label for="dueDate">{{ __('Due date') }}:</label>
                                        <input class="d-block w-full" type="date" name="due_date" id="dueDate"/>
                                    </div>
                                    <div class="form-group col-4 mb-3">
                                        <label for="estTime">{{ __('Estimated time') }}:</label>
                                        <div class="d-flex align-items-center">
                                            <input class="flex-grow-1 me-2 w-full" type="number" step="0.01"
                                                   name="estimated_time" id="estTime" min="0" max="8"/>
                                            <span>Hours</span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="progress">{{ __('%Done') }}:</label>
                                        <select class="form-control bg-white" id="progress" name="progress">
                                            @for ($i = 0; $i <= 100; $i += 10)
                                                <option value="{{ $i }}">{{ $i }}%</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pull_request_link" class="form-label">{{__('Pull request link')}}</label>
                                <input type="hidden" name="pull_request_link" id="pull_request_link">
                                <div id="editorPRLinkContent" class="bg-white">
                                </div>
                            </div>
                            <input name="projectId" type="hidden"
                                   value="{{getRouteParam('projectId')}}"/>

                            <div class="mt-4 mb-4">
                                <button type="submit" class="btn btn-primary me-2">{{__('Create')}}</button>
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

                document.querySelector('form').addEventListener('submit', function () {
                    document.querySelector('#editorDescContent').value =
                        document.querySelector('#editorDescContent .ql-editor').innerHTML;
                    document.querySelector('#editorPRLinkContent').value =
                        document.querySelector('#editorPRLinkContent .ql-editor').innerHTML;
                });
            });
        </script>
    @endpush
</x-app-layout>

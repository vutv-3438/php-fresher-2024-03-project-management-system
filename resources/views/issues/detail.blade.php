<x-app-layout :wFull="true">
    {{-- Page navigation--}}
    <x-slot name="navigation"></x-slot>

    <div class="py-12 mb-4">
        <div class="row">
            <h3>@if(isset($issue->issueType->name))
                    {{ $issue->issueType->name }}
                @endif #{{ $issue->id }} </h3>
            <div>
                <div class="card shadow-sm">
                    <div class="card-body" style="background-color: #ffffdd">
                        <!-- Display issue information -->
                        @if(isset($issue->parentIssue))
                            <div class="mb-3">
                                <a
                                    class="text-xs"
                                    href="{{ route('issues.show',
                                    [
                                        'projectId' => $project->id,
                                        'issue' => $issue->parentIssue->id
                                    ]) }}"
                                >
                                    {{ $issue->parentIssue->issueType ? $issue->parentIssue->issueType->name: '' }} #{{ $issue->parentIssue->id }}:
                                    {{ $issue->parentIssue->title }}
                                </a>
                            </div>
                        @endif
                        <div class="mb-3">
                            <h3><b>{{ $issue->title }}</b></h3>
                        </div>
                        <div class="main-information row">
                            <div class="col-4">
                                <div class="mb-3 row">
                                    <label for="status" class="form-label col-3"><b>{{ __('Status') }}:</b></label>
                                    <span class="col-3">{{ $issue->status ? $issue->status->name : '---------------' }}</span>
                                </div>
                                <div class="mb-3 row">
                                    <label for="priority" class="form-label col-3"><b>{{ __('Priority') }}:</b></label>
                                    <span class="col-3">{{ $issue->priority }}</span>
                                </div>
                                <div class="mb-3 row">
                                    <label for="assignee" class="form-label col-3"><b>{{ __('Assignee') }}:</b></label>
                                    <span class="col-3">
                                        {{ $issue->assignee ? $issue->assignee->full_name : '---------------' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3 row">
                                    <label for="start-date" class="form-label col-3"><b>{{ __('Start date') }}
                                            :</b></label>
                                    <span class="col-3">{{ date('Y-m-d', strtotime($issue->start_date))}}</span>
                                </div>
                                <div class="mb-3 row">
                                    <label for="due-date" class="form-label col-3"><b>{{ __('Due date') }}:</b></label>
                                    <span class="col-3">{{ date('Y-m-d', strtotime($issue->due_date))}}</span>
                                </div>
                                <div class="mb-3 row">
                                    <label for="progress" class="form-label col-3"><b>{{ __('%Done') }}:</b></label>
                                    <div class="col-3">
                                        <div class="progress" style="height: 15px;">
                                            <div
                                                class="progress-bar"
                                                role="progressbar"
                                                style="width: {{ $issue->progress }}%;"
                                                aria-valuenow="25"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                            >{{ $issue->progress }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="estimated-time" class="form-label col-3">
                                        <b>{{ __('Estimated time') }}:</b>
                                    </label>
                                    <span class="col-3">{{ $issue->estimated_time }} h</span>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="description mb-3">
                            <label for="estimated-time" class="form-label col-3">
                                <b>{{ __('Description') }}:</b>
                            </label>
                            <p>{{ $issue->description ?? '---------------' }}</p>
                        </div>
                        <hr />
                        <div class="mb-3">
                            <label for="pull_request_link" class="form-label"><b>{{ __('Pull request link') }}</b></label>
                            <p>{{ $issue->pull_request_link ?? '---------------' }}</p>
                        </div>
                        <hr/>
                        <div class="sub-tasks mb-3">
                            <label for="estimated-time" class="form-label col-3">
                                <b>{{ __('Sub tasks') }}:</b>
                            </label>
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

                        <!-- Link to go back -->
                        <div class="mb-3">
                            <a class="underline me-2"
                               href="{{ route('issues.edit', ['issue' => $issue->id, 'projectId' => getRouteParam('projectId')]) }}">
                                {{ __('Edit') }}
                            </a>
                            <a class="underline"
                               href="{{ route('issues.index', ['projectId' => getRouteParam('projectId')]) }}">
                                {{ __('Go Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/pages/issues/edit.js') }}" type="module"></script>
        <script type="module">
            const DETAIL_URL = "{{ route('issues.show',
                                    ['issue' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
            const DELETE_URL = "{{ route('issues.destroy',
                                    ['issue' => ':id', 'projectId' => getRouteParam('projectId')]) }}";
            const DATA = {!! json_encode($issue->childIssues) !!};
            const CSRF = "{{ csrf_token() }}";
            renderDataTable(DATA, DETAIL_URL, DELETE_URL, CSRF, {
                edit: '{{ __('Detail') }}',
                delete: '{{ __('Delete') }}'
            });
        </script>
    @endpush
</x-app-layout>

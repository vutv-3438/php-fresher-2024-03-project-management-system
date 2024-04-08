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
                        @if(isset($issue->parentIssue->issueType))
                            <div class="mb-3">
                                <a
                                    class="text-xs"
                                    href="{{ route('issues.show',
                                    [
                                        'projectId' => $project->id,
                                        'issue' => $issue->parentIssue->id
                                    ]) }}"
                                >
                                    {{ $issue->parentIssue->issueType->name }} #{{ $issue->parentIssue->id }}:
                                    {{ $issue->parentIssue->title }}
                                </a>
                            </div>
                        @endif
                        <div class="mb-3">
                            <span>{{ $issue->title }}</span>
                        </div>
                        <div class="mb-3">
                            {{ __('Added by ') }}
                            <div>{!! $issue->description !!}</div>
                        </div>
                        <div class="mb-3">
                            <div>{!! $issue->description !!}</div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Status') }}:</label>
                            <span>{{ $issue->status->name }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">{{ __('Priority') }}:</label>
                            <span>{{ $issue->priority }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="assignee" class="form-label">{{ __('Assignee') }}:</label>
                            <span>@if(isset($issue->assignee))
                                    {{ $issue->assignee->full_name }}
                                @endif</span>
                        </div>
                        <div class="mb-3">
                            <label for="parent" class="form-label">{{ __('Parent task') }}:</label>
                            @if($issue->parentIssue)
                                <span>{{ $issue->parentIssue->title }}</span>
                            @else
                                <span>{{ __('None') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">{{ __('Start date') }}:</label>
                            <span>{{ $issue->start_date }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">{{ __('Due date') }}:</label>
                            <span>{{ $issue->due_date }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="estimated_time" class="form-label">{{ __('Estimated time') }}:</label>
                            <span>{{ $issue->estimated_time }} Hours</span>
                        </div>
                        <div class="mb-3">
                            <label for="progress" class="form-label">{{ __('% Done') }}:</label>
                            <span>{{ $issue->progress }} %</span>
                        </div>
                        <div class="mb-3">
                            <label for="pull_request_link" class="form-label">{{ __('Pull request link') }}</label>
                            <span>{{ $issue->pull_request_link }}</span>
                        </div>

                        <!-- Link to go back -->
                        <div class="mb-3">
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
</x-app-layout>

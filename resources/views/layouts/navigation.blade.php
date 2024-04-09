<div class="navbar navbar-expand-md navbar-light bg-white" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">{{ __('Projects') }}</a>
        </li>
        @can(Action::VIEW_ANY, \App\Models\Issue::class)
            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('issues.index', ['projectId' => $project->id]) }}"
                >
                    {{ __('Issues') }}
                </a>
            </li>
        @endcan
        @can(Action::VIEW_ANY, \App\Models\WorkFlow::class)

            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('workFlows.index', ['projectId' => $project->id]) }}"
                >
                    {{ __('Work flows') }}
                </a>
            </li>
        @endcan
        @can(Action::VIEW_ANY, \App\Models\Role::class)
            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('roles.index', ['projectId' => $project->id]) }}"
                >
                    {{ __('Roles') }}
                </a>
            </li>
        @endcan
        @can(Action::VIEW_ANY, \App\Models\IssueType::class)
            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('issueTypes.index', ['projectId' => $project->id]) }}"
                >
                    {{ __('Issue types') }}
                </a>
            </li>
        @endcan
        @can(Action::VIEW_ANY, \App\Models\LogTime::class)
            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('logTimes.index', ['projectId' => $project->id]) }}"
                >
                    {{ __('Log times') }}
                </a>
            </li>
        @endcan
        @can(Action::VIEW_ANY, \App\Models\Member::class)
            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('members.index', ['projectId' => $project->id]) }}"
                >
                    {{ __('Members') }}
                </a>
            </li>
        @endcan
    </ul>
</div>

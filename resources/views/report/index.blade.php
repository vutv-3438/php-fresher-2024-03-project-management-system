<x-app-layout class="d-flex" :wFull="true">
    {{--  Sidebar  --}}
    @include('layouts.sidebar')

    @push('styles')
        <style>
            td:not(:nth-child(5)) {
                vertical-align: middle;
            }

            .chart {
                max-height: 300px;
                width: 100%;
            }
        </style>
    @endpush

    <div class="py-12 flex-grow-1">
        <div class="sm-6 lg-8">
            <div class="overflow-hidden fs-5">
                <div class="p-6 border-bottom border-gray-200">
                    {{ __('Statistics') }}
                </div>
            </div>
            <div class="mt-5">
                <p class="fs-5 text-center">
                    {{ __('Issues by issue types') }}
                </p>
                <canvas id="issueTypeChart" class="chart" width="400" height="400"></canvas>
            </div>
            <div class="mt-5">
                <p class="fs-5 text-center">
                    {{ __('Issues for each member') }}
                </p>
                <canvas id="issueByMemberChart" class="chart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/pages/report/index.js') }}" type="module"></script>
        <script type="module">
            const countIssueWithIssueTypeUrl = '{{ route('issues.countIssueWithIssueType', ['projectId' => $project->id]) }}';
            const countIssueWithIssueTypeByMemberUrl = '{{ route('issues.countIssueWithIssueTypeByMember', ['projectId' => $project->id]) }}';
            renderCountIssueWithIssueType(countIssueWithIssueTypeUrl);
            renderCountIssueWithIssueTypeByMember(countIssueWithIssueTypeByMemberUrl);
        </script> use DatabaseMigrations;
    @endpush
</x-app-layout>

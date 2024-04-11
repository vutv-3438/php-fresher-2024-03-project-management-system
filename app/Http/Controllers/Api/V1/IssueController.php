<?php

namespace App\Http\Controllers\Api\V1;

use App\Common\Enums\Action;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Services\Repositories\Contracts\IIssueRepository;
use App\Services\Repositories\Contracts\IIssueTypeRepository;
use App\Services\Repositories\Contracts\IUserRepository;
use App\Services\Repositories\Contracts\IWorkFlowStepRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IssueController extends BaseApiController
{
    private IIssueRepository $issueRepository;
    private IIssueTypeRepository $issueTypeRepository;
    private IWorkFlowStepRepository $stepRepository;
    private IUserRepository $userRepository;

    public function __construct(
        IIssueRepository $issueRepository,
        IIssueTypeRepository $issueTypeRepository,
        IWorkFlowStepRepository $stepRepository,
        IUserRepository $userRepository
    ) {
        $this->issueRepository = $issueRepository;
        $this->issueTypeRepository = $issueTypeRepository;
        $this->stepRepository = $stepRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param int $projectId
     * @return array
     * @throws AuthorizationException
     */
    public function index(Request $request, int $projectId): array
    {
        $this->authorize(Action::VIEW_ANY, Issue::class);

        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length', 10);
        $issues = $this->issueRepository->getAllByProjectId($projectId, [
            'issueType:id,name',
            'status:id,name',
            'assignee:id,first_name,last_name',
        ])
            ->offset($start)
            ->limit($length)
            ->get();
        $totalRecords = $this->issueRepository->getAllByProjectId($projectId)->count();

        return self::success([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'issues' => $issues,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(int $projectId, Issue $issue): array
    {
        $this->authorize(Action::VIEW, $issue);

        return self::success($issue->load([
            'childIssues.issueType:id,name',
            'childIssues.status:id,name',
            'childIssues.assignee:id,first_name,last_name',
            'issueType',
            'status',
            'assignee',
            'parentIssue',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIssueRequest $request
     * @param int $projectId
     * @return array
     * @throws AuthorizationException
     */
    public function store(StoreIssueRequest $request, int $projectId): array
    {
        $this->authorize(Action::CREATE, Issue::class);

        try {
            $issue = $this->issueRepository->create($request->input());

            return self::success($issue, __('The :object has been created', ['object' => 'issue']));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return self::serverError();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $projectId
     * @param Issue $issue
     * @return array
     * @throws AuthorizationException
     */
    public function edit(int $projectId, Issue $issue): array
    {
        $this->authorize(Action::UPDATE, $issue);

        try {
            return self::success([
                'issue' => $issue->load([
                    'childIssues.issueType:id,name',
                    'childIssues.status:id,name',
                    'childIssues.assignee:id,first_name,last_name',
                    'issueType',
                    'status.nextStatusesAllowed',
                    'assignee',
                    'parentIssue',
                ]),
                'issueTypes' => $this->issueTypeRepository->getAllByProjectId($projectId)->get(),
                'statuses' => $this->stepRepository->getAllByProjectId($projectId)->get(),
                'assignees' => $this->userRepository->getAllByProjectId($projectId)->get(),
                'issues' => $this->issueRepository->getAllByProjectId($projectId)->get(),
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return self::serverError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIssueRequest $request
     * @param int $projectId
     * @param int $issueId
     * @return array
     * @throws AuthorizationException
     */
    public function update(UpdateIssueRequest $request, int $projectId, int $issueId): array
    {
        $this->authorize(Action::UPDATE, $this->issueRepository->findOrFail($issueId));

        try {
            $this->issueRepository->update($request->input(), $issueId);

            return self::success(null, __('The :object has been updated', ['object' => 'issue']));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return self::serverError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $projectId
     * @param Issue $issue
     * @return array
     * @throws AuthorizationException
     */
    public function destroy(int $projectId, Issue $issue): array
    {
        $this->authorize(Action::DELETE, $issue);

        try {
            $this->issueRepository->delete($issue);

            return self::success(null, __('The :object has been deleted', ['object' => 'issue']));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return self::serverError();
        }
    }
}

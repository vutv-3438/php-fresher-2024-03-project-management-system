<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Services\Repositories\Contracts\IIssueRepository;
use App\Services\Repositories\Contracts\IIssueTypeRepository;
use App\Services\Repositories\Contracts\IUserRepository;
use App\Services\Repositories\Contracts\IWorkFlowStepRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class IssueController extends Controller
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
     * Display a listing of the resource.
     * @param int $projectId
     * @return View
     * @throws AuthorizationException
     */
    public function index(int $projectId): View
    {
        $this->authorize(Action::VIEW_ANY, Issue::class);

        return view('issues.index');
    }

    /**
     * @param Request $request
     * @param int $projectId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getAllByProjectId(Request $request, int $projectId): JsonResponse
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

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'issues' => $issues,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $projectId
     * @return View
     * @throws AuthorizationException
     */
    public function create(int $projectId): View
    {
        $this->authorize(Action::CREATE, Issue::class);

        return view('issues.create', [
            'issueTypes' => $this->issueTypeRepository->getAllByProjectId($projectId)->get(),
            'statuses' => $this->stepRepository->getAllByProjectId($projectId)->get(),
            'assignees' => $this->userRepository->getAllByProjectId($projectId)->get(),
            'issues' => $this->issueRepository->getAllByProjectId($projectId)->get(),
        ]);
    }

    public function show(int $projectId, Issue $issue): View
    {
        $this->authorize(Action::VIEW, $issue);

        return view('issues.detail', [
            'issue' => $issue->load([
                'childIssues.issueType:id,name',
                'childIssues.status:id,name',
                'childIssues.assignee:id,first_name,last_name',
                'issueType',
                'status',
                'assignee',
                'parentIssue',
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIssueRequest $request
     * @param int $projectId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreIssueRequest $request, int $projectId): RedirectResponse
    {
        $this->authorize(Action::CREATE, Issue::class);

        try {
            $this->issueRepository->create($request->input());

            return redirectWithActionStatus(
                Status::SUCCESS,
                'issues.index',
                Resource::ISSUE,
                Action::CREATE,
                ['projectId' => $projectId]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $projectId
     * @param Issue $issue
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $projectId, Issue $issue): View
    {
        $this->authorize(Action::UPDATE, $issue);

        return view('issues.edit', [
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIssueRequest $request
     * @param int $projectId
     * @param int $issueId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(
        UpdateIssueRequest $request,
        int $projectId,
        int $issueId
    ): RedirectResponse {
        $this->authorize(Action::UPDATE, $this->issueRepository->findOrFail($issueId));

        try {
            $this->issueRepository->update($request->input(), $issueId);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'issues.index',
                Resource::ISSUE,
                Action::UPDATE,
                ['projectId' => $projectId]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $projectId
     * @param Issue $issue
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $projectId, Issue $issue): RedirectResponse
    {
        $this->authorize(Action::DELETE, $issue);

        try {
            $this->issueRepository->delete($issue);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'issues.index',
                Resource::ISSUE,
                Action::DELETE,
                ['projectId' => $projectId],
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }
}

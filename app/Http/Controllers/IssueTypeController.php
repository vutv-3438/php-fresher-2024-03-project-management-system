<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreIssueTypeRequest;
use App\Http\Requests\UpdateIssueTypeRequest;
use App\Models\IssueType;
use App\Services\Repositories\Contracts\IIssueTypeRepository;
use App\Services\Repositories\Contracts\IProjectRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class IssueTypeController extends Controller
{
    private IIssueTypeRepository $issueTypeRepository;
    private IProjectRepository $projectRepository;

    public function __construct(IIssueTypeRepository $issueTypeRepository, IProjectRepository $projectRepository)
    {
        $this->issueTypeRepository = $issueTypeRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $projectId
     * @return View
     * @throws AuthorizationException
     */
    public function index(int $projectId): View
    {
        $this->authorize(Action::VIEW_ANY, IssueType::class);

        return view('issueTypes.index', [
            'issueTypes' => $this->issueTypeRepository->getAllByProjectId($projectId)->get(),
            'project' => $this->projectRepository->find($projectId),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize(Action::CREATE, IssueType::class);

        return view('issueTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIssueTypeRequest $request
     * @param int $projectId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreIssueTypeRequest $request, int $projectId): RedirectResponse
    {
        $this->authorize(Action::CREATE, IssueType::class);

        try {
            $this->issueTypeRepository->create($request->input());

            return redirectWithActionStatus(
                Status::SUCCESS,
                'issueTypes.index',
                Resource::ISSUE_TYPE,
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
     * @param IssueType $issueType
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $projectId, IssueType $issueType): View
    {
        $this->authorize(Action::UPDATE, $issueType);

        return view('issueTypes.edit', [
            'issueType' => $issueType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIssueTypeRequest $request
     * @param int $projectId
     * @param int $issueTypeId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateIssueTypeRequest $request, int $projectId, int $issueTypeId): RedirectResponse
    {
        $this->authorize(Action::UPDATE, $this->issueTypeRepository->findOrFail($issueTypeId));

        try {
            $this->issueTypeRepository->update($request->input(), $issueTypeId);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'issueTypes.index',
                Resource::ISSUE_TYPE,
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
     * @param IssueType $issueType
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $projectId, IssueType $issueType): RedirectResponse
    {
        $this->authorize(Action::DELETE, $issueType);

        try {
            $this->issueTypeRepository->delete($issueType);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'issueTypes.index',
                Resource::ISSUE_TYPE,
                Action::DELETE,
                ['projectId' => $projectId],
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreWorkFlowRequest;
use App\Http\Requests\UpdateWorkFlowRequest;
use App\Models\WorkFlow;
use App\Services\Repositories\Contracts\IProjectRepository;
use App\Services\Repositories\Contracts\IWorkFlowRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class WorkFlowController extends BaseController
{
    private IWorkFlowRepository $flowRepository;
    private IProjectRepository $projectRepository;

    public function __construct(
        IWorkFlowRepository $flowRepository,
        IProjectRepository $projectRepository
    ) {
        $this->flowRepository = $flowRepository;
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
        $this->authorize(Action::VIEW_ANY, WorkFlow::class);

        return view('workFlows.index', [
            'workFlows' => $this->flowRepository->getWorkFlowByProjectId($projectId),
            'project' => $this->projectRepository->findOrFail($projectId),
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
        $this->authorize(Action::CREATE, WorkFlow::class);

        return view('workFlows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkFlowRequest $request
     * @param int $projectId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreWorkFlowRequest $request, int $projectId): RedirectResponse
    {
        $this->authorize(Action::CREATE, WorkFlow::class);

        try {
            $this->flowRepository->create($request->input());

            return redirectWithActionStatus(
                Status::SUCCESS,
                'workFlows.index',
                Resource::WORK_FLOW,
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
     * @param WorkFlow $workFlow
     * @param int $projectId
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $projectId, WorkFlow $workFlow): View
    {
        $this->authorize(Action::UPDATE, $workFlow);

        return view('workFlows.edit', [
            'workFlow' => $workFlow->load([
                'workFlowSteps.previousStatuses',
            ]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkFlowRequest $request
     * @param int $projectId
     * @param int $workFlowId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(
        UpdateWorkFlowRequest $request,
        int $projectId,
        int $workFlowId
    ): RedirectResponse {
        $this->authorize(Action::UPDATE, $this->flowRepository->findOrFail($workFlowId));

        try {
            $this->flowRepository->update($request->input(), $workFlowId);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'workFlows.index',
                Resource::WORK_FLOW,
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
     * @param WorkFlow $workFlow
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $projectId, WorkFlow $workFlow): RedirectResponse
    {
        $this->authorize(Action::DELETE, $workFlow);

        try {
            $this->flowRepository->delete($workFlow);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'workFlows.index',
                Resource::WORK_FLOW,
                Action::DELETE,
                ['projectId' => $projectId],
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }
}

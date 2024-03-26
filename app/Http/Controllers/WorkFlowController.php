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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class WorkFlowController extends BaseController
{
    private IWorkFlowRepository $flowRepository;
    private IProjectRepository $projectRepository;

    public function __construct(
        IWorkFlowRepository $flowRepository,
        IProjectRepository  $projectRepository
    ) {
        $this->flowRepository = $flowRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $projectId
     * @return View
     */
    public function index(int $projectId): View
    {
        return view('workFlows.index', [
            'workFlows' => $this->flowRepository->getWorkFlowByProjectId($projectId),
            'project' => $this->projectRepository->find($projectId),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('workFlows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkFlowRequest $request
     * @param int $projectId
     * @return RedirectResponse
     */
    public function store(StoreWorkFlowRequest $request, int $projectId): RedirectResponse
    {
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
     */
    public function edit(int $projectId, WorkFlow $workFlow): View
    {
        return view('workFlows.edit', [
            'workFlow' => $workFlow->load('workFlowSteps'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkFlowRequest $request
     * @param int $projectId
     * @param int $workFlowId
     * @return RedirectResponse
     */
    public function update(
        UpdateWorkFlowRequest $request,
        int $projectId,
        int $workFlowId
    ): RedirectResponse {
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
     */
    public function destroy(int $projectId, WorkFlow $workFlow)
    {
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

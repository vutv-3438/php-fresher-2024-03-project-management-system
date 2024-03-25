<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreWorkFlowStepRequest;
use App\Models\WorkFlow;
use App\Models\WorkFlowStep;
use App\Services\Repositories\Contracts\IProjectRepository;
use App\Services\Repositories\Contracts\IWorkFlowStepRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class WorkFLowStepController extends Controller
{
    private IWorkFlowStepRepository $stepRepository;
    private IProjectRepository $projectRepository;

    public function __construct(IWorkFlowStepRepository $stepRepository, IProjectRepository $projectRepository)
    {
        $this->stepRepository = $stepRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('workFlowSteps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkFlowStepRequest $request
     * @return RedirectResponse
     */
    public function store(StoreWorkFlowStepRequest $request): RedirectResponse
    {
        try {
            $this->stepRepository->create($request->input());

            return redirectWithActionStatus(
                Status::SUCCESS,
                'workFlows.edit',
                Resource::WORK_FLOW_STEP,
                Action::CREATE,
                [
                    'projectId' => $request->input('project_id'),
                    'workFlow' => $request->input('work_flow_id'),
                ]
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
     * @param $workFlowStep $projectId
     * @return View
     */
    public function edit(int $projectId, WorkFlow $workFlow): View
    {
        return view('workFlows.edit', [
            'workFlow' => $workFlow,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $projectId
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(
        int $projectId,
        int $workFlowId,
        WorkFlowStep $workFlowStep
    ) {
        try {
            $this->stepRepository->delete($workFlowStep);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'workFlows.edit',
                Resource::WORK_FLOW_STEP,
                Action::DELETE,
                [
                    'projectId' => $projectId,
                    'workFlow' => $workFlowId,
                ],
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }
}

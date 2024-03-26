<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreWorkFlowStepRequest;
use App\Http\Requests\UpdateWorkFlowStepRequest;
use App\Models\WorkFlowStep;
use App\Services\Repositories\Contracts\IWorkFlowStepRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class WorkFlowStepController extends Controller
{
    private IWorkFlowStepRepository $stepRepository;

    public function __construct(IWorkFlowStepRepository $stepRepository)
    {
        $this->stepRepository = $stepRepository;
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
     * @param int $projectId
     * @param int $workFlowId
     * @return RedirectResponse
     */
    public function store(
        StoreWorkFlowStepRequest $request,
        int $projectId,
        int $workFlowId
    ): RedirectResponse {
        try {
            $this->stepRepository->create($request->input());

            return redirectWithActionStatus(
                Status::SUCCESS,
                'workFlows.edit',
                Resource::WORK_FLOW_STEP,
                Action::CREATE,
                [
                    'projectId' => $projectId,
                    'workFlow' => $workFlowId,
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
     * @param int $projectId
     * @param int $workFlowId
     * @param WorkFlowStep $workFlowStep
     * @return View
     */
    public function edit(int $projectId, int $workFlowId, WorkFlowStep $workFlowStep): View
    {
        return view('workFlowSteps.edit', [
            'workFlowStep' => $workFlowStep,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkFlowStepRequest $request
     * @param int $projectId
     * @param int $workFlowId
     * @param int $stepId
     * @return RedirectResponse
     */
    public function update(
        UpdateWorkFlowStepRequest $request,
        int $projectId,
        int $workFlowId,
        int $stepId
    ): RedirectResponse {
        try {
            $this->stepRepository->update($request->input(), $stepId);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'workFlows.edit',
                Resource::WORK_FLOW_STEP,
                Action::CREATE,
                [
                    'projectId' => $projectId,
                    'workFlow' => $workFlowId,
                ]
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
     * @param int $workFlowId
     * @param WorkFlowStep $workFlowStep
     * @return RedirectResponse
     */
    public function destroy(
        int $projectId,
        int $workFlowId,
        WorkFlowStep $workFlowStep
    ): RedirectResponse {
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

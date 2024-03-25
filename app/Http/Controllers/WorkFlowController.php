<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Http\Requests\StoreWorkFlowRequest;
use App\Models\WorkFlow;
use App\Services\Repositories\Contracts\IProjectRepository;
use App\Services\Repositories\Contracts\IWorkFlowRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class WorkFlowController extends BaseController
{
    private IWorkFlowRepository $flowRepository;
    private IProjectRepository $projectRepository;

    public function __construct(IWorkFlowRepository $flowRepository, IProjectRepository $projectRepository)
    {
        $this->flowRepository = $flowRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(int $projectId): View
    {
        return view('workflows.index', [
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
        return view('workflows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkFlowRequest $request
     * @return RedirectResponse
     */
    public function store(StoreWorkFlowRequest $request, int $projectId): RedirectResponse
    {
        try {
            $this->flowRepository->create($request->input());

            return redirectWithSuccessAction(
                'workFlows.index',
                Resource::WORK_FLOW,
                Action::CREATE,
                ['projectId' => $projectId]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithCommonError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkFlow $workFlow
     * @param int $projectId
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkFlow $workFlow, int $projectId)
    {
        //
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
     * @param WorkFlow $workFlow
     * @return RedirectResponse
     */
    public function destroy(int $projectId, WorkFlow $workFlow)
    {
        try {
            $this->flowRepository->delete($workFlow);

            return redirectWithSuccessAction(
                'workFlows.index',
                Resource::WORK_FLOW,
                Action::DELETE,
                ['projectId' => $projectId],
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithCommonError();
        }
    }
}

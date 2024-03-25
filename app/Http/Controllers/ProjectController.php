<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Repositories\Contracts\IProjectRepository;
use App\Services\Repositories\Contracts\IRoleRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProjectController extends BaseController
{
    private IProjectRepository $projectRepository;
    private IRoleRepository $roleRepository;

    public function __construct(
        IProjectRepository $projectRepository,
        IRoleRepository    $roleRepository
    )
    {
        $this->projectRepository = $projectRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('projects.index', [
            'projects' => $this->projectRepository->getProjectsByUser(auth()->user()->id)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $project = $this->projectRepository->create($request->input());
                $this->roleRepository->createManagerRoleInProject($project->id);
            });

            return redirectWithActionStatus(
                Status::SUCCESS,
                'projects.index',
                Resource::PROJECT,
                Action::CREATE,
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id)
    {
        $project = $this->projectRepository->find($id);
        if (!$project) {
            return static::NotFound();
        }

        return view('projects.edit', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $request, int $id)
    {
        try {
            $this->projectRepository->update($request->input(), $id);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'projects.index',
                Resource::PROJECT,
                Action::UPDATE,
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->projectRepository->delete($id);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'projects.index',
                Resource::PROJECT,
                Action::DELETE,
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }
}

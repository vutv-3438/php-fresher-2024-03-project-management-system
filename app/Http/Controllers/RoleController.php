<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Services\Repositories\Contracts\IProjectRepository;
use App\Services\Repositories\Contracts\IRoleRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RoleController extends BaseController
{
    private IRoleRepository $roleRepository;
    private IProjectRepository $projectRepository;

    public function __construct(
        IRoleRepository $roleRepository,
        IProjectRepository $projectRepository
    ) {
        $this->roleRepository = $roleRepository;
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
        $this->authorize(Action::VIEW_ANY, Role::class);

        return view('roles.index', [
            'roles' => $this->roleRepository
                ->getAllByProjectId($projectId)
                ->get(),
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
        $this->authorize(Action::CREATE, Role::class);

        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @param int $projectId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreRoleRequest $request, int $projectId): RedirectResponse
    {
        $this->authorize(Action::CREATE, Role::class);

        try {
            $this->roleRepository->create($request->input());

            return redirectWithActionStatus(
                Status::SUCCESS,
                'roles.index',
                Resource::ROLE,
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
     * @param Role $role
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $projectId, Role $role): View
    {
        $this->authorize(Action::UPDATE, $role);

        return view('roles.edit', [
            'role' => $role->load('roleClaims'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param int $projectId
     * @param int $roleId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(
        UpdateRoleRequest $request,
        int $projectId,
        int $roleId
    ): RedirectResponse {
        $this->authorize(Action::UPDATE, $this->roleRepository->findOrFail($roleId));

        try {
            $this->roleRepository->update($request->input(), $roleId);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'roles.index',
                Resource::ROLE,
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
     * @param Role $role
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $projectId, Role $role): RedirectResponse
    {
        $this->authorize(Action::DELETE, $role);

        try {
            $this->roleRepository->delete($role);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'roles.index',
                Resource::ROLE,
                Action::DELETE,
                ['projectId' => $projectId],
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    /**
     * @param int $projectId
     * @param Role $role
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function changeRoleDefault(int $projectId, Role $role): RedirectResponse
    {
        $this->authorize(Action::UPDATE, $role);

        try {
            $this->roleRepository->markAsDefaultRoleInTheProject($projectId, $role->id);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'roles.index',
                Resource::ROLE,
                Action::UPDATE,
                ['projectId' => $projectId]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }
}

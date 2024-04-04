<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreRoleClaimRequest;
use App\Http\Requests\UpdateRoleClaimRequest;
use App\Models\RoleClaim;
use App\Services\Repositories\Contracts\IRoleClaimRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RoleClaimController extends BaseController
{
    private IRoleClaimRepository $roleClaimRepository;

    public function __construct(IRoleClaimRepository $roleClaimRepository)
    {
        $this->roleClaimRepository = $roleClaimRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize(Action::CREATE, RoleClaim::class);

        return view('roleClaims.create', [
            'claimTypes' => Resource::toArray(),
            'claimValues' => Action::toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleClaimRequest $request
     * @param int $projectId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreRoleClaimRequest $request, int $projectId): RedirectResponse
    {
        $this->authorize(Action::CREATE, RoleClaim::class);

        try {
            $this->roleClaimRepository->create($request->input());

            return redirectWithActionStatus(
                Status::SUCCESS,
                'roles.edit',
                Resource::ROLE_CLAIM,
                Action::CREATE,
                [
                    'projectId' => $projectId,
                    'role' => getRouteParam('roleId'),
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
     * @param int $roleId
     * @param RoleClaim $roleClaim
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $projectId, int $roleId, RoleClaim $roleClaim): View
    {
        $this->authorize(Action::UPDATE, $roleClaim);

        return view('roleClaims.edit', [
            'roleClaim' => $roleClaim,
            'claimTypes' => Resource::toArray(),
            'claimValues' => Action::toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleClaimRequest $request
     * @param int $projectId
     * @param int $roleId
     * @param int $roleClaimId
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(
        UpdateRoleClaimRequest $request,
        int $projectId,
        int $roleId,
        int $roleClaimId
    ): RedirectResponse {
        $this->authorize(Action::UPDATE, $this->roleClaimRepository->findOrFail($roleClaimId));

        try {
            $this->roleClaimRepository->update($request->input(), $roleClaimId);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'roles.edit',
                Resource::ROLE_CLAIM,
                Action::UPDATE,
                [
                    'projectId' => $projectId,
                    'role' => $roleId,
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
     * @param int $roleId
     * @param RoleClaim $roleClaim
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $projectId, int $roleId, RoleClaim $roleClaim): RedirectResponse
    {
        $this->authorize(Action::DELETE, $roleClaim);

        try {
            $this->roleClaimRepository->delete($roleClaim);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'roles.edit',
                Resource::ROLE_CLAIM,
                Action::UPDATE,
                [
                    'projectId' => $projectId,
                    'role' => $roleId,
                ]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }
}

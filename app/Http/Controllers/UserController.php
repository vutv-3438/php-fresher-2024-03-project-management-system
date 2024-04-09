<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\Repositories\Contracts\IUserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UserController extends Controller
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize(Action::VIEW_ANY, User::class);

        return view('users.index', [
            'users' => User::withTrashed()->get(),
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
        $this->authorize(Action::CREATE, User::class);

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize(Action::CREATE, User::class);

        try {
            User::create([
                'user_name' => $request->user_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'users.index',
                Resource::USER,
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
     * @throws AuthorizationException
     */
    public function edit(int $id): View
    {
        $user = $this->userRepository->findOrFail($id);
        $this->authorize(Action::UPDATE, $user);

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $user = $this->userRepository->findOrFail($id);
        $this->authorize(Action::UPDATE, $user);

        try {
            $user->user_name = $request->user_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = empty($request->password) ? $user->password : Hash::make($request->password);
            $user->phone_number = $request->phone_number;
            $user->save();

            return redirectWithActionStatus(
                Status::SUCCESS,
                'users.index',
                Resource::USER,
                Action::UPDATE,
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(Request $request, int $id): RedirectResponse
    {
        $user = $this->userRepository->findOrFail($id);
        $this->authorize(Action::UPDATE, $user);

        try {
            $user->restore();

            return redirectWithActionStatus(
                Status::SUCCESS,
                'users.index',
                Resource::USER,
                Action::RESTORE,
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function toggleLock(Request $request, int $id): RedirectResponse
    {
        $user = $this->userRepository->findOrFail($id);
        $this->authorize(Action::UPDATE, $user);

        try {
            $user->is_locked = !$user->is_locked;
            $user->save();

            return redirectWithActionStatus(
                Status::SUCCESS,
                'users.index',
                Resource::USER,
                $user->is_locked ? Action::LOCK : Action::UNLOCK,
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
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = $this->userRepository->findOrFail($id);
        $this->authorize(Action::DELETE, $user);

        try {
            $user->delete();

            return back()->with([
                'type' => 'success',
                'msg' => __('The :object has been deleted', ['object' => 'user']),
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'type' => 'danger',
                'msg' => __('Something went wrong'),
            ]);
        }
    }
}

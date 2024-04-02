<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
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
            'users' => User::all()->load('roles'),
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

            return redirect()->route('users.index')->with([
                'type' => 'success',
                'msg' => __('The :object has been created', ['object' => 'user']),
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'type' => 'danger',
                'msg' => __('Something went wrong'),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user): View
    {
        $this->authorize(Action::UPDATE, $user);

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize(Action::UPDATE, $user);

        try {
            $user->user_name = $request->user_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = empty($request->password) ? $user->password : Hash::make($request->password);
            $user->phone_number = $request->phone_number;
            $user->save();

            return redirect()->route('users.index')->with([
                'type' => 'success',
                'msg' => __('The :object has been updated', ['object' => 'user']),
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'type' => 'danger',
                'msg' => __('Something went wrong'),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user): RedirectResponse
    {
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

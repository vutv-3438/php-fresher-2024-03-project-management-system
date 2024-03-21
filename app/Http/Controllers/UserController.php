<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::all()->load('roles'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
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
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
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

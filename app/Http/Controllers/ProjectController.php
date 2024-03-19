<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('projects.index', [
            'projects' => Project::all()->load('roles.users'),
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
            DB::table('projects')->insert([
                'name' => $request->name,
                'key' => $request->key,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'type' => $request->type,
            ]);

            return redirect()->route('projects.index')->with([
                'type' => 'success',
                'msg' => __('The :object has been created', ['object' => 'project']),
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'type' => 'danger',
                'msg' => __('Something went wrong'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id)
    {
        $project = DB::table('projects')->find($id);
        if (!$project) {
            abort(404);
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
        $project = DB::table('projects')->find($id);
        if (!$project) {
            abort(404);
        }

        try {
            DB::table('projects')->update([
                'name' => $request->name,
                'key' => $request->key,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'type' => $request->type,
            ]);

            return redirect()->route('projects.index')->with([
                'type' => 'success',
                'msg' => __('The :object has been updated', ['object' => 'project']),
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
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            DB::table('projects')->delete($id);

            return back()->with([
                'type' => 'success',
                'msg' => __('The :object has been deleted', ['object' => 'project']),
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'type' => 'danger',
                'msg' => __('Something went wrong'),
            ]);
        }
    }
}

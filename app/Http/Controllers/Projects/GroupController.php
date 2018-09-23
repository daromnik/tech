<?php

namespace App\Http\Controllers\Projects;

use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Group::create($request->all());
        return redirect()->route("groups.show", ["id" => $request->project_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $project
     * @return \Illuminate\Http\Response
     */
    public function show(int $projectId)
    {
        $project = Project::find($projectId);
        $groups = $project->groups()->get();
        return view("projects.groups.list", ["project" => $project, "groups" => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $group->update($request->all());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return back();
    }
}

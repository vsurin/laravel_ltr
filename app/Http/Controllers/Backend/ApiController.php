<?php

namespace App\Http\Controllers\Backend;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Traits\ProjectRulesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use ProjectRulesTrait;

    /**
     * Get json projects
     *
     * @param int $limit
     * @param int $offset
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $limit, int $offset, $title = '', $organization = '', $filtertype = '')
    {
        return $projects = Project::filter()->limit($limit)->offset($offset)->get();
    }

    /**
     * Get json project
     *
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Project $project)
    {
        return response()->json(['post' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Project::find($id)->delete();

        return response()->json(['message' => 'Project '.$id.' - was removed']);
    }

    /**
     * Create project
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()]);
        }

        $project = Project::create($request->all());

        Project::createSkills($request, $project->id);

        return response()->json(['message' => 'Project ' . $project->id . ' - was created']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            $result = response()->json(['message' => $validator->messages()]);
        }else{
            Project::find($id)->update($request->All());

            Project::createSkills($request, $id);

            $result = response()->json(['message' => 'Project '.$id.' - was updated']);
        }

        return $result;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View\
     */
    public function createTest()
    {
        return view('backend.api.create', ['project' => new Project]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateTest($id)
    {
        $project = Project::find($id);

        return view('backend.api.edit', compact('project'));
    }

    /**
     * Get count records
     *
     * @return mixed
     */
    public function count($title = '', $organization = '', $filtertype = '')
    {
        return Project::filter()->count();
    }
}

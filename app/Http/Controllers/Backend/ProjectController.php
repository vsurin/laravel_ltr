<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\Csv;
use App\Models\File;
use App\Models\Project;
use App\Models\Xlsx;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $projects = Project::filter()->paginate(10);

        if ($request->ajax()) {
            return view('backend.project.load', ['projects' => $projects])->render();
        }

        return view('backend.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.project.create', ['project' => new Project]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->all();
        $data['start'] = '2018-10-09 11:57:38';
        $data['end'] = '2018-10-09 11:57:38';
        $data['link'] = str_random(10);

        $project = Project::create($data);

        Project::createSkills($request, $project->id);

        return redirect()->route('projects.index')
            ->with('success','Projects created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);

        return view('backend.project.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);

        return view('backend.project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        Project::find($id)->update($request->All());

        Project::createSkills($request, $id);

        return redirect()->route('projects.index')
            ->with('success','Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::find($id)->delete();

        return redirect()->route('projects.index')
            ->with('success','Project deleted successfully');
    }

    public function import()
    {
        $project = new Project;

        return view('backend.project.import', compact('project'));
    }

    /**
     * Parse the file with projects in DB
     *
     * @param FileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function parserFile(FileRequest $request)
    {
        $file = $request->file('file');

        $fileType = $file->getClientOriginalExtension();
        $dirFile = 'upload/projects/'.File::upload($file, 'upload/projects/');

        if ($fileType == 'csv') {
            $csv = new Csv;
            $csv->import($dirFile);
        } elseif ($fileType == 'xlsx') {
            $xlsx = new Xlsx;
            $xlsx->import($dirFile);
        }

        return redirect()->route('admin.project.import')
            ->with('success','Projects import successfully');
    }

    /**
     * Export projects in file
     */
    public function export()
    {
        $projects = Project::all();
        $file = 'upload/projects/export_projects.csv';

        $csv = new Csv;
        $csv->export($projects, $file);
    }

    /**
     * Genereta pdf file
     *
     * @param Int $id
     * @return mixed
     */
    public function generatePDF(Int $id)
    {
        $project = Project::find($id);

        $pdf = PDF::loadView('backend.project.pdf', compact('project'));

        return $pdf->download('project.pdf');
    }
}
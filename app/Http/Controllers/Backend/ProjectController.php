<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Csv as WriteCsv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $project = new Project;
        $projects = $project->latest('created_at')->paginate(10);

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
        $project = Project::pluck('title', 'id');

        return view('backend.project.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['start'] = '2018-10-09 11:57:38';
        $data['end'] = '2018-10-09 11:57:38';
        $data['type_id'] = 1;
        $data['links'] = str_random(10);

        Project::create($data);

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Project::find($id)->update($request->All());
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
        $project = new Project();

        return view('backend.project.import', compact('project'));
    }

    public function parserFile(Request $request)
    {
        $file = $this->uploadFile($request);

        $reader = new Csv;
        $spreadsheet = $reader->load('upload/csv/'.$file);
        $cells = $spreadsheet->getActiveSheet()->getCellCollection();

        for ($row = 2; $row <= $cells->getHighestRow(); $row++){
            $data['title'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
            $data['descrription'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
            $data['organization'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
            $data['start'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
            $data['end'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
            $data['role'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
            $data['links'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
            //$data['skils'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
            $data['type_id'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();

            Project::create($data);
        }

        return redirect()->route('admin.project.import')
            ->with('success','Projects import successfully');
    }

    public function export()
    {
        $data = Project::get()->toArray();

        $excel = new Spreadsheet();

        for($i = 0; $i < 5; $i++) {
            $sheet = $excel->setActiveSheetIndex(0);
            $cell = $sheet->getCell('A'.$i);
            $cell->setValue('Test '.$i);

            $cell = $sheet->getCell('B'.$i);
            $cell->setValue('B Test '.$i);

            $cell = $sheet->getCell('C'.$i);
            $cell->setValue('C Test '.$i);
        }


        $excelWriter = new WriteCsv($excel);

        $excelWriter->save('upload/csv/test.csv');


        echo 1111;
        die;
    }

    /**
     * Upload csv
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    private function uploadFile(Request $request){
        $file = $request->file('file');

        if ($file) {
            $name = md5(microtime() . rand(0, 9999)).'_'.$file->getClientOriginalName();
            $file->move('upload/csv/', $name);

            return $name;
        }

        return '';
    }
}
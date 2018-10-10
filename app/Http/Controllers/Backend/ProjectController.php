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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['start'] = '2018-10-09 11:57:38';
        $data['end'] = '2018-10-09 11:57:38';
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
            $data['type'] = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();

            Project::create($data);
        }

        return redirect()->route('admin.project.import')
            ->with('success','Projects import successfully');
    }

    public function export()
    {
        $projects = Project::get()->toArray();
        $file = 'upload/csv/test.csv';

        $excel = new Spreadsheet();

        foreach ($projects as $key => $project) {
            $sheet = $excel->setActiveSheetIndex(0);
            $cell = $sheet->getCell('A'.$key);
            $cell->setValue($project['title']);

            $cell = $sheet->getCell('B'.$key);
            $cell->setValue($project['descrription']);

            $cell = $sheet->getCell('C'.$key);
            $cell->setValue($project['organization']);

            $cell = $sheet->getCell('D'.$key);
            $cell->setValue($project['start']);

            $cell = $sheet->getCell('E'.$key);
            $cell->setValue($project['end']);

            $cell = $sheet->getCell('F'.$key);
            $cell->setValue($project['role']);

            $cell = $sheet->getCell('G'.$key);
            $cell->setValue($project['links']);

            $cell = $sheet->getCell('H'.$key);
            $cell->setValue($project['type']);
        }

        $excelWriter = new WriteCsv($excel);
        $excelWriter->save($file);
        chmod(realpath($file), 0777);

        if (file_exists($file)) {
            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . basename($file));

            readfile ($file);
            exit();
        }
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XslxRead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Xlsx extends Project
{
    public function import(String $file)
    {
        $reader = new XslxRead;
        $spreadsheet = $reader->load($file);
        $cells = $spreadsheet->getActiveSheet()->getCellCollection();

        for($i = 1; $i < 27; $i++) {
            if (!empty($spreadsheet->getActiveSheet()->getCellByColumnAndRow($i, 1)->getValue())) {
                $dataColName[$spreadsheet->getActiveSheet()->getCellByColumnAndRow($i, 1)->getValue()] = $i;
            }
        }

        DB::transaction(function () use($cells, $spreadsheet, $dataColName){
            for ($row = 2; $row <= $cells->getHighestRow(); $row++) {
                if (isset($dataColName['title'])) {
                    $title = $spreadsheet->getActiveSheet()
                        ->getCellByColumnAndRow($dataColName['title'], $row)->getValue();
                    $data['title'] = $title;
                }

                if (isset($dataColName['description'])) {
                    $descrription = $spreadsheet->getActiveSheet()
                        ->getCellByColumnAndRow($dataColName['description'], $row)->getValue();
                    $data['descrription'] = $descrription;
                }

                if (isset($dataColName['organization'])) {
                    $organization = $spreadsheet->getActiveSheet()
                        ->getCellByColumnAndRow($dataColName['organization'], $row)->getValue();
                    $data['organization'] = $organization;
                }

                if (isset($dataColName['start'])) {
                    $start = $spreadsheet->getActiveSheet()
                        ->getCellByColumnAndRow($dataColName['start'], $row)->getValue();
                    $data['start'] = $start;
                }

                if (isset($dataColName['end'])) {
                    $end = $spreadsheet->getActiveSheet()
                        ->getCellByColumnAndRow($dataColName['end'], $row)->getValue();
                    $data['end'] = $end;
                }

                if (isset($dataColName['role'])) {
                    $role = $spreadsheet->getActiveSheet()
                        ->getCellByColumnAndRow($dataColName['role'], $row)->getValue();
                    $data['role'] = $role;
                }

                if (isset($dataColName['link'])) {
                    $link = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($dataColName['link'], $row)->getValue();
                    $data['link'] = $link;
                }

                if (isset($dataColName['type'])) {
                    $type = $spreadsheet->getActiveSheet()
                        ->getCellByColumnAndRow($dataColName['type'], $row)->getValue();
                    $data['type'] = $type;
                }

                if (isset($dataColName['skills'])) {
                    $skills = $spreadsheet->getActiveSheet()
                        ->getCellByColumnAndRow($dataColName['skills'], $row)->getValue();
                }

                $validator = Validator::make($data, $this->rules());

                if ($validator->fails()) {
                    DB::rollback();

                    return redirect()->route('admin.project.import')->withErrors($validator->errors());
                }

                $project = Project::create($data);

                if (isset($skills)) {
                    $skills = explode(',', $skills);

                    foreach ($skills as $skill) {
                        ProjectSkill::create(['project_id' => $project->id, 'value' => $skill]);
                    }
                }
            }
        });
    }
}

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
                $title = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($dataColName['title'], $row)->getValue();
                $descrription = $spreadsheet->getActiveSheet()
                    ->getCellByColumnAndRow($dataColName['description'], $row)->getValue();
                $organization = $spreadsheet->getActiveSheet()
                    ->getCellByColumnAndRow($dataColName['organization'], $row)->getValue();
                $start = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($dataColName['start'], $row)->getValue();
                $end = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($dataColName['end'], $row)->getValue();
                $role = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($dataColName['role'], $row)->getValue();
                $link = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($dataColName['link'], $row)->getValue();
                //$skils = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($dataColName['skils'], $row)->getValue();
                $type = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($dataColName['type'], $row)->getValue();

                $data['title'] = $title;
                $data['descrription'] = $descrription;
                $data['organization'] = $organization;
                $data['start'] = $start;
                $data['end'] = $end;
                $data['role'] = $role;
                $data['link'] = $link;
                //$data['skils'] = $skils;
                $data['type'] = $type;

                $validator = Validator::make($data, $this->rules());

                if ($validator->fails()) {
                    DB::rollback();

                    return redirect()->route('admin.project.import')->withErrors($validator->errors());
                }

                Project::create($data);
            }
        });
    }
}

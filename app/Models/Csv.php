<?php

namespace App\Models;

use PhpOffice\PhpSpreadsheet\Reader\Csv as readCsv;
use PhpOffice\PhpSpreadsheet\Writer\Csv as writeCsv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Csv extends Project
{
    /**
     * Import the file with projects in DB
     *
     * @param String $file
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function import(String $file)
    {
        $reader = new readCsv;
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

    public function export(Array $projects, String $file)
    {
        $excel = new Spreadsheet();

        $sheet = $excel->setActiveSheetIndex(0);
        $cell = $sheet->getCell('A1');
        $cell->setValue('Title');

        $cell = $sheet->getCell('B1');
        $cell->setValue('Description');

        $cell = $sheet->getCell('C1');
        $cell->setValue('Organization');

        $cell = $sheet->getCell('D1');
        $cell->setValue('Start');

        $cell = $sheet->getCell('E1');
        $cell->setValue('End');

        $cell = $sheet->getCell('F1');
        $cell->setValue('Role');

        $cell = $sheet->getCell('G1');
        $cell->setValue('Link');

        $cell = $sheet->getCell('H1');
        $cell->setValue('Type');

        foreach ($projects as $key => $project) {
            $colomn = $key + 2;
            $cell = $sheet->getCell('A'. $colomn);
            $cell->setValue($project['title']);

            $cell = $sheet->getCell('B'.$colomn);
            $cell->setValue($project['descrription']);

            $cell = $sheet->getCell('C'.$colomn);
            $cell->setValue($project['organization']);

            $cell = $sheet->getCell('D'.$colomn);
            $cell->setValue($project['start']);

            $cell = $sheet->getCell('E'.$colomn);
            $cell->setValue($project['end']);

            $cell = $sheet->getCell('F'.$colomn);
            $cell->setValue($project['role']);

            $cell = $sheet->getCell('G'.$colomn);
            $cell->setValue($project['link']);

            $cell = $sheet->getCell('H'.$colomn);
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
}

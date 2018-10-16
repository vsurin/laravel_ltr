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

    public function export($projects, String $file)
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

        $cell = $sheet->getCell('I1');
        $cell->setValue('Skills');

        foreach ($projects as $key => $project) {
            $colomn = $key + 2;
            $cell = $sheet->getCell('A'. $colomn);
            $cell->setValue($project->title);

            $cell = $sheet->getCell('B'.$colomn);
            $cell->setValue($project->descrription);

            $cell = $sheet->getCell('C'.$colomn);
            $cell->setValue($project->organization);

            $cell = $sheet->getCell('D'.$colomn);
            $cell->setValue($project->start);

            $cell = $sheet->getCell('E'.$colomn);
            $cell->setValue($project->end);

            $cell = $sheet->getCell('F'.$colomn);
            $cell->setValue($project->role);

            $cell = $sheet->getCell('G'.$colomn);
            $cell->setValue($project->link);

            $cell = $sheet->getCell('H'.$colomn);
            $cell->setValue($project->type);

            if (isset($project->skills)) {
                $resultSkills = [];
                foreach ($project->skills as $skill) {
                    $resultSkills[] = $skill->value;
                }
                $resultSkills = implode(', ', $resultSkills);

                $cell = $sheet->getCell('I'.$colomn);
                $cell->setValue($resultSkills);
            }
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

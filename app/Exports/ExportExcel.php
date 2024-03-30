<?php

namespace App\Exports;

use App\Models\Call;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Ankets;

class ExportExcel implements FromView, WithColumnWidths, WithStyles
{
    public function view(): View
    {
        $ankets = new Ankets();
        $questions = $ankets->getQuestions(session('anketaID'));
        foreach ($questions as $question) $question->answers = $ankets->getAnswersByQuestionID($question->id);        
        
        $fields = $ankets->getFields();

        $calls = Call::query()
                ->orderBy('RegionID', 'ASC')
                ->orderBy('LastName', 'ASC')
                ->where('anketa_id', '=', session('anketaID'))                
                ->get();

        return view('layouts.export_table', [
            'calls' =>  $calls,
            'questions' =>  $questions,   
            'fields' => $fields,
        ]);
    }

    public function columnWidths(): array
    {//Ширина колонок
        return [
            'A' => 30,
            'B' => 30,
            'C' => 40,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 15,
            'K' => 15,
            'L' => 15,
            'M' => 15,
            'N' => 15,
            'O' => 20,
            'P' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->setTitle(config('app.name'));

        //$sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFont()->setSize(12);

        $sheet->getStyle('F1:N1')->getFont()->setSize(10);

        $sheet->getRowDimension('1')->setRowHeight(70);
        $sheet->getStyle('A1:Q1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Q1')->getAlignment()->setVertical('top');

        $sheet->getStyle('1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('H')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('I')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('J')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('K')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('L')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('M')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('N')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('O')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('P')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A1:P1')->applyFromArray(['borders' => [
                                                            'allBorders' => [
                                                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                                                'color' => ['argb' => '000000'],
                                                            ],
                                                        ],
                                                    ]);



        //$sheet->setCellValue('A1','sdfsdfasdf dsafdsaf');

        return [
            // Style the first row as bold text.
            //1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            //'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            //1  => ['font' => ['size' => 10]],
        ];
    }

}

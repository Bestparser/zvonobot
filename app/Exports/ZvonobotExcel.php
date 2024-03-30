<?php

namespace App\Exports;

use App\Models\Call;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Services\zvonobotLoader;
use Illuminate\Support\Facades\DB;
use App\Models\Ankets;


class ZvonobotExcel implements WithStyles, FromView, WithColumnWidths
{
    protected $zl;    
    protected $ankets;

    function __construct(){
        $this->zl = new zvonobotLoader();
        $this->ankets = new Ankets();        
    }

    public function view(): View
    {
        $regions = DB::table('Regions')
                    ->select('RegionCode', 'timezone')
                    ->get();

        $calls = Call::query()
                ->select('PhoneNumber', 'RegionCode', 'RegionName', 'Сommunication')
                ->orderBy('RegionID', 'ASC')                
                ->where('anketa_id', '=', session('anketaID'))
                ->whereNotIn('Сommunication', [0, 2, 3])
                ->get();

        $questions = $this->ankets->getQuestions(session('anketaID'));
        foreach ($questions as $question) if ($question->s_id == 1) $answers = $this->ankets->getAnswersByQuestionID($question->id);

        foreach ($calls as $call){
            $mobilePhone = $this->zl->getMobilePhone($call->PhoneNumber);            
            $call->mobile = $mobilePhone;
            foreach ($regions as $region)if ($region->RegionCode == $call->RegionCode) $call->timezone = $region->timezone;
            foreach ($answers as $answer) if ($answer->value == $call->Сommunication) $call->status = $answer->answer_name;            
            if ($call->timezone > 0) $call->timezone = '+ '.$call->timezone.'';
        }

        return view('layouts.zvonobot.loadexcel', [
            'calls' =>  $calls,     
        ]);        
    }

    public function columnWidths(): array
    {//Ширина колонок
        return [
            'A' => 20,
            'B' => 40,
            'C' => 20,
            'D' => 40,
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle(config('app.name'));
        $sheet->getStyle('A1:D1')->getFont()->setSize(12);
        $sheet->getRowDimension('1')->setRowHeight(30);
        $sheet->getStyle('C')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);


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

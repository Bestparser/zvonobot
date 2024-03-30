<?php

namespace App\Exports;

use App\Models\Call;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExcel implements FromView, WithColumnWidths, WithStyles
{
    public $arrResult;

    public static function setNullArr(){ // (к) Типы Communication (обнуление)
        $arr = array(
            '0' => 0, // 0 неверный номер
            '1' => 0, // 1 нет ответа
            '2' => 0, // 2 отказались отвечать
            '3' => 0, // 3 опрошен
            '4' => 0, // 4 перезвонить позже (некогда говорить)
            '5' => 0 // 5 ожидают звонок
        );
        return $arr;
    }

    public function view(): View
    {
        // Получаем содержимое из таблицы vCalls через модель
            $calls = Call::query()
                ->select('UID', 'RegionID', 'RegionName', 'Сommunication')
                ->orderBy('RegionID', 'ASC')
                ->orderBy('LastName', 'ASC')
                ->where('anketa_id', '=', session('anketaID'))
                ->get();

        // Получаем все регионы
            $mainRegions = $users = DB::table('Regions')
                ->select('RegionID', 'RegionName')
                ->orderBy('RegionID', 'ASC')
                ->get();

        // Формируем сплошной массив Calls    
            $arrCall = array(); // Один большой массив
            $arrSubCall = array(); // Массив каждого оператора

            $i = -1;
            foreach ($calls as $call){ // Идем по каждому оператору
                $i++;

                $arrCommunication = $this->setNullArr(); // Обнуляем и задаем количество ответов Communication
                $arrCommunication[$call->Сommunication] = 1; // Среди всех Communication обозначаем один ответ

                $arrSubCall = array( // Формируем массив каждого оператора
                    'UID' => $call->UID,
                    'RegionID' => $call->RegionID,
                    'RegionName' => $call->RegionName,
                    'Communications' => $arrCommunication,
                );

                array_push($arrCall, $arrSubCall); // Добавляем сформированный массив каждого оператора в общую кучу
                unset($arrSubCall); // Очищаем ОЗУ
            }
        // end


        // Двойной цикл: согласно региону формируем массив Call
            $this->arrResult = array(); // Самый главный массив, который передаем потом в blade 
            $arrTotalTable = array(); // Второй массив, который передаем в blade (в нем генерируется последняя строчка "Общий итог")
            $arrTotalTableCommunication = $this->setNullArr(); // Общий итог: Communications 6 штук
            $totalTablePercent = 0; // Общий итог: Доля, нет ответа
            $totalTable = 0; // Общий итог                        
            
            $vse_ts = 0;
            foreach ($mainRegions as $region){ // Идем по регионам
                $arrCommunication = $this->setNullArr();
                $arrSubResult = array(                    
                    'RegionID' => $region->RegionID,
                    'RegionName' => $region->RegionName,
                    'Communications' => $this->setNullArr(),
                    'Total' => 0,
                    'Percent' => 0,
                    'vse_ts' => 0,
                    'red' => 0,
                );

                $j = 0;
                foreach ($arrCall as $ts){ // Формируем массив для каждого региона (каждая строчка в excel)                                        
                    if ($region->RegionID == $ts['RegionID']){
                        $j++;
                        $vse_ts++;
                        for ($i = 0; $i < count($this->setNullArr()); $i++) $arrSubResult['Communications'][$i] = $arrSubResult['Communications'][$i] + $ts['Communications'][$i];
                        $arrSubResult['Total'] = array_sum($arrSubResult['Communications']);
                    }
                }
                for ($i = 0; $i < count($this->setNullArr()); $i++) $arrTotalTableCommunication[$i] = $arrTotalTableCommunication[$i] + $arrSubResult['Communications'][$i];
                if (!$arrSubResult['Communications'][1] == 0) $arrSubResult['Percent'] = round(100 / $j * $arrSubResult['Communications'][1], 1);
                if ($arrSubResult['Percent'] > 30) $arrSubResult['red'] = 1;
                $arrSubResult['vse_ts'] = $j;

                /*
                echo '<pre>';
                print_r($arrSubResult);
                echo '</pre>';
                echo '</br>==========================</br>';
                */

                array_push($this->arrResult, $arrSubResult); // Сформированный массив каждого региона добавляем в самый главный массив, который потом передаем в blade
                unset($arrSubResult); // Очищаем ОЗУ
            }
            
            //exit;

            $totalTable = array_sum($arrTotalTableCommunication);
            
            if ($arrTotalTableCommunication[1] > 0) $totalTablePercent = $arrTotalTableCommunication[1] / $totalTable * 100; // Общий итог - процент (без округления)
            
            
            $arrTotalTable = array( // Формируем массив "общий итог" последняя строчка в таблице
                'arrTotalTableCommunication' => $arrTotalTableCommunication,
                'totalTablePercent' => round($totalTablePercent, 1),
                'totalTable' => $totalTable,
                'vse_ts' => $vse_ts,
            );
            
            return view('layouts.reporttoexcel_table', [
                'calls' => $this->arrResult,
                'arrTotalTable' => $arrTotalTable
            ]);            
    }

    public function columnWidths(): array
    {//Ширина колонок
        return [
            'A' => 10,
            'B' => 50,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 15,
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $i = 3;
        foreach ($this->arrResult as $arr){
            $i++;
            if (in_array(1, $arr)){
                if ($arr['red'] == 1){
                    $sheet->getStyle('F' . $i)->applyFromArray([
                        'font' => [
                            'color' => ['argb' => 'FF0000'],
                        ]
                    ]);
                }
            }
        }        
        
        $sheet->setAutoFilter('A2:J2');
        $sheet->setTitle(config('app.name'));

        $sheet->mergeCells("A1:J1");
        $sheet->getStyle('A1:J1')->getAlignment()->setVertical('middle');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A2:J2')->getFont()->setBold(true);
        $sheet->getStyle('A3:J3')->getFont()->setBold(true);

        $sheet->getStyle('1')->getFont()->setSize(12);
        $sheet->getStyle('A2:J2')->getFont()->setSize(11);
        $sheet->getRowDimension('1')->setRowHeight(45);
        $sheet->getStyle('A2:J2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2:J2')->getAlignment()->setVertical('middle');
        $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal('center');
        
        $sheet->getStyle('E3:E89')->getAlignment()->setHorizontal('right');
        
        $sheet->getStyle('C')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A1:J89')->applyFromArray(['borders' => [
                                                            'allBorders' => [
                                                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                                                'color' => ['argb' => '000000'],
                                                            ],
                                                        ],
                                                    ]);
        

        return [
        
        ];
    }

}

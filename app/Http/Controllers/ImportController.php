<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;




class ImportController extends Controller
{
    public function importExcel(Request $request)
    {
        $request->session()->put('truncateOld', $request->post('truncateOld'));        
        \Artisan::call('import:excel');
        return redirect()->route('importLog');
    }


    public function importLog(Request $request)
    {
        $errorsExcel = session('errorsExcel');
        $request->session()->put('errorsExcel', null);
        $ImportLog = DB::table('vImportLog')
                        ->limit(100)
                        ->where('anketa_id', '=', session('anketaID'))
                        ->orderBy('LID', 'DESC')
                        ->get();

        return view('importLog', [                
            'ImportLog' => $ImportLog,
            'errorsExcel' => $errorsExcel
        ]);
    }

    public static function startimport(Request $request)
    {
        \Artisan::call('import:xml');
        return ''; //redirect()->route('importLog');
    }

    public static function import($file_xml)
    {
        echo 'Start XML load'."\n";
        $CreateDateStart = Carbon::now()->format('Y-m-d\TH:i:s');
        $details = '';

        $xml = XmlParser::load($file_xml);

        $workers = $xml->getContent();

        $CreateDate = (string) $workers->attributes()->{'CreateDate'};

        echo '   # XML CreateDate = '.$CreateDate."\n";

        $row = 0;

        DB::table('Worker')->truncate();

        foreach($workers as $worker) {

            $waveCodes = (int) $worker->attributes()->{'WaveCodes'}; //$waveCodes==1  Только Досрочный этап

/* 
WaveCode         

Досрочный       1 
Основной        2 
Дополнительный  4 

Досрочный
    1 (Досрочный)
    3 (Досрочный+ Основной)
    5 (Досрочный+Дополнительный)
    7 (Досрочный+Основной+Дополнительный)

Основной
    2 (Основной)
    3 (Досрочный+Основной)
    6 (Основной+Дополнительный)
    7 (Досрочный+Основной+Дополнительный)

Дополнительный
    4 (Дополнительный)
    5 (Досрочный+Дополнительный)
    6 (Основной+Дополнительный)
    7 (Досрочный+Основной+Дополнительный)

($waveCodes==1 || $waveCodes==2 || $waveCodes==3 || $waveCodes==5 || $waveCodes==6 || $waveCodes==7)


*/
            $pos = strpos($worker->attributes()->{'PositionIds'}, '7');
            if ($pos !== false) {
                $positionID = 7; //Технический специалист ППЭ
            } else {
                $positionID = 0;
            }

            $DeleteType = $worker->attributes()->{'DeleteType'};

            
            $uid = (string) $worker->attributes()->{'Id'};

            if (($waveCodes==1 || $waveCodes==2 || $waveCodes==3 || $waveCodes==5 || $waveCodes==6 || $waveCodes==7)  && $positionID==7 && strlen($uid)!=32 && $DeleteType==0) {
                $row++;
                $w = [
                        'UID' => $uid,
                        'RegionID' => (string) $worker->attributes()->{'Region'},
                        'StationCode' => (string) $worker->attributes()->{'StationCodes'},
                        'PositionID' => '7',
                        'LastName' => (string) $worker->attributes()->{'Surname'},
                        'FirstName' => (string) $worker->attributes()->{'Name'},
                        'MiddLeName' => (string) $worker->attributes()->{'SecondName'},
                        'PhoneNumber' => (string) $worker->attributes()->{'Phones'},
                        //'Worker' => (string) $worker->attributes()->{'Name'}.' '.(string) $worker->attributes()->{'Surname'}.' '.(string) $worker->attributes()->{'SecondName'},
                        'DeleteType' => (string) $worker->attributes()->{'DeleteType'},
                    ];

                   //DB::table('Worker')->upsert($w, ['UID'], ['RegionID','StationCode','PositionID','LastName','FirstName','MiddLeName','PhoneNumber','DeleteType']);
                   DB::table('Worker')->insert($w);
            }
        }

        echo '   # XML rows = '.$row."\n";

        $details .= 'row='.$row;

      $insert = DB::table('ImportLog')->insert([
        'UserID' => (Auth::check()) ? Auth::user()->UserID : 0,
        'CreateDateStart' =>  $CreateDateStart,
        'CreateDateEnd' =>  Carbon::now()->format('Y-m-d\TH:i:s'),
        'Error' => 0,
        'CreateDateXML' =>  $CreateDate,
        'Details' =>  $details,
        'ImportRows' => $row,
      ]);

      echo '   # DB:ImportLog insert = '.$insert."\n";

      echo 'END XML load'."\n";

      return 0;//redirect()->route('import');
    }
}



                /*  $w = $worker->parse([
                                    'UID' => ['uses' => 'worker::UID'],
                                    'RegionID' => ['uses' => 'worker::RegionCode'],
                                    'StationCode' => ['uses' => 'worker::Station'],
                                    'PositionID' => ['uses' => 'worker::PositionID'],
                                    'LastName' => ['uses' => 'worker::LastName'],
                                    'FirstName' => ['uses' => 'worker::FirstName'],
                                    'MiddLeName' => ['uses' => 'worker::MiddLeName'],
                                    'PhoneNumber' => ['uses' => 'worker::PhoneNumber'],
                                ]);*/

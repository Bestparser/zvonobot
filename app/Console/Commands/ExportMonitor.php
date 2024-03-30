<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\Ankets;


class ExportMonitor extends Command
{
    protected $createDateStart;
    protected $fileNameCsv;
    protected $urlDomain;
    protected $urlImport = '/call/importauto_calls.php'; // url отправки результатов Обзвона в csv
    protected $urlStatic = '/call/autostats_calls.php'; // url статистика загруженных данных
    protected $details;
    protected $error;
    public $anketaID;
    protected $ravno;

    public function getUrlDomain(){
        $this->urlDomain = config('app.urlmonitorgia');
        return $this->urlDomain;
    }

    public function getCallsStat(){
        $data = DB::table('vCallsStat')
                    ->select(DB::raw('COUNT(*) AS cnt,
                                SUM("COM0") as "COM0",
                                SUM("COM1") as "COM1",
                                SUM("COM2") as "COM2",
                                SUM("COM3") as "COM3",
                                SUM("COM4") as "COM4",
                                SUM("COM5") as "COM5"'))                    
                    ->where('anketa_id', '=', $this->anketaID)
                    ->where('RegionID', $this->ravno, '77')
                    ->first();

        return $data;
    }

    public function getCallsExport(){
        $data = DB::table('vCalls_export')
            ->orderBy('RegionID', 'ASC')
            //->limit(10)
            ->where('anketa_id', '=', $this->anketaID)            
            ->where('RegionID', $this->ravno, '77')
            ->get();
        return $data;    
    }

    public function sendPost($url, $file, $client){        
        $response = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name'     => 'filename',
                    'contents' => file_get_contents($file),
                    'filename' => $file
                ]
            ],
            ['verify' => false]
        ]);
        return $response;        
    }


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:csv {anketaID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export csv to Monitor GIA';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();        
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->anketaID = $this->arguments()['anketaID'];   
        $this->fileNameCsv = date('Y-m-d-H-i-s') . '.csv';
        if ($this->anketaID == 1) $this->ravno = '<>';
        if ($this->anketaID == 11)  $this->ravno = '=';


        $this->createDateStart = Carbon::now()->format('Y-m-d\TH:i:s');

        // Подготавливаем массив для записи в CSV    
            $ankets = new Ankets();
            $arrCsv = array([
                'UID' => '',
                'RegionID' => '',
                'PositionID' => '',
                'Username' => '',
                'StationCode' => '',
                'Сommunication' => '',
                'IsWorkerRole' => '',
                'Experience' => '',
                'KEGE' => '',
                'StudyDate' => '',
                'RegionStudy' => '',
                'AppFederal' => '',
                'AppRegion' => '',
                'Mark' => ''
            ]); 
            foreach ($this->getCallsExport() as $obj){ // Делается по причине: все строки записываются одновременно, а не поочередно                                
                array_push($arrCsv, [
                    'UID' => $obj->UID,
                    'RegionID' => $obj->RegionID,
                    'PositionID' => $obj->PositionID,
                    'Username' => $obj->Username,
                    'StationCode' => $obj->StationCode,
                    'Сommunication' => $obj->Сommunication,
                    'IsWorkerRole' => $obj->IsWorkerRole,
                    'Experience' => $obj->Experience,
                    'KEGE' => $obj->KEGE,
                    'StudyDate' => $obj->StudyDate,
                    'RegionStudy' => $obj->RegionStudy,
                    'AppFederal' => $obj->AppFederal,
                    'AppRegion' => $obj->AppRegion,
                    'Mark' => $obj->Mark
                ]);
            }

        // Поток записи в csv
            $writer = SimpleExcelWriter::create(file: $this->fileNameCsv, delimiter: ';')
                    ->noHeaderRow()
                    ->addRows($arrCsv);
            
        // Отправка post                
            $url = $this->getUrlDomain() . $this->urlImport;
            $file = $writer->getPath();
            $client = new \GuzzleHttp\Client(['verify' => false]); 
            $response = $this->sendPost($url, $file, $client);
            

        // Запрос статистики с удаленного сервера    
            $urlStat = $this->getUrlDomain() . $this->urlStatic;    
            $response = $client->request('GET', $urlStat, ['verify' => false]); 
            $callsStatJSON = json_decode($response->getBody()->getContents());

        // Ответ: сколько вставлено записей            
            $details = 'Всего записей: ' . $callsStatJSON[0];
            echo 'Details: ' . $details;

        // Статистика с БД
            $callsStatDB = $this->getCallsStat();

        // Сравнение статистик с удаленного сервера и с БД    
            if ($callsStatDB->cnt==$callsStatJSON[0]
                && $callsStatDB->COM0 == $callsStatJSON[1]
                && $callsStatDB->COM1 == $callsStatJSON[2]
                && $callsStatDB->COM2 == $callsStatJSON[3]
                && $callsStatDB->COM3 == $callsStatJSON[4]
                && $callsStatDB->COM4 == $callsStatJSON[5]
                && $callsStatDB->COM5 == $callsStatJSON[6]
                )
                    {
                        $error = 0;
                    } else {
                        $error = 1;
                    }
                        
        // Запись логов            
            DB::table('ExportLog')->insert([ /* Запись в БД данные об экспорте  */
                'UserID' => (Auth::check()) ? Auth::user()->UserID : 0,
                'CreateDateStart' =>  $this->createDateStart,
                'CreateDateEnd' =>  Carbon::now()->format('Y-m-d\TH:i:s'),
                'Error' => $error,
                'Details' =>  $details,
                'ExportRows' => $callsStatDB->cnt.' ('.$callsStatJSON[0].')',
                'Com0' => $callsStatDB->COM0.' ('.$callsStatJSON[1].')',
                'Com1' => $callsStatDB->COM1.' ('.$callsStatJSON[2].')',
                'Com2' => $callsStatDB->COM2.' ('.$callsStatJSON[3].')',
                'Com3' => $callsStatDB->COM3.' ('.$callsStatJSON[4].')',
                'Com4' => $callsStatDB->COM4.' ('.$callsStatJSON[5].')',
                'Com5' => $callsStatDB->COM5.' ('.$callsStatJSON[6].')',
                'anketa_id' => $this->anketaID
            ]);
        unlink($file); 
        return 0;
    }
}

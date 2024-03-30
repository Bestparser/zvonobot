<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Ankets;

class ImportExcel extends Command
{
    protected $createDateStart; // Начало исполнения скрипта
    protected $nameInputFile = 'excelFile'; // Название параметра "name" в форме input[type="file"]
    protected $nameDirectoryUploads = 'uploads'; // Название папки, куда загружается excel, которая находится в storage/app
    protected $errors = []; // Массив ошибок валидации на excel
    protected $rowExcel = 0; // Счетчик строк когда считываем excel
    protected $startRowExcel = 2; // С какой строки начинаем считывать данные из excel

    protected $RegionID; // Код региона
    protected $RegionName; // Наименование региона
    protected $PositionName; // Должность сотрудника в ППЭ
    protected $Worker; // ФИО сотрудника
    protected $UID; // ID сотрудника     
    protected $arrUID = array(); // Массив для запоминания UID (чтобы избежать одинаковые записи)

    protected $PhoneNumber; // Телефон
    protected $Email; // Эл почта
    protected $OrgID; // Код ОО, в котором работает сотрудник
    protected $OrgName; // Наименование ОО, в котором  работает сотрудник
    protected $ppeCode; // Код ППЭ сдачи экзамена
    protected $ppeName; // Наименование ППЭ сдачи экзамена

    protected $colEmpty = array(0, 2, 3, 4, 5, 6); // Поля (номер колонок), которые должны быть обязательными
    protected $Regions = []; // Одномерный массив кодов регионов из БД
    protected $Positions; // объект Должностей: код + русское название из БД
    protected $Workers; // Одномерный массив UID из БД
    protected $PositionID; // Сами вычисляем id должности (в excel его нет)

    protected $FirstName; // Распарсиваем ФИО (в excel они в одном поле)
    protected $LastName;
    protected $MiddLeName;

    protected $arrResult = []; // Конечный результат для записи в БД
    protected $resultTableDB = 'Worker'; // Название таблицы Worker    
    protected $logTableDB = 'ImportLog'; // Название таблицы Worker    

    protected $ignor = 0;
    

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Excel from FIS';    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function setErrors($rowExcel, $colExcel, $desc){ // Кладем в массив данные об ошибках
        $key = count($this->errors) + 1;
        $rowExcel = $rowExcel + $this->startRowExcel+1;
        $field = '';

        switch ($colExcel) {
            case 0:
                $colExcel = 'A';
                $field = '"Код"';
                break;
            case 1:
                $colExcel = 'B';
                $field = '"Наименование региона"';
                break;
            case 2:
                $colExcel = 'C';
                $field = '"Должность сотрудника в ППЭ"';
                break;
            case 3:
                $colExcel = 'D';
                $field = '"UID сотрудника"';
                break;
            case 4:
                $colExcel = 'E';
                $field = '"ФИО сотрудника"';
                break;
            case 5:
                $colExcel = 'F';
                $field = '"Телефон"';
                break;
            case 6:
                $colExcel = 'G';
                $field = '"Эл почта"';
                break;
            case 7:
                $colExcel = 'H';
                $field = '"Код ОО в котором работает сотрудник"';
                break;
            case 8:
                $colExcel = 'I';
                $field = '"Наименование ОО в котором работает сотрудник"';
                break;
        }

        $this->errors[$key]['row'] = $rowExcel;
        $this->errors[$key]['col'] = $colExcel;
        $this->errors[$key]['desc'] = $desc . ' ' . $field;
    }

    public function valid($row, $rowProperties){ // Непосредственно валидация
        if ($row >= $this->startRowExcel){
            // Убиреам пробелы в начале и в конце и избавляемся от спецсимволов
                $rowProperties = preg_replace('/[^ @ - - _ a-zа-я\d.]/ui', '', $rowProperties);
                $rowProperties = array_map('trim', $rowProperties);

            $this->RegionID = $rowProperties[0];
            $this->RegionName = $rowProperties[1];
            $this->PositionName = $rowProperties[2];
            $this->Worker = $rowProperties[4];
            $this->UID = $rowProperties[3];            
            $this->PhoneNumber = $rowProperties[5];
            $this->Email = $rowProperties[6];
            $this->OrgID = $rowProperties[7];
            $this->OrgName = $rowProperties[8];

            $this->ppeCode = $rowProperties[9];
            $this->ppeName = $rowProperties[10];

            // Проверка на обязательные поля            
                foreach ($this->colEmpty as $col) if ($this->validEmpty($row, $col, $rowProperties[$col]) === false) $this->setErrors($row, $col, 'Пустое поле');

            // Проверка на наличие в БД
                // Код региона
                    if ((!in_array($this->RegionID, $this->Regions)) and (!empty($this->RegionID))) $this->setErrors($row, 0, 'В базе данных отсутствует это поле из колонки');

                // Должность
                    $d = 0;                                
                    foreach ($this->Positions as $position){
                        if ($this->PositionName == $position->PositionName){
                            $d++;
                            $this->PositionID = $position->PositionID;
                        }
                    }
                    if ($d == 0) $this->setErrors($row, 2, 'В базе данных отсутствует это поле из колонки');

            // Далее проверяем ФИО, UID-32 и email
                if ((!filter_var($this->Email, FILTER_VALIDATE_EMAIL)) and (!empty($this->Email))) $this->setErrors($row, 6, 'Указана неправильная почта. Укажите только одну почту в поле');                
                if ((strlen($this->UID) != 36) and (!empty($this->UID))) $this->setErrors($row, 4, 'Указан неправильный ID сотрудника. Количество символов должно быть 32 в поле');
                $this->fio($this->Worker); // Распарсиваем ФИО
                if ((empty($this->LastName)) and (!empty($this->Worker))){
                    $this->setErrors($row, 3, 'Полностью не указаны ФИО в поле');
                }

            // Проверка на уникальность UID в excel    
                if (!in_array($this->UID, $this->arrUID)) {
                    $this->arrUID[$row] = $this->UID;
                } else {                    
                    $this->UID = -1;
                    $this->ignor++;
                }
                
            // Генерируем результативный массив для последующей единоразовой записи в БД
                if ((count($this->errors) == 0) and ($this->UID != -1)){
                    array_push($this->arrResult, array(
                        'UID' => $this->UID,
                        'RegionID' => $this->RegionID,
                        'PositionID' => $this->PositionID,
                        'LastName' => $this->LastName,
                        'PhoneNumber' => $this->PhoneNumber,
                        'FirstName' => $this->FirstName,
                        'MiddLeName' => $this->MiddLeName,
                        'Email' => $this->Email,
                        'OrgID' => $this->OrgID,
                        'OrgName' => $this->OrgName,
                        'ppe_code' => $this->ppeCode,
                        'ppe_name' => $this->ppeName,
                        'anketa_id' => session('anketaID')
                    ));
                }
        }
    }

    public function validEmpty($row, $col, $field){ // Проверка на обязательное поле
        if (empty($field)){
            return false;
        } else {
            return true;
        }
    }

    public function fio($fio){ // Распарсиваем ФИО
        $i = -1;
        $j = 0;
        $nameCount = 0;
        while ($i < strlen($fio)-1){
            $i++;
            if ($fio[$i] == ' '){
                $j++;
                if ($j == 1){
                    $familyCount = $i;
                    $this->LastName = substr($fio, 0, $familyCount);
                }
                if ($j == 2){
                    $nameCount = $i;
                    $this->FirstName = substr($fio, $familyCount + 1, $nameCount - $familyCount - 1);
                }
                $this->MiddLeName = substr($fio, $nameCount + 1, strlen($fio) - $nameCount -1);                
            }
        }        
        $this->FirstName = trim(preg_replace('/[^ @ a-zа-я\d.]/ui', '', $this->FirstName));
        $this->LastName = trim(preg_replace('/[^ @ a-zа-я\d.]/ui', '', $this->LastName));
        $this->MiddLeName = trim(preg_replace('/[^ @ a-zа-я\d.]/ui', '', $this->MiddLeName));
    }
    
    public function getRegions(){        
        $data = DB::table('Regions')->select('RegionCode')->orderBy('RegionCode', 'asc')->get();
        return $data;
    }

    public function getPositions(){ // Должность сотрудника
        $data = DB::table('Positions')->select('PositionID', 'PositionName')->get();
        return $data;
    }

    public function getWorkers(){
        $data = DB::table('Worker')->select('UID')->get();
        return $data;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Request $request)
    {
        $this->createDateStart = Carbon::now()->format('Y-m-d\TH:i:s'); // Начало исполнения скрипта
        $ankets = new Ankets();
        if ($request->hasFile($this->nameInputFile)) { // Если файл пришел
            $extension = $request->file($this->nameInputFile)->extension(); // Узнаем расширение файла

            if ((strtolower($extension) == 'xls') || (strtolower($extension) == 'xlsx')){ // Если расширение файла - xls или xlsx
                $path = storage_path('app/') . $request->file($this->nameInputFile)->storeAs($this->nameDirectoryUploads, $this->nameInputFile . '.' . $extension); // Полный путь + название файла
                
                $this->Regions = $ankets->translateToArray($this->getRegions(), 'RegionCode'); // Получаем одномерный массив кодов регионов из БД
                $this->Positions = $this->getPositions(); // Получаем объект Должностей: код + русское название из БД
                $this->Workers = $ankets->translateToArray($this->getWorkers(), 'UID'); // Получаем одномерный массив UID из БД
                
                $this->startRowExcel--;

                $rows = SimpleExcelReader::create($path) // Распарсиваем excel
                    ->noHeaderRow()
                    ->getRows()                    
                    ->each(function(array $rowProperties) {
                        $this->valid($this->rowExcel++, $rowProperties);
                    });

            } else {
                $this->setErrors(-1, -1, 'Вы загрузили файл с другим расширением');
            }
        } else {
            $this->setErrors(-1, -1, 'Вы не загрузили excel файл');
        }
        
        if (count($this->errors) > 0){ // Если есть ошибки        
            $request->session()->put('errorsExcel', $this->errors);
        } else { // Если валидация прошла чисто, то пишем в БД

            // Если при загрузке excel в селекторе выбрали "стереть тарое и записать как новое"
                if (session('truncateOld') == 1) $ankets->deleteWorkers(session('anketaID'));

            // Заранее считаем количество строк в БД до заливки чтобы потом орпеделить количество новых
                $startCount = DB::table($this->resultTableDB)->count();

            // Заранее фиксируем в массив удаленные ранее записи чтобы потом сравнить из файла
                $deletedWorkers = DB::table($this->resultTableDB)
                                            ->select('UID')
                                            ->where('DeleteType', 1)
                                            ->get();                                            

            // Запись excel в БД                
                $chunks = collect($this->arrResult)->chunk(1000);
                foreach ($chunks as $chunk) DB::table($this->resultTableDB)->upsert($chunk->toArray(), ['UID', 'anketa_id'], ['RegionID', 'PositionID', 'LastName', 'PhoneNumber', 'FirstName', 'MiddLeName', 'Email', 'OrgID', 'OrgName', 'ppe_code', 'ppe_name', 'anketa_id']);
                
            // Подробнее
                $details = '';
                if ($this->ignor > 0) $details = $details . 'Повторы в файле (игнорировано): ' . $this->ignor . ' '; // игноры
                
                // Новые строки
                    $finishCount = DB::table($this->resultTableDB)->count();
                    $newCount = $finishCount - $startCount;
                    if ($newCount > 0) $details = $details . 'Новые записи: ' . $newCount;

                // Если есть ранее удаленные 
                    foreach ($this->arrResult as $object){
                        $d = 0;
                        foreach ($deletedWorkers as $object2) if ($object['UID'] == $object2->UID) $d++;
                        if ($d > 0) $details = $details . 'Удаленные ранее (игнорировано): ' . $object['UID'];
                    }

            // Пишем логи                           
                DB::table($this->logTableDB)->insert([
                    'UserID' => (Auth::check()) ? Auth::user()->UserID : 0,
                    'CreateDateStart' => $this->createDateStart,
                    'CreateDateEnd' => Carbon::now()->format('Y-m-d\TH:i:s'),
                    'ImportRows' => count($this->arrResult),
                    'anketa_id' => session('anketaID'),
                    'Details' => $details,
                ]);

            // Чистка ОЗУ    
                unset($this->Regions);
                unset($this->Positions);
                unset($this->arrResult);                
                unset($this->arrUID);

        }

    }
}

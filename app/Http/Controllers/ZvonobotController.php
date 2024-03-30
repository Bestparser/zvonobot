<?php

namespace App\Http\Controllers;

use App\Services\zvonobotLoader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ZvonobotExcel;

class ZvonobotController extends Controller
{
    public $zl; // Для класса zvonobotLoader (загрузчик Звонобот)

    function __construct(){        
        $this->zl = new zvonobotLoader();
    }

    public function index(Request $request){        
        $log = DB::table($this->zl->logTableDB)
                        ->join('Users', 'zvonobotLog.user_id', '=', 'Users.UserID')
                        ->where('anketa_id', session('anketaID'))
                        ->orderBy('id', 'desc')
                        ->get();

        return view('zvonobot', ['log' => $log]);
    }

    public function loadcsv(Request $request){        
        $createDateStart = Carbon::now()->format('Y-m-d\TH:i:s'); // Начало исполнения скрипта        

        $this->zl->controlExtension = 'csv'; // Определяем что нас интересует расширение файла csv
        if ($this->zl->validLoadFile($request) === true){ // Если файл загружен и его расширение подлинное

            // Заранее готовим необходимые данные перед чтением файла
                $this->zl->questions = $this->zl->ankets->getQuestions(session('anketaID')); // Получаем вопросы из анкеты
                $this->zl->questionsCount = count($this->zl->questions)-1; // communication исключаем, он будет как статус (я должен установить статус)                
                foreach ($this->zl->questions as $question) $question->field = $this->zl->ankets->getFieldName($question->s_id); // Добавляем в объект вопросов наименование поля: Сommunication, IsWorkerRole ...
                $this->zl->workers = DB::table('Worker')->get(); // Готовим объект ТС (воркеры)        
            // end

            // Получеам содержимое файла и генерация результативных массивов
                $this->zl->contentFile = $this->zl->getContentFile($request); // Получаем содержимое файла
                foreach ($this->zl->contentFile as $csv) $this->zl->valid($csv); // НЕПОСРЕДСТВЕННО САМО ЧТЕНИЕ ПОСТРОЧНО ФАЙЛА + ВАЛИДАЦИЯ ПОД НАШ МЕХАНИЗМ + ГЕНЕРАЦИЯ РЕЗУЛЬТАТА
            // end

            // Готовим результативные массивы к записи в БД
                $this->zl->arrResult2 = $this->zl->exclude($this->zl->arrResult2, $this->zl->arrResult1, 'UID'); // Удаляем из "не тс" "основное завершение"    
                $this->zl->arrResult3 = $this->zl->exclude($this->zl->arrResult3, array_merge($this->zl->arrResult1, $this->zl->arrResult2), 'UID'); // Удаляем из всего остального "не тс" и "основное"
                $this->zl->errors = $this->zl->excludeFromErrors($this->zl->errors, array_merge($this->zl->arrResult1, $this->zl->arrResult2, $this->zl->arrResult3), 'phone'); // Удаляем из errors arrResult1, arrResult2, arrResult3
            // end

            // Запись в БД
                $this->zl->setResultDB($this->zl->excludeField(array_merge($this->zl->arrResult1, $this->zl->arrResult2, $this->zl->arrResult3), 'phone')); // Загрузка в БД (номера телефонов из массивов удаляем предварительно)        
            // end
        }

        // Логирование
            DB::table($this->zl->logTableDB)->insert([
                'all' => $this->zl->row2,
                'processed' => count($this->zl->arrResult1) + count($this->zl->arrResult2) + count($this->zl->arrResult3),
                'finished' => count($this->zl->arrResult1),
                'not_ts' => count($this->zl->arrResult2),
                'not_response' => count($this->zl->arrResult3),
                'user_id' => (Auth::check()) ? Auth::user()->UserID : 0,
                'create_date_start' => $createDateStart,
                'create_date_end' => Carbon::now()->format('Y-m-d\TH:i:s'),
                'anketa_id' => session('anketaID'),
                'errors' => json_encode($this->zl->errors),
                'errors_count' => count($this->zl->errors)
            ]);
        // end

        return redirect()->route('zvonobot');        
    }

    public function loadexcel(Request $request){
        $filename = 'zvonobot';
        return Excel::download(new ZvonobotExcel, $filename.'.xlsx');
    }



}

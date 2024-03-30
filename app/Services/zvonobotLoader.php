<?php

/*---------------------------------
|   ЗАГРУЗЧИК CSV В ЗВОНОБОТ
|
|   Наследуемый класс от Общего класса для загрузок файлов (на примере CSV)
|   Нужен для:
|       1.  Обработка именно загрузчика CSV Звонобот (после нажатия на кнопку "Загрузить CSV" на странице "Звонобот")
|
*/

namespace App\Services;

use Carbon\Carbon;
use App\Models\Ankets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class zvonobotLoader extends getFile{

    // Синонимы для вычисления ответов
    public $yes = 'да,участвовал,планирую,разумеется,несомнен,не сомнев,безусловно,так,железобетонно,разумеется,действительно,угу,правда,ок,конечно,хорошо,подлинно,однозначно,пусть,плюс,согласен,еще бы,так точно,точно,правда,вот именно,легко,ладно,ясно,типа того,правильно,верно,ага,отлично,реально,есть,истинно,йес,yes,желаю,определён,подход,достойн,вероятно,естествен,бесспорн,пожалуй,готов,утвердит,утвержд,могу,думаю,способ,вроде бы,не исключено,возможн,надеюсь,вроде да,умею,возмож,видимо,похоже,';
    public $no = 'нет,не могу,не планирую,не участвовал,';
    public $alo = 'да, 5,5 , 5 ,отлично,великолепно,чудесно,здорово,идеально,блестяще,первоклассно,знатно,безупречно,бесподобно,восхитительно,улет,йес,yes,ура,восторг,порядок,лучш,высший класс,красота,на хорошем уровне,';
    public $yaxsh = ' 4,4 , 4 ,хорошо,нормально,пойдет,сойдет,';    

    

    public $createDateStart; // Начало исполнения скрипта
    public $error; // Датчик ошибок    
    public $ankets; // Для класса Ankets (чтобы вопросы получить)
    public $questions; // Вопросы из Ankets
    public $questionsCount; // Количество вопросов
    public $workers; // ТС    

    // Поля, которые распарсиваем и номер колонки (с учетом, что "A" - номер 0)
    public $phoneColum = 0; // Номер поля где телефон
    public $phone; // Значение телефона
    public $tagColum = 6; // Номер колонки где теги
    public $tag; // Значение тега
    public $uid;

    // Результативные массивы для записи в БД
    public $arrResult1 = []; // основное завершение (все "опрошен")
    public $arrResult2 = []; // требуется звонок оператора (все "не тс")
    public $arrResult3 = []; // все остальные (нет ответа)

    public $resultTableDB = 'Calls'; // Таблица, куда записываем ответы
    public $logTableDB = 'zvonobotLog'; // Логи

    function __construct(){        
        $this->parser = new ParserCSV(); // Вызываем класс для распарсивания csv
        $this->ankets = new Ankets(); // Вызываем класс Анкет
    }    
    
    public function setErrors($col, $desc){ // (дополнение к абстрактному сугубо для Звонобота) Кладем в массив данные об ошибках
        $key = count($this->errors) - 1 + 1;        
        $field = '';

        switch ($col) {
            case 0:
                $col = 'A';
                $field = '"Номер"';
                break;
            case 1:
                $col = 'B';
                $field = '"Длительность исходящего вызова (сек)"';
                break;
            case 2:
                $col = 'C';
                $field = '"Длительность разговора с менеджером (сек)"';
                break;
            case 3:
                $col = 'D';
                $field = '"Дата"';
                break;
            case 4:
                $col = 'E';
                $field = '"Стоимость"';
                break;
            case 5:
                $col = 'F';
                $field = '"Комментарий"';
                break;
            case 6:
                $col = 'G';
                $field = '"Тег"';
                break;
            case 7:
                $col = 'H';
                $field = '';
                break;
            case 8:
                $col = 'I';
                $field = '';
                break;
            case 9:
                $col = 'J';
                $field = '';
                break;
            case 10:
                $col = 'K';
                $field = '';
                break;
            case 11:
                $col = 'L';
                $field = '';
                break;
        }

        
        $this->errors[$key]['phone'] = $this->phone;
        $this->errors[$key]['row'] = $this->row;
        $this->errors[$key]['col'] = $col;
        $this->errors[$key]['desc'] = ' ('.$this->phone.') ' . $desc . ' ' . $field;
    }
    public function valid($rowCSV){        
        $this->row++;
        if (is_numeric($rowCSV[$this->phoneColum])){ // Обрабатываем только строки, начинающиеся с номера телефона
            $this->row2++;
            if (!empty($rowCSV[$this->tagColum])){ // Рассматриваем строки, только с наличием тега
                $this->phone = $rowCSV[$this->phoneColum];
                $this->tag = 0;
                $this->tag = $rowCSV[$this->tagColum];
                $this->uid = $this->getUID($this->phone);
                $this->error = 0;

                if ($this->uid != 0){            
                    if ($this->tag == 'основное завершение'){ 
                        if ($this->error == 0) array_push($this->arrResult1, $this->setAnswers($rowCSV, 3, 1)); // Все "основное завершение" - ставим статус "Опрошен" и пишем ответы
                        $this->arrResult1 = $this->getUniqueArray($this->arrResult1); // Удаляем дубликаты (последний оставляем)
                    } elseif ($this->tag == 'не тс'){                     
                        if ($this->error == 0) array_push($this->arrResult2, $this->setAnswers($rowCSV, 6, 0)); // Все "не тс" - в статус "требуется звонок оператора"
                        $this->arrResult2 = $this->getUniqueArray($this->arrResult2); // Удаляем дубликаты (последний оставляем)
                    } else { 
                        if ($this->error == 0) array_push($this->arrResult3, $this->setAnswers($rowCSV, 1, 0)); // Все остальные теги - в статус "нет ответа"
                        $this->arrResult3 = $this->getUniqueArray($this->arrResult3); // Удаляем дубликаты (последний оставляем)
                    }
                }                    
            }
        }
    }
    public function getMobilePhone($phone){ // Вытаскиваем мобильный телефон из обычных телефонов Workers    
        $mobile = false;
        if (strlen($phone) > 18){
            $arrPhones = $this->getToArray($phone, ' ');
            for ($i = 1; $i <= count($arrPhones); $i++) $mobile = $this->validPhone($arrPhones[$i]);            
        } else {
            $mobile = $this->validPhone($phone);
        }
        return $mobile;
    }
    public function validPhone($phone){ // Это мобильный телефон?
        $phone = preg_replace('/[^0-9]/', '', $phone);        
        $mobile = false;
        if (strlen($phone) > 2){
            if (strlen($phone) < 11) $phone = '7' . $phone;
            if ($phone[0] == 8) $phone[0] = 7;
            if (($phone[1] == 9) and (strlen($phone) == 11)) $mobile = $phone;
        }
        return $mobile;
    }
    public function getToArray($get, $delimiter){ // Преобразование строки с разделителем        
        $arr = array();
		$d = 0;			
		$string = $get . $delimiter;
		$i = -1;
		$id_product = '';
		while ($i < strlen($string)-1){						
			$i++;							
			if ($string[$i] != $delimiter){
				$id_product = $id_product . $string[$i];
			} else {					
				$d++;
				$arr[$d] = $id_product;
				
				$id_product = '';	
			}
		}
		if ($d == 0) $arr[] = 0;			
		return $arr;
    }
    public function getAnswerTrue($answer, $col){ // Да / Нет? (Ответ на вопрос из анкеты) СИНОНИМЫ        
        $d = 0;
        foreach ($this->getToArray($this->no, ',') as $synonim) if (stripos('123' . $answer, $synonim) > 0) $d++;
        if ($d > 0) return 0;        
        if ($d == 0) foreach ($this->getToArray($this->yes, ',') as $synonim) if (stripos('123' . $answer, $synonim) > 0) $d++;        
        if ($d > 0) return 1;        
        if (($d == 0) and ($this->tag != 0)){
            $this->setErrors($col, '"'.$answer.'" Не может определить ответ. Измените поле ');        
            $this->error++;
        }
        
    }
    public function getMark($answer, $col){ // Оценка СИНОНИМЫ
        $d = 0;
        foreach ($this->getToArray($this->alo, ',') as $synonim) if (stripos('123' . $answer, $synonim) > 0) $d++;
        if ($d > 0) return 5;
        if ($d == 0) foreach ($this->getToArray($this->yaxsh, ',') as $synonim) if (stripos('123' . $answer, $synonim) > 0) $d++;
        if ($d > 0) return 4;        
        if (($d == 0) and ($this->tag != 0)){
            $this->setErrors($col, '"'.$answer.'" Не может определить ответ. Измените поле ');
            $this->error++;
        }
        
    }
    public function getUID($mobile){ // Получаем UID по номеру телефона
        $UID = 0;
        foreach ($this->workers as $worker){
            if ($this->getMobilePhone($worker->PhoneNumber) == $mobile) $UID = $worker->UID;
        }
        if ($UID == 0) $this->setErrors(0, 'В базе сервиса нет ТС с таким телефоном. Измените поле ');
        return $UID;
    }
    public function getUniqueArray($arr){ // Удаление повторяющихся UID в двумерном массиве кроме последнего
        $arr_uniq = array();
        $arr_result = array();
        $i = -1;
        foreach ($arr as $row){
            $i++;
            for ($j = 0; $j < count($arr_uniq); $j++) if ($arr_uniq[$j] == $row['UID']) unset($arr[$j]);
            $arr_uniq[$i] = $row['UID'];
        }
        $i = -1; // Переписываем порядоквые номера ячеек, потому что после unset порядок слетает
        foreach ($arr as $row){
            $i++;
            $arr_result[$i] = $row;
        }
        return $arr_result;
    }
    public function exclude($arr1, $arr2, $field){ // Удаляем во втором массиве UID, встречающийся в первом        
        $arr_result = array(); // Удаляем в пером массиве UID, который встречается во втором
        $i = 0;
        foreach ($arr2 as $row) $arr_uid[$i++] = $row[$field];

        $i = -1;
        foreach ($arr1 as $row){
            $i++;
            if (in_array($row[$field], $arr_uid)) unset($arr1[$i]);
        }
        $i = -1; // Переписываем порядоквые номера ячеек, потому что после unset порядок слетает
        foreach ($arr1 as $row){
            $i++;
            $arr_result[$i] = $row;
        }
        return $arr_result; 
    }
    public function excludeFromErrors($errorArr, $resultArr, $field){ // Удаляем из errors результативный массив по номеру телефона
        foreach ($resultArr as $row){
            $i = -1;
            foreach ($errorArr as $row2){
                $i++;
                if (in_array($row[$field], $row2)) unset($errorArr[$i]);
            }
        }
        return $errorArr;
    }
    public function excludeField($arr, $field){ // Исключаем ячейку phone из результативного массива перед upsert в базу
        $i = -1;
        foreach ($arr as $row){
            $i++;
            unset($arr[$i][$field]);
        }
        return $arr;
    }
    public function setAnswers($rowCSV, $Сommunication, $type){ // Кладем общие ответы (не динамические) для каждого результативного массива
        $j = 0;                        
        $start = $this->tagColum + 1;
        $finish = $this->tagColum + $this->questionsCount;
        if (!empty($rowCSV[$this->tagColum + $this->questionsCount + 1])){ // Делаем еще шаг в право на случай наличия колонки "Умная рассылка"
            $start = $start + 1;
            $finish = $finish + 1;
        }

        $answers = array();
        for ($i = $start; $i <= $finish; $i++) {
            $j++;                                
            $z = 0;
            foreach ($this->questions as $question){
                if ($question->field != 'Сommunication'){
                    $z++;
                    if ($z == $j){
                        if ($type == 1){
                            if ($question->field != 'Mark'){
                                $answers[$question->field] = $this->getAnswerTrue($rowCSV[$i], $i);
                            } else {
                                if (is_numeric($rowCSV[$i])) {
                                    $answers[$question->field] = $rowCSV[$i];                                
                                } else {
                                    $answers[$question->field] = $this->getMark($rowCSV[$i], $i);
                                }
                            }
                        } else {
                            $answers[$question->field] = null;
                        }
                    }
                }
            }
            if ((empty($rowCSV[$i])) and ($type == 1)){
                $this->setErrors($i, 'Пустой ответ на вопрос. Измените поле ');
                $this->error++;
            }
        }         

        $answers['phone'] = $this->phone;
        $answers['UID'] = $this->uid;
        $answers['Сommunication'] = $Сommunication;
        $answers['anketa_id'] = session('anketaID');
        $answers['CreateDate'] = Carbon::now()->format('Y-m-d\TH:i:s');
        $answers['UserID'] = (Auth::check()) ? Auth::user()->UserID : 0;
        
        return $answers;
    }
    public function setResultDB($resultArr){ // Кладем результативные массивы в БД
        DB::table($this->resultTableDB)->upsert(
            $resultArr,
            ['UID', 'anketa_id'], 
            Schema::getColumnListing($this->resultTableDB)            
        );
    }    


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Ankets extends Model
{
    use HasFactory;

    protected $anketaID;
    protected $table = 'ankets';
    public $uid;
    public $tags;

    function __construct(){
        $this->anketaID = session('anketaID'); 
        $this->tags = $this->getTags();
    }

    public function deleteWorkers($anketaID){
        $workers = DB::table('Worker')
                    ->select('UID')
                    ->where('anketa_id', '=', $anketaID)
                    ->get();

        $workers = $this->translateToArray($workers, 'UID');

        DB::table('Calls')->whereIn('UID', $workers)->delete();
        DB::table('Worker')->where('anketa_id', '=', $anketaID)->delete();        
    }
    public function translateToArray($data, $columName){
        if (count($data) > 0){
            $j=0;
            foreach ($data as $i) $arr[$j++] = $i->$columName;            
        } else {
            $arr = array();
        }
        return $arr;
    }
    public function getTags(){
        return DB::table('questions_type')
            ->orderBy('id', 'asc')
            ->get();        
    }
    public function getFields(){
        return DB::table('s_fields')->get();
    }
    public function getFieldName($id){ // Получение списка: Сommunication, IsWorkerRole, Experience
        return DB::table('s_fields')->where('id', '=', $id)->value('s_name');
    }



    public function getAllAnkets(){
        return DB::table('ankets')                    
                    ->orderBy('id', 'asc')
                    ->get();
    }
    public function getAnketa($id){
        return DB::table('ankets')->where('id', '=', $id)->first();               
    }



    public function getQuestions($id){   // Получение вопросов ID анкеты из сессии     
        return DB::table('questions')
            ->where('ankets_id', '=', $id)            
            ->orderBy('order', 'asc')
            ->get();
    }
    public function getQuestion($id){   // Получение конкретного вопроса
        return DB::table('questions')
            ->where('id', '=', $id)
            ->first();
    }



    public function getAnswersByQuestionID($id){ // Получение ответов по id вопроса
        return DB::table('answers')
            ->where('q_id', '=', $id)
            ->orderBy('order', 'asc')
            ->get();        
    }
    public function getAnswer($id){   // Получение конкретного ответа
        return DB::table('answers')
            ->where('id', '=', $id)
            ->first();
    }



    public function getEditCall($dataCall){
        $questions = $this->getQuestions($this->anketaID);
        foreach ($questions as $question){
            if ($question->hidden == 0){
                $answers = $this->getAnswersByQuestionID($question->id);
                foreach ($answers as $answer){
                    if ($answer->hidden == 0){
                        $answer->class = $this->colorAnswers($question->s_id, $answer->value);
                        $answer->active = $this->activeAnswer($this->uid, $question->s_id, $answer->value, $question->qt_id);
                        if ($answer->situation){
                            $answer->show = $this->situation($dataCall, $answer->situation);
                        } else {
                            $answer->show = true;
                        }
                    }
                }
                $question->s_name = $this->getFieldName($question->s_id);                
                $question->answers = $answers;
                if (count($answers) == 0) $question->answer = $this->activeAnswerValue($this->uid, $question->s_id); 
            } 
        }
        return $questions;
    }
    public function colorAnswers($s_fieldsID, $value){
        $class = '';
        if ($s_fieldsID == 1){
            if ($value == 0) $class = 'bg-red-50';
            if ($value == 1) $class = 'bg-red-50';
            if ($value == 2) $class = 'bg-red-50';
            if ($value == 3) $class = 'bg-green-50';
            if ($value == 4) $class = 'bg-blue-50';
        }
        if ($s_fieldsID == 2){
            if ($value == 0) $class = 'bg-red-50';
            if ($value == 1) $class = 'bg-green-50';
            if ($value == 2) $class = 'bg-green-50';
            if ($value == 3) $class = 'bg-red-50';            
        }
        return $class;
    }
    public function activeAnswer($uid, $s_id, $value, $qt_id){
        $mainTag = '';
        foreach ($this->tags as $tag) if ($tag->id == $qt_id) $mainTag = $tag->qt_name;

        $active = 0;
        $data = DB::table('Calls')
                    ->where('UID', '=', $uid)
                    ->where('anketa_id', '=', $this->anketaID)
                    ->value($this->getFieldName($s_id));

        if (($mainTag == 'check') or ($mainTag == 'radio')){
            $d = 0;            
            $string = strval($data);
            $start = -1;
            if ($data < 0){
                $d++;
                $start = 0;
            }
            
            while ($start < strlen($string)-1){
                $start++;
                if (($d > 0) and ($start == 1)){
                    $num = '-' . $string[$start];
                } else {
                    $num = $string[$start];
                }
                if ($num == $value) $active = 1;           
            }


        } else {
            if ($data == $value) $active = 1;
        }

        return $active;
    }
    public function activeAnswerValue($uid, $s_id){        
        return $data = DB::table('Calls')
                    ->where('UID', '=', $uid)
                    ->value($this->getFieldName($s_id));
    }
    public function situation($dataCall, $json){
        // Показывать только для
        $show = '';
        $res = json_decode($json, true); 
        if ($res){
            $i = -1;
            while ($i < count($res)-1){
                $i++;                
                $showOrHidden = array_keys($res[$i])[0];
                if ($showOrHidden == 'show') $show = false;
                if ($showOrHidden == 'hidden') $show = true;
                $field = array_keys($res[$i][$showOrHidden][0])[0];
                foreach ($res[$i][$showOrHidden][0][$field] as $val){
                    if (($dataCall->$field == $val) and ($showOrHidden == 'show')) $show = true;
                    if (($dataCall->$field == $val) and ($showOrHidden == 'hidden')) $show = false;
                }   
            }
        }
        return $show;
    }

}


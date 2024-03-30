<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Ankets;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class AnketsController extends Controller
{
    private $ankets; // Для класса из модели Ankets    

    function __construct(){
        $this->ankets = new Ankets(); // Вызываем класс модели Ankets        
    }

    public function routerAnkets(Request $request){ // Основная страница "Анкеты". Роутер внутри роутера. Распределение дочерних страниц через get
        if ($request->get('action') == 'addAnketa'){            
            return $this->addAnketaForm($request); // Форма добавления новой анкеты
        } elseif ($request->get('anketaID') > 0){
            return $this->anketaEditForm($request); // Форма редактирования анкеты
        } elseif ($request->get('questionsAnketaID') > 0){            
            return $this->getQuestions($request); // Список вопросов анкеты
        } elseif ($request->get('action') == 'addQuestion'){
            return $this->addQuestionForm($request); // Форма добавления нового вопроса
        } elseif ($request->get('editQuestionID') > 0){
            return $this->questionEditForm($request); // Форма редактирования вопроса
        } elseif ($request->get('answersQuestionID') > 0){
            return $this->getAnswers($request); // Список ответов на вопрос
        } elseif ($request->get('action') == 'addAnswer'){
            return $this->addAnswerForm($request); // Форма добавления нового ответа
        } elseif ($request->get('editAnswerID') > 0){
            return $this->answerEditForm($request); // Форма редактирования ответа
        } else { // Список анкет
            return $this->getAnkets($request); // Список анкент на странице "Анкеты"
        }
    }


    // Анкеты
    private function getAnkets($request){ // Список анкент на странице "Анкеты"        
        $anketsData = $this->ankets->getAllAnkets();
        return view('ankets', [
            'router' => 'getAnkets',
            'anketaID' => $request->get('anketaID'),
            'ankets' => $anketsData,
            'action' => $request->get('action'),
            'add' => 'Anketa',
            'questionsAnketaID' => null,
            'answersQuestionID' => null,
        ]);        
    }
    private function addAnketaForm($request){ // Форма добавления новой анкеты
        return view('ankets', [
            'router' => 'addQuestion',
            'action' => $request->get('action'),
            'add' => null,            
        ]);
    }
    public function anketaAddSave(Request $request){ // Сохранение новой анкеты
        $valid = request()->validate([
            'anketaName' => 'string',            
            'anketaHidden' => 'integer',
        ]);        

        DB::table('ankets')->insert([
            'a_name' => $request->post('anketaName'),
            'desc' => $request->post('anketaDesc'),
            'hidden' => $request->post('anketaHidden')
        ]);

        return redirect()->route('ankets');
    }
    private function anketaEditForm($request){ // Форма редактирования анкеты
        $anketaData = $this->ankets->getAnketa($request->get('anketaID'));
        return view('ankets', [
            'router' => 'anketaEdit',
            'anketaID' => $request->get('anketaID'),
            'anketa' => $anketaData,
            'action' => $request->get('action'),
            'add' => null,
        ]);
    }
    public function anketaEditSave(Request $request){ // Сохранение отредактированной анкеты
        $valid = request()->validate([
            'anketaID' => 'integer',
            'anketaName' => 'string',            
            'anketaHidden' => 'integer',            
        ]);        

        DB::table('ankets')->where('id', $request->post('anketaID'))->update([
            'a_name' => $request->post('anketaName'),
            'desc' => $request->post('anketaDesc'),
            'hidden' => $request->post('anketaHidden')
        ]);        

        return redirect()->route('ankets');
    }
    public function anketaDelete(Request $request){ // Удаление анкеты
        $questions = $this->ankets->getQuestions($request->post('id'));
        foreach ($questions as $question){            
            $answers = $this->ankets->getAnswersByQuestionID($question->id);
            foreach ($answers as $answer){
                DB::table('answers')->where('id', $answer->id)->delete();
            }
            DB::table('questions')->where('id', $question->id)->delete();
        }
        DB::table('ankets')->where('id', $request->post('id'))->delete();
        $this->ankets->deleteWorkers($request->post('id'));
        return redirect()->route('ankets');
    }   
    // end Анкеты



    // Вопросы
    private function getQuestions($request){ // Список вопросов анкеты
        $questions = $this->ankets->getQuestions($request->get('questionsAnketaID'));
        foreach ($questions as $question){
            $question->teg = DB::table('questions_type')->where('id', '=', $question->qt_id)->value('qt_name');
            $question->field = $this->ankets->getFieldName($question->s_id);
        }

        $request->session()->put('questionURL', url()->full());
        $request->session()->put('comebackURL', url()->full());
        
        return view('ankets', [
            'router' => 'getQuestions',
            'questionsAnketaID' => $request->get('questionsAnketaID'),
            'questions' => $questions,
            'action' => $request->get('action'),
            'add' => 'Question',
            'anketa' => $this->ankets->getAnketa($request->get('questionsAnketaID'))->a_name,
        ]);        
    }
    private function addQuestionForm($request){ // Форма добавления нового вопроса
        $fields = $this->ankets->getFields();
        $questions = $this->ankets->getQuestions($request->get('a_id'));
        
        foreach ($fields as $field){
            $field->ban = 0;
            foreach ($questions as $question) if ($question->s_id == $field->id) $field->ban = 1;            
        }

        return view('ankets', [
            'router' => 'addQuestion',
            'action' => $request->get('action'),
            'add' => null,
            'anketaID' => $request->get('a_id'),
            'tags' => $this->ankets->getTags(),
            'fields' => $fields,    
        ]);        
    }
    public function questionAddSave(Request $request){ // Сохранение нового вопроса
        $valid = request()->validate([
            'questionName' => 'string',
            'qt_id' => 'integer',
            's_id' => 'integer',
            'questionHidden' => 'integer',            
        ]);   
        DB::table('questions')->insert([
            'q_name' => $request->post('questionName'),
            'qt_id' => $request->post('qt_id'),
            'ankets_id' => $request->post('anketaID'),
            's_id' => $request->post('s_id'),
            'hidden' => $request->post('questionHidden'),
            'order' => $request->post('questionOrder'),
        ]);

        return Redirect::to(session('comebackURL'));
    }
    private function questionEditForm($request){ // Форма редактирования вопроса
        $question = $this->ankets->getQuestion($request->get('editQuestionID'));
        $question->tagID = DB::table('questions_type')->where('id', '=', $question->qt_id)->value('id');
        $question->field = $this->ankets->getFieldName($question->s_id);

        $fields = $this->ankets->getFields();        
        $questions = $this->ankets->getQuestions($question->ankets_id);        
        foreach ($fields as $field){
            $field->ban = 0;
            foreach ($questions as $q) if (($q->s_id == $field->id) and ($question->field != $field->s_name)) $field->ban = 1;            
        }

        return view('ankets', [
            'router' => 'editQuestion',
            'editQuestionID' => $request->get('editQuestionID'),
            'question' => $question,
            'action' => $request->get('action'),
            'tags' => $this->ankets->getTags(),
            'fields' => $fields,
            'add' => null,
        ]);
    }
    public function questionEditSave(Request $request){ // Сохранение отредактированного вопроса
        $valid = request()->validate([
            'questionName' => 'string',
            'qt_id' => 'integer',
            's_id' => 'integer',
            'questionHidden' => 'integer',            
        ]);     
        
        DB::table('questions')->where('id', $request->post('questionID'))->update([
            'q_name' => $request->post('questionName'),
            'qt_id' => $request->post('qt_id'),
            's_id' => $request->post('s_id'),
            'hidden' => $request->post('questionHidden'),
            'order' => $request->post('questionOrder'),
        ]);        

        return Redirect::to(session('comebackURL'));
    }
    public function questionDelete(Request $request){ // Удаление ответа
        DB::table('questions')->where('id', $request->post('id'))->delete();
        DB::table('answers')->where('q_id', $request->post('id'))->delete();
        return Redirect::to(session('comebackURL'));
    }
    // end Вопросы



    // Ответы
    private function getAnswers($request){ // Список ответов на вопрос
        $answers = $this->ankets->getAnswersByQuestionID($request->get('answersQuestionID'));        
        
        $request->session()->put('comebackURL', url()->full());

        return view('ankets', [            
            'router' => 'getAnswers',
            'questionID' => $request->get('answersQuestionID'),
            'answers' => $answers,
            'action' => $request->get('action'),
            'add' => 'Answer',
            'questionsAnketaID' => null,
            'question' => $this->ankets->getQuestion($request->get('answersQuestionID'))->q_name,
            'answersQuestionID' => $request->get('answersQuestionID'),        
            'comebackURL' => session('questionURL'),
        ]);
    }
    private function addAnswerForm($request){ // Форма добавления нового ответа
        return view('ankets', [
            'router' => 'addQuestion',
            'action' => $request->get('action'),
            'add' => null,
            'questionID' => $request->get('q_id'),
        ]);                
    }
    public function answerAddSave(Request $request){ // Сохранение нового ответа
        $valid = request()->validate([
            'answerName' => 'string',            
            'answerValue' => 'string',            
            'answerHidden' => 'integer',            
        ]);

        DB::table('answers')->insert([
            'answer_name' => $request->post('answerName'),            
            'q_id' => $request->post('questionID'),
            'order' => $request->post('answerOrder'),
            'value' => $request->post('answerValue'),
            'situation' => $request->post('answerSituation'),
            'hidden' => $request->post('answerHidden'),            
        ]);

        return Redirect::to(session('comebackURL'));
    }
    private function answerEditForm($request){ // Форма редактирования ответа
        $answer = $this->ankets->getAnswer($request->get('editAnswerID'));

        return view('ankets', [
            'router' => 'editAnswer',            
            'answer' => $answer,
            'action' => $request->get('action'),
            'add' => null,
        ]);

    }
    public function answerEditSave(Request $request){ // Сохранение отредактированного ответа
        $valid = request()->validate([
            'answerName' => 'string',            
            'answerValue' => 'string',            
            'answerHidden' => 'integer',            
        ]);

        DB::table('answers')->where('id', $request->post('answerID'))->update([
            'answer_name' => $request->post('answerName'),            
            'order' => $request->post('answerOrder'),
            'value' => $request->post('answerValue'),
            'situation' => $request->post('answerSituation'),
            'hidden' => $request->post('answerHidden'),
        ]);        

        return Redirect::to(session('comebackURL'));
    }
    public function answerDelete(Request $request){ // Удаление ответа
        DB::table('answers')->where('id', $request->post('id'))->delete();
        return Redirect::to(session('comebackURL'));
    }
    // end Ответы

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Call extends Model
{

    protected $primaryKey = 'CID';
    protected $table = 'vCalls';

    protected $fillable = [
        'CID',
        'UID',
        'RegionID',
        'PositionID',
        'Username',
        'StationCode', // ППЭ
        'Сommunication', // Удалось связаться с пользователем?
        'IsWorkerRole', // Вы являетесь техническим специалистом пункта проведения экзаменов ЕГЭ-2023?
        'Experience', // Вы уже участвовали в качестве технического специалиста ППЭ или это Ваш первый опыт?
        'KEGE', // Будете ли задействованы в качестве технического специалиста при проведении КЕГЭ в 2022 году? ПОКА ОТКЛЮЧЕНО 
        'StudyDate', // Когда планируете пройти обучение на учебной платформе ФЦТ в 2023 году?
        'RegionStudy', // Планируете ли Вы проходить обучение на региональном уровне?
        'AppFederal', // В каких федеральных апробациях Вы принимали и/или планируете принять участие?
        'Mark', // Оцените степень своей готовности к ЕГЭ-2023 по шкале от 1 до 5
        'UserID',
        'PhoneNumber',
        'CreateDate',
        'Email',
        'OrgID',
        'OrgName',        
    ];

    protected $dates = [
         'CreateDate'
    ];

    protected $casts = [
          'CreateDate' => 'datetime',
    ];


    public function getСommunicationNameAttribute() { 
        // Удалось связаться с пользователем?
        if ($this->Сommunication == 0) return 'неверный номер';
        if ($this->Сommunication == 1) return 'нет ответа';
        if ($this->Сommunication == 2) return 'отказались отвечать';
        if ($this->Сommunication == 3) return 'опрошен';
        if ($this->Сommunication == 4) return 'перезвонить позже (некогда говорить)';
        if ($this->Сommunication == 5) return 'ожидают звонок';
        if ($this->Сommunication == 6) return 'требуется звонок оператора';

        return '';
        //return "{$this->Сommunication} {$this->Сommunication}";
    }

    public function getBgAttribute() { 
        // Цвета для селектора и строчки в простыне
        if ($this->Сommunication == 0) return 'bg-red-50';
        if ($this->Сommunication == 1) return 'bg-red-50';
        if ($this->Сommunication == 2) return 'bg-red-50';
        if ($this->Сommunication == 3) return 'bg-green-50';
        if ($this->Сommunication == 4) return 'bg-blue-50';
        //if ($this->Сommunication == 5) return 'bg-blue-50';

        return '';
        //return "{$this->Сommunication} {$this->Сommunication}";
    }

    public function getIsWorkerRoleNameAttribute() {
        /* IsWorkerRole Вы являетесь техническим специалистом пункта проведения экзаменов ЕГЭ-2023? */
        if ($this->Сommunication != 3) return '';
        if ($this->IsWorkerRole == 0) return 'нет';
        if ($this->IsWorkerRole == 1) return 'да';
        if ($this->IsWorkerRole == 2) return 'не знаю';
        if ($this->IsWorkerRole == 3) return 'не принимаю участие в ЕГЭ';
        return '';
    }

    public function getExperienceNameAttribute() {
        /* Experience Вы уже участвовали в качестве технического специалиста ППЭ в предыдущие годы или это Ваш первый опыт? */
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return ''; //
        if ($this->Experience == 0) return 'нет, впервые';
        if ($this->Experience == 1) return 'да, повторно';
        return '';
    }

    public function getKEGENameAttribute() {
        /* KEGE Будете ли задействованы в качестве технического специалиста при проведении КЕГЭ в 2022 году? */
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return ''; //
        if ($this->KEGE == 0) return 'нет';
        if ($this->KEGE == 1) return 'да';
        if ($this->KEGE == 2) return 'затрудняюсь ответить';
        return '';
    }

    public function getStudyDateNameAttribute() {
        /* StudyDate Когда планируете пройти обучение на учебной платформе ФЦТ в 2023 году? */
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return ''; //
        if ($this->StudyDate == 0) return 'не собираюсь проходить обучение';
        if ($this->StudyDate == 3) return 'март';
        if ($this->StudyDate == 4) return 'апрель';
        if ($this->StudyDate == 5) return 'май';
       /* if ($this->StudyDate == 6) return 'июнь';
        if ($this->StudyDate == 7) return 'июль'; 
        if ($this->StudyDate == 8) return 'август'; */
        if ($this->StudyDate == 9) return 'затрудняюсь ответить';
		if ($this->StudyDate == 10) return 'обучение пройдено';
        return '';
    }

    public function getRegionStudyNameAttribute() {
        /* RegionStudy Планируете ли Вы проходить обучение на региональном уровне? */
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return ''; //
        if ($this->RegionStudy == 0) return 'нет';
        if ($this->RegionStudy == 1) return 'да';
        if ($this->RegionStudy == 2) return 'затрудняюсь ответить';
        return '';
    }

    public function getAppFederalNameAttribute() {
        /* AppFederal В каких федеральных апробациях Вы принимали и/или планируете принять участие? */
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return ''; //

        $rezult = $this->getAppFederalExportAttribute();

        if ((int)$this->AppFederal < 10) {
            return $rezult;
        } else {
            return '...';
        }
    }

    public function getAppFederalExportAttribute() {
        /* AppFederal В каких федеральных апробациях Вы принимали и/или планируете принять участие? 
        30.11.2022 г., 17.02.2023 г., 10.03.2023 г., 17.05.2023 г. 
        */
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return ''; //

        $rezult = '';

        if (strpos('##'.$this->AppFederal, '1')>0) $rezult .= '30.11.2022 '; // 30.11.2022
        if (strpos('##'.$this->AppFederal, '2')>0) $rezult .= '17.02.2023 '; // 17.02.2023
        if (strpos('##'.$this->AppFederal, '3')>0) $rezult .= '10.03.2023 '; // 10.03.2023
		
        if (strpos('##'.$this->AppFederal, '5')>0) $rezult .= '17.05.2023 '; // 17.05.2023 
      /*  if (strpos('##'.$this->AppFederal, '6')>0) $rezult .= '19.03.2022 '; // 19.03.2022
        if (strpos('##'.$this->AppFederal, '7')>0) $rezult .= '26.03.2022 '; // 26.03.2022
        if (strpos('##'.$this->AppFederal, '8')>0) $rezult .= '27.04.2022 '; //	27.04.2022
        if (strpos('##'.$this->AppFederal, '9')>0) $rezult .= '23.04.2022 '; // 23.04.2022		*/
		
        if (strpos('##'.$this->AppFederal, '4')>0) $rezult .= 'затрудняюсь ответить ';
        if (strpos('##'.$this->AppFederal, '0')>0) $rezult .= 'не принимаю ';

        return $rezult;
    }

    public function getAppRegionNameAttribute() {
        /* AppRegion Планируете ли Вы проходить обучение на региональном уровне? */
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return ''; //
        if ($this->AppRegion == 0) return 'нет';
        if ($this->AppRegion == 1) return 'да';
        if ($this->AppRegion == 2) return 'затрудняюсь ответить';
        return '';
    }

    public function getCreateDateNameAttribute() {
        if (!isset($this->CreateDate)) return '';
        $dt = Carbon::parse($this->CreateDate);
        return $dt->format('d.m.Y H:i:s');
    }

    public function getMarkNameAttribute() {
        /* Mark Оцените степень своей готовности к ЕГЭ-2023 по шкале от 1 до 5 */
        if (!isset($this->Mark)) return '';
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return '';
        $mark = (int) $this->Mark;

        if ($mark < 0 || $mark > 5){
            return '';
        }
        return $mark;
    }

  /*  public function getMarkAttribute($value) {
        if (!isset($this->Mark)) return '';
        if ($this->Сommunication != 3 or ($this->IsWorkerRole != 1 && $this->IsWorkerRole != 2)) return '';
        $mark = (int) $value;

        if ($mark < 0 || $mark > 5){
            return '';
        }
        return $mark;
    }*/

    public function getChe0Attribute() {
        if (strpos('##'.$this->AppFederal, '0')>0) {
            return ' checked';
        } else {
            return '';
        }
    }    

    public function getChe1Attribute() {
        if (strpos('##'.$this->AppFederal, '-1')>0) return '';
        if (strpos('##'.$this->AppFederal, '1')>0) {
            return ' checked';
        } else {
            return '';
        }
    }

    public function getChe2Attribute() {
        if (strpos('##'.$this->AppFederal, '2')>0) {
            return ' checked';
        } else {
            return '';
        }
    }

    public function getChe3Attribute() {
        if (strpos('##'.$this->AppFederal, '3')>0) {
            return ' checked';
        } else {
            return '';
        }
    }

    public function getChe4Attribute() {
        if (strpos('##'.$this->AppFederal, '4')>0) {
            return ' checked';
        } else {
            return '';
        }
    }

    public function getChe5Attribute() {
        if (strpos('##'.$this->AppFederal, '5')>0) {
            return ' checked';
        } else {
            return '';
        }
    }
	
    public function getChe6Attribute() {
        if (strpos('##'.$this->AppFederal, '6')>0) {
            return ' checked';
        } else {
            return '';
        }
    }	
	
    public function getChe7Attribute() {
        if (strpos('##'.$this->AppFederal, '7')>0) {
            return ' checked';
        } else {
            return '';
        }
    }

    public function getChe8Attribute() {
        if (strpos('##'.$this->AppFederal, '8')>0) {
            return ' checked';
        } else {
            return '';
        }
    }	

    public function getChe9Attribute() {
        if (strpos('##'.$this->AppFederal, '9')>0) {
            return ' checked';
        } else {
            return '';
        }
    }	    


}

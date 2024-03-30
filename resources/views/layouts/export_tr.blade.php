<td class="text-left">({{ $i->RegionID}}) {{ $i-> RegionName}}</td> <!-- Регион -->
<td class="">{{ $i-> PositionName}}</td> <!-- Должность -->
<td class="text-left">{{ $i-> Worker}}</td> <!-- ФИО -->
<td class="">{{ $i-> PhoneNumber }}</td> <!-- Телефон -->


    @foreach ($questions as $question)
        @php 
            foreach ($fields as $field) if ($field->id == $question->s_id) $question->nameField = $field->s_name; 
            $answerValue = $i->toArray()[$question->nameField];
            $answerTotal = '';
            if (count($question->answers) > 0){
                foreach ($question->answers as $answer) if ($answer->value == $answerValue) $answerTotal = $answer->answer_name;
            } else {                        
                $answerTotal = $answerValue;
            }
        @endphp
        <td>{{ $answerTotal }}</td>
    @endforeach


<td class="{{ $i-> bg }}">{{ $i-> UserName }}</td>
<td class="{{ $i-> bg }} text-xs">{{ $i-> CreateDateName }}</td>

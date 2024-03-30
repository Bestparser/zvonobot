<select data-id="select" onchange="onchange_communication();" id="{{$anketa->s_name}}" name="{{$anketa->s_name}}" class="w-32 h-6 m-0 p-0.5 text-xs bg-transparent border-blue-800 item">
    @foreach ($anketa->answers as $answer)
        @if ($answer->show === true)
            <option @if ($answer->active == 1) selected @endif item-id="{{ $answer->show }}" data-id="{{ $answer->situation }}" class="{{ $answer->class }}" value="{{ $answer->value }}">{{ $answer->answer_name }}</option>
        @endif
    @endforeach
</select>
<div class="m-2 text-gray-300">{{$anketa->s_name}}</div>
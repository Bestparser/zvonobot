@foreach ($anketa->answers as $answer)
    @if ($answer->show === true)
        <input data-id="radio" @if ($answer->active == 1) checked @endif id="{{$anketa->s_name}}" name="{{$anketa->s_name}}" type="radio" value="{{ $answer->value }}" />
        <label>{{ $answer->answer_name }}</label></br>
    @endif
@endforeach
<div class="m-2 text-gray-300">{{$anketa->s_name}}</div>
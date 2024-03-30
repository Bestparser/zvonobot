@foreach($ankets as $anketa)
    <div class="questionBlocks">
        <div class="question">
            {{$anketa->q_name}}
        </div>
        <div class="answer">
            @if(count($anketa->answers) > 0)           
                @if ($anketa->qt_id == 1) @include('layouts.ankets.select') @endif
                @if ($anketa->qt_id == 2) <div id="parent_{{$anketa->s_name}}">@include('layouts.ankets.check') </div>@endif
                @if ($anketa->qt_id == 3) <div id="parent_{{$anketa->s_name}}">@include('layouts.ankets.radio') </div>@endif
            @else
                @if ($anketa->qt_id == 4) @include('layouts.ankets.text') @endif
                @if ($anketa->qt_id == 5) @include('layouts.ankets.varchar') @endif
            @endif
        </div>                
    </div>
@endforeach  
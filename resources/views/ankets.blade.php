<x-app-layout>
    <x-slot name="header">
        <div class="h-7">
            <div class="font-normal addUserButton">
                <div class="mr-2">
                    @if ($add)
                        <a href="{{ route('ankets') }}?action=add{{ $add }}@if ($questionsAnketaID)&a_id={{ $questionsAnketaID }} @elseif ($answersQuestionID)&q_id={{ $answersQuestionID }} @endif" class=" button-with-icon hover:bg-green-700 bg-green-600 rounded text-white px-3 py-2 pr-5 hover:drop-shadow-md flex items-center uppercase text-sm">
                            <svg fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="24px" height="24px"><path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 11 7 L 11 11 L 7 11 L 7 13 L 11 13 L 11 17 L 13 17 L 13 13 L 17 13 L 17 11 L 13 11 L 13 7 L 11 7 z"/></svg>
                            Создать
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="script">
        <script>
                $(document).ready(function(){
 
                });
        </script>
    </x-slot>

    <div class="py-1">

        <div class="max-w-full mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 bg-white border-b border-gray-200">
                    <div style="height: 80vh;" class="flex flex-col">
                        <div class="flex-grow overflow-auto px-10">
                            @if ($router == 'getAnkets') @include('layouts.ankets.ankets')
                            @elseif ($action == 'addAnketa') @include('layouts.ankets.anket_add')
                            @elseif ($router == 'anketaEdit') @include('layouts.ankets.anket_edit')

                            @elseif ($router == 'getQuestions') @include('layouts.ankets.anket_questions')
                            @elseif ($action == 'addQuestion') @include('layouts.ankets.question_add')
                            @elseif ($router == 'editQuestion') @include('layouts.ankets.question_edit')

                            @elseif ($router == 'getAnswers') @include('layouts.ankets.answers')
                            @elseif ($action == 'addAnswer') @include('layouts.ankets.answer_add')
                            @elseif ($router == 'editAnswer') 
                                @include('layouts.ankets.answer_edit') 
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-2 w-full text-xs text-center">
                {{ config('app.name') }}, {{ config('app.ver') }} U{{ Auth::user()->UserID }} <span id="online"></span>
            </div>

        </div>
    </div>
</x-app-layout>

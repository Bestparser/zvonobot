<x-app-layout>
    <x-slot name="header">
        <div class="h-7">

            <div class="font-normal addUserButton getReportExcel">
                <div class="mr-2">
                    <a href="{{ route('layouts.zvonobot.loadexcel') }}" class=" button-with-icon hover:bg-green-700 bg-green-600 rounded text-white px-3 py-2 pr-5 hover:drop-shadow-md flex items-center uppercase text-sm">                        
                        Выгрузить Excel
                    </a>
                </div>
            </div> 

        </div>
    </x-slot>

    <x-slot name="script">
        <script>
                $(document).ready(function(){

                });
                function closeModalErrorImportExcel(){
                    $('#modalErrorImportExcel').remove();                    
                }                                
        </script>
    </x-slot>

    <div class="py-1">

        <pre id="msg" class="text-sm"></pre>
        <div id="startimport_cont"  class="text-center my-5">
            <form action="{{route('layouts.zvonobot.loadcsv')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="csvFile" />
                <button type="submit" class="px-2 py-1 bg-indigo-500 rounded text-white hover:bg-indigo-400">
                    Загрузить CSV
                </button>                
            </form> 
        </div>

        <div class="max-w-full mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 bg-white border-b border-gray-200">



                    <div style="height: 70vh;" class="flex flex-col">
                        <div class="flex-grow overflow-auto px-10">

                            <table class="mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
                                <tr class="h-10">
                                    <th class="bg-blue-50">ИД</th>
                                    <th class="bg-blue-50">Обработано</th>
                                    <th class="bg-blue-50">Основное завершение</th>
                                    <th class="bg-blue-50">Не ТС (требуется </br>звонок оператора)</th>
                                    <th class="bg-blue-50">Нет ответа</th>
                                    <th class="bg-blue-50">Ошибки</th>
                                    <th class="bg-blue-50">Описание ошибок</th>
                                    <th class="bg-blue-50">Пользователь</th>
                                    <th class="bg-blue-50">Дата старт</th>
                                    <th class="bg-blue-50">Дата финиш</th>
                                </tr>
                                <tbody class="divide-y">
                                    @php $r = 1; @endphp
                                    @forelse ($log as $i)
                                        @php
                                            $dstart = Carbon\Carbon::parse($i->create_date_start)->format('d.m.Y H:i:s');
                                            $dend = Carbon\Carbon::parse($i->create_date_end)->format('d.m.Y H:i:s');                                            
                                        @endphp
                                        <tr class="whitespace-nowrap callstr {{ ($r % 2 == 0 ? '' : 'bg-gray-50') }} @if ($i->errors_count > 0) bg-red-50 @endif">                                            
                                            <td class="p-1">{{ $i->id }}</td>
                                            <td class="p-1">{{ $i->all }}</td>
                                            <td class="p-1">{{ $i->finished }}</td>
                                            <td class="p-1">{{ $i->not_ts }}</td>
                                            <td class="p-1">{{ $i->not_response }}</td>

                                            <td class="p-1">{{ $i->errors_count }}</td>
                                            <td style="text-align: left;" class="p-1">
                                                <div class="errorScroll">@php
                                                        $json = json_decode($i->errors);
                                                        foreach ($json as $error){
                                                            echo '<div>';
                                                            if ($error->row > 0) echo $error->col . ':' . $error->row . ' ';
                                                            echo $error->desc;
                                                            echo '</div>';
                                                        }
                                                    @endphp</div>
                                            </td>
                                            <td class="p-1">{{ $i->UserName }}</td>
                                            <td class="p-1">{{ $i->create_date_start }}</td>
                                            <td class="p-1">{{ $i->create_date_end }}</td>
                                        </tr>
                                        @php $r = $r+1;  @endphp
                                    @empty
                                        <tr><td colspan="13" class="border border-blue-200 px-2 py-10 text-center text-red-500">нет данных</td></tr>
                                    @endforelse
                                </tbody>                                

                            </table>

                        </div>
                    </div>

                </div>
            </div>


            <div class="m-2 w-full text-xs text-center">
                {{ config('app.name') }}, {{ config('app.ver') }} {{ Auth::user()->UserID }}
            </div>


        </div>
    </div>
</x-app-layout>

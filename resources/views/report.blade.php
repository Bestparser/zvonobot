<x-app-layout>
    <x-slot name="header">
        <div class="h-7">

            <div class="font-normal addUserButton getReportExcel">
                <div class="mr-2">
                    <a href="{{ route('reporttoexcel') }}" class=" button-with-icon hover:bg-green-700 bg-green-600 rounded text-white px-3 py-2 pr-5 hover:drop-shadow-md flex items-center uppercase text-sm">                        
                        Результаты обзвона ТС
                    </a>
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

                            <div class="mt-2 font-bold text-center">Сводная статистика по субъектам Российской Федерации</div>


                            <div class="flex justify-center w-full">
                                <div class="item">

                            <table class="w-auto">
                                <tr>
                                <td align="center">
                                    @php        
                                        if ($CountAll == 0){
                                            $kf = 0;
                                        } else {
                                            $kf = (300 / $CountAll);
                                        }									                                        
                                        $Percent1 = $CountAll == 0 ? 0 : round($Сommunication5 * 100 / $CountAll, 2);
                                        $Percent2 = $CountAll == 0 ? 0 : round($CountConnect * 100 / $CountAll, 2);
                                        $Percent3 = $CountAll == 0 ? 0 : round($CountNotConnect * 100 / $CountAll, 2);
                                        $Percent4 = $CountAll == 0 ? 0 : round($needCallOperator * 100 / $CountAll, 2);
                                    @endphp

       <table class="text-sm">
           <tr>
           <td class="p-6 text-center align-bottom">
               <div class="text-center">{{ number_format($CountAll, 0, ',', ' ') }}</div>
                <div class="mx-12 w-12 bg-blue-500" style="height:{{$CountAll * $kf}}px"></div>
                <div class="text-center mt-2">Общее&nbsp;количество<br />специалистов</div>
           </td>
           <td class="p-6 text-center align-bottom">
               {{ number_format($Сommunication5, 0, ',', ' ')  }}
                <div style="color: brown">{{$Percent1}} %</div>
                <div class="mx-4 w-12 bg-yellow-200" style="height:{{ ($Сommunication5 * $kf) }}px"></div>
                <div class="text-center mt-2">Ожидают<br />звонок</div>
           </td>
           <td class="p-6 text-center align-bottom">
               {{number_format($CountConnect, 0, ',', ' ')}}
                <div class="green2">{{  $Percent2 }} %</div>
                <div class="mx-4 w-12 bg-green-500" style="height:{{$CountConnect * $kf}}px"></div>
                <div class="text-center mt-2">Опрошен<br />успешно</div>
           </td>
           <td class="p-6 text-center align-bottom">
                {{number_format($CountNotConnect, 0, ',', ' ')}}
                <div class="red">{{ $Percent3 }} %</div>
                <div class="mx-4 w-12 bg-red-500" style="height:{{$CountNotConnect * $kf}}px"></div>
                <div class="text-center mt-2">Нет<br />ответа</div>
           </td>
           <td class="p-6 text-center align-bottom">
                {{number_format($needCallOperator, 0, ',', ' ')}}
                <div class="red">{{ $Percent4 }} %</div>
                <div class="mx-4 w-12 bg-indigo-500" style="height:{{$needCallOperator * $kf}}px"></div>
                <div class="text-center mt-2">Требуется<br />звонок оператора</div>
           </td>           
        </tr>
    </table>

</td>
</tr>
</table>

</div>
</div>


<div class="mt-2 font-bold text-center">Статистика звонков по дням</div>

                            <table class="mt-3 w-full border border-gray-200 text-gray-800 text-sm text-center">
                                <tr class="h-10">
                                    <th class="sticky bg-blue-50 px-12">Дата</th>
                                    <th class="sticky bg-blue-50 px-5">Количество изменений</th>
                                    <th class="sticky bg-blue-50 px-5">Неверный номер</th>
                                    <th class="sticky bg-blue-50 px-5">Нет ответа</th>
                                    <th class="sticky bg-blue-50 px-5">Отказались отвечать</th>
                                    <th class="sticky bg-blue-50 px-5">Опрошен</th>
                                    <th class="sticky bg-blue-50 px-5">Перезвонить позже</th>
                                    <th class="sticky bg-blue-50 px-5">Требуется звонок оператора</th>
                                </tr>
                                <tbody class="divide-y">
                                @php $i = 1; @endphp
                            @foreach ($report1 as $r)
                                @php $i++; @endphp
                                <tr class="whitespace-nowrap callstr {{ ($i % 2 == 0 ? '' : 'bg-gray-50') }}">
                                    <td class="p-1">{{ $r['date'] }}</td>
                                    <td class="p-1">{{ $r['cnt'] }}</td>
                                    <td class="p-1">{{ $r['COM0'] }}</td>
                                    <td class="p-1">{{ $r['COM1'] }}</td>
                                    <td class="p-1">{{ $r['COM2'] }}</td>
                                    <td class="p-1">{{ $r['COM3'] }}</td>
                                    <td class="p-1">{{ $r['COM4'] }}</td>
                                    <td class="p-1">{{ $r['COM6'] }}</td>
                                </tr>
                            @endforeach
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

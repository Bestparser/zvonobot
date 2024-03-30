<x-app-layout>
    <x-slot name="header">
        <div class="h-7"></div>
    </x-slot>

    <x-slot name="script">
        <script>
                $(document).ready(function(){

                });
        </script>
    </x-slot>

    <div class="py-1">

        <div class="text-center my-5">
            <a href="{{ URL::route('exportcsv') }}">
                <button type="button" class="px-2 py-1 bg-yellow-500 rounded text-white hover:bg-indigo-400">
                    Старт экспорта в Мониторинг
                </button>
            </a>
        </div>

        <div class="max-w-full mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 bg-white border-b border-gray-200">



                    <div style="height: 70vh;" class="flex flex-col">
                        <div class="flex-grow overflow-auto px-10">

                            <table class="mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
                                <tr class="h-10">
                                    <th class="sticky bg-yellow-50">ИД</th>
                                    <th class="sticky bg-yellow-50">Пользователь</th>
                                    <th class="sticky bg-yellow-50">Дата старт</th>
                                    <th class="sticky bg-yellow-50">Дата финиш</th>
                                    <th class="sticky bg-yellow-50">Статус ошибки</th>
                                    <th class="sticky bg-yellow-50">Количество строк</th>
                                    <th class="sticky bg-yellow-50">Неверный номер</th>
                                    <th class="sticky bg-yellow-50">Нет ответа</th>
                                    <th class="sticky bg-yellow-50">Отказались отвечать</th>
                                    <th class="sticky bg-yellow-50">Опрошен</th>
                                    <th class="sticky bg-yellow-50">Перезвонить позже</th>
                                    <th class="sticky bg-yellow-50">Ожидают звонок</th>
                                    <th class="sticky bg-yellow-50">Мониторинг ответил</th>
                                </tr>
                                <tbody class="divide-y">
                                    @php $r = 1; @endphp
                                @forelse ($ExportLog as $i)
                                @php
                                     $dstart = Carbon\Carbon::parse($i->CreateDateStart)->format('d.m.Y H:i:s');
                                     $dend = Carbon\Carbon::parse($i->CreateDateEnd)->format('d.m.Y H:i:s');
                                     $class_tr = $i->Error == 1 ? 'bg-red-50 ' : '';
                                @endphp
                                    <tr class="{{$class_tr}}whitespace-nowrap callstr {{ ($r % 2 == 0 ? '' : 'bg-gray-50') }}">
                                        <td class="p-1">{{ $i->EID }}</td>
                                        <td class="p-1">{{ $i->UserName }}</td>
                                        <td class="p-1">{{ $dstart }}</td>
                                        <td class="p-1">{{ $dend }}</td>
                                        <td class="p-1">{{ $i->Error }}</td>
                                        <td class="p-1">{{ $i->ExportRows }}</td>
                                        <td class="p-1">{{ $i->COM0 }}</td>
                                        <td class="p-1">{{ $i->COM1 }}</td>
                                        <td class="p-1">{{ $i->COM2 }}</td>
                                        <td class="p-1">{{ $i->COM3 }}</td>
                                        <td class="p-1">{{ $i->COM4 }}</td>
                                        <td class="p-1">{{ $i->COM5 }}</td>
                                        <td class="p-1 text-xs">{!! $i-> Details !!}</td>
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

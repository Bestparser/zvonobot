<x-app-layout>
    <x-slot name="header">
        <div class="h-7"></div>
    </x-slot>

    <x-slot name="script">
        <script>
                $(document).ready(function(){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#startimport').one('click', function(){
                        console.log('startimport');

                        $('#startimport').removeClass('bg-indigo-500');
                        $('#startimport').removeClass('hover:bg-indigo-400');

                        $('#startimport').addClass('bg-gray-300');
                        $('#startimport').addClass('hover:bg-gray-400');

                        $.ajax({
                            url: '{{ route('startimport') }}',
                            type: "GET",
                            data: {},
                            success: function (msg) {
                                $('#startimport_cont').hide();
                                $('#msg').html(msg);
                            },
                            error: function (msg) {
                                $('#startimport_cont').hide();
                                $('#msg').html(msg);
                            }
                        });
                    });
                });

                function closeModalErrorImportExcel(){
                    $('#modalErrorImportExcel').remove();                    
                }                
        </script>
    </x-slot>

    <div class="py-1">

        <pre id="msg" class="text-sm"></pre>
        <div id="startimport_cont"  class="text-center my-5">
            <form action="{{ route('importexcel') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="excelFile" />
                <select name="truncateOld" disabled="disabled">
                    <option value="0">Не стирать старое</option>
                    <option value="1">Стереть старое и записать как новое</option>
                </select>
                <button type="submit" class="px-2 py-1 bg-indigo-500 rounded text-white hover:bg-indigo-400">
                    Загрузить данные из ФИС
                </button>                
            </form>
            
            @if ($errorsExcel)
                <!--Modal-->
                    <div id="modalErrorImportExcel" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center" style="">
                        <div class="modal-overlay absolute w-full h-full bg-gray-300 opacity-50" style=""></div>
                        <div class="modal-container bg-white w-11/12 mx-auto rounded shadow-lg z-50 overflow-y-auto" style="">

                            <!-- Add margin if you want to see some of the overlay behind the modal-->
                            <div class="modal-content py-4 text-left px-6" style="">

                                <!--Body-->
                                <div id="modal_body">
                                    <div class="flex justify-between">
                                        <table>
                                            @foreach($errorsExcel as $error)                                                
                                                <tr>
                                                    <td>
                                                        {{ $error['col'] }}:{{ $error['row'] }} {{ $error['desc'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <!--Footer-->
                                <div class="flex justify-end pt-1">
                                    <button onclick="closeModalErrorImportExcel();" class="px-4 py-1 mr-10 bg-gray-100 bg-transparent rounded-lg text-indigo-500 hover:bg-gray-200 hover:text-indigo-400">Закрыть окно</button>	  
                                </div>

                            </div>
                        </div>
                    </div>
                <!-- end Modal -->
            @endif         
        </div>


        <div class="max-w-full mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 bg-white border-b border-gray-200">



                    <div style="height: 70vh;" class="flex flex-col">
                        <div class="flex-grow overflow-auto px-10">

                            <table class="mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
                                <tr class="h-10">
                                    <th class="bg-blue-50">ИД</th>
                                    <th class="bg-blue-50">Пользователь</th>
                                    <th class="bg-blue-50">Дата старт</th>
                                    <th class="bg-blue-50">Дата финиш</th>
                                    <th class="bg-blue-50">Статус ошибки</th>                                    
                                    <th class="bg-blue-50">Количество обработанных строк</th>
                                    <th class="bg-blue-50">Подробности</th>
                                </tr>
                                <tbody class="divide-y">
                                    @php $r = 1; @endphp
                                @forelse ($ImportLog as $i)
                                @php
                                     $dstart = Carbon\Carbon::parse($i->CreateDateStart)->format('d.m.Y H:i:s');
                                     $dend = Carbon\Carbon::parse($i->CreateDateEnd)->format('d.m.Y H:i:s');
                                @endphp
                                    <tr class="whitespace-nowrap callstr {{ ($r % 2 == 0 ? '' : 'bg-gray-50') }}">
                                        <td class="p-1">{{ $i-> LID }}</td>
                                        <td class="p-1">{{ $i-> UserName }}</td>
                                        <td class="p-1">{{ $dstart }}</td>
                                        <td class="p-1">{{ $dend }}</td>
                                        <td class="p-1">{{ $i-> Error }}</td>                                        
                                        <td class="p-1">{{ $i-> ImportRows }}</td>
                                        <td class="p-1">{{ $i-> Details }}</td>
                                    </tr>
                                    @php $r = $r+1;  @endphp
                                @empty
                                    <tr><td colspan="8" class="border border-blue-200 px-2 py-10 text-center text-red-500">нет данных</td></tr>
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

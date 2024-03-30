<form id="formsearch" method="GET" action="{{ route('call') }}">
    <input type="hidden" name="order" value="{{ $order }}">
    <input type="hidden" name="page" value="{{ $page }}">
        <div id="formh" class="w-full flex text-xs">
            <dt class="px-1 item" style="min-width: 600px;">

          <script>
                        $(document).ready(function(){

                                                            var config = {
                                          '.chosen-select'           : {
                                              width: '600px',
                                              no_results_text: 'Совпадений не найдено',
		                                      placeholder_text_single: 'Выберите регион',
                                              language: "ru"
                                          },
                                         /* '.chosen-select-deselect'  : { allow_single_deselect: true },
                                          '.chosen-select-no-single' : { disable_search_threshold: 10 },
                                          '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
                                          '.chosen-select-rtl'       : { rtl: true },
                                          '.chosen-select-width'     : { width: '95%' }*/
                                        }
                                        for (var selector in config) {
                                          $(selector).chosen(config[selector]);
                                        }

                                        resizeHeight();

                                        $(".chosen-select").chosen().change(function () {
                                            submitform();
                                         });

                                        });






          </script>



                @php
                    $regs = [];
                    if (request()->has('reg')) {
                        $regs = request()->get('reg');
                    }
                @endphp
                <select style="display: none;" data-placeholder="Все регионы" multiple class="chosen-select" name="reg[]" class="h-64 w-32 m-0 p-0.5 text-xs bg-transparent border-blue-800 item">
                    <option value="0">Все регионы</option>
                        @foreach ($regions as $r)
                        <?php
                            if (in_array($r->RegionID, $regs)) {
                                $reg = ' selected';
                            } else {
                                $reg = '';
                            }
                        ?>
                            <option value="{{ $r->RegionID }}"{{ $reg }}>({{ $r->RegionCode }}) {{ $r->RegionName }}</option>
                        @endforeach
                    </select>
            </dt>
            <dd class="px-1 item ">
                @php
                $search_value = '';
                    if (request()->has('search')) {
                        $search_value = request()->get('search');
                    }
                @endphp
                <input placeholder="Поиск" name="search" value="{{$search_value}}" type="text" class="text-xs h-7 w-32 m-0 p-0.5 border-blue-800 focus:outline-none hover:text-black focus:text-black  md:text-basecursor-default items text-gray-700  outline-none"></input>
            </dd>

            <dd class="px-1 item">
                @php
                    $com = -2;
                    if (request()->has('com')) {
                        $com = (int) request()->get('com');
                    }
                @endphp
            <select value="com" name="com" class="h-7 w-48 m-0 p-0.5 text-xs bg-transparent border-blue-800 item">
                <option value="-2">Все варинты связи</option>
                <!--<option value="-1"{{ $com==-1 ? ' selected':'' }}>-</option>-->
                <option class="bg-red-100" value="0"{{ $com==0 ? ' selected':'' }}>  - неверный номер</option>
                <option class="bg-red-100" value="1"{{ $com==1 ? ' selected':'' }}>  - нет ответа</option>
                <option class="bg-red-100" value="2"{{ $com==2 ? ' selected':'' }}>  - отказались отвечать</option>
                <option class="bg-green-100" value="3"{{ $com==3 ? ' selected':'' }}>  - опрошен</option>
                <option class="bg-blue-100" value="4"{{ $com==4 ? ' selected':'' }}>  - перезвонить позже (некогда говорить)</option>
                <option value="5"{{ $com==5 ? ' selected':'' }}>  - ожидают звонок</option>
                <option class="bg-yellow-100" value="99"{{ $com==99 ? ' selected':'' }}>Все кроме 'ожидают звонок'</option>
                <option class="bg-indigo-200" value="88"{{ $com==88 ? ' selected':'' }}>Все кроме 'опрошен'</option>
                <option value="6"{{ $com==6 ? ' selected':'' }}>требуется звонок оператора</option>                
            </select>
        </dd>
        <dd class="px-1 item">
            @php
            $start = '';
                if (request()->has('start')) {
                    $start = request()->get('start');
                }
            @endphp
            <input autocomplete="off" placeholder="Дата с" name="start" value="{{$start}}" type="text" class="datepicker text-xs h-7 w-32 m-0 p-0.5 border-blue-800 focus:outline-none hover:text-black focus:text-black  md:text-basecursor-default items text-gray-700  outline-none"></input>
        </dd>
        <dd class="px-1 item">
            @php
            $end = '';
                if (request()->has('end')) {
                    $end = request()->get('end');
                }
            @endphp
            <input autocomplete="off" placeholder="Дата по" name="end" value="{{$end}}" type="text" class="datepicker text-xs h-7 w-32 m-0 p-0.5 border-blue-800 focus:outline-none hover:text-black focus:text-black  md:text-basecursor-default items text-gray-700  outline-none"></input>
        </dd>

         <dd class="px-1 item">
            @php
                $user = -2;
                    if (request()->has('user')) {
                        $user = (int) request()->get('user');
                    }
            @endphp
            <select value="user" name="user" class="h-7 w-32 m-0 p-0.5 text-xs bg-transparent border-blue-800 item">
                <option value="-2">Все операторы</option>
                @foreach ($users as $u)
                <?php
                    if ($u->UserID == $user) {
                        $userselect = ' selected';
                    } else {
                        $userselect = '';
                    }
                ?>
                    <option value="{{ $u->UserID }}"{{ $userselect }}>{{ $u->UserName }}</option>
                @endforeach
            </select>
         </dd>


            <dd class="px-1 item">
                <a href="{{ route('call') }}">
                    <button type="button" class="h-7 px-1 bg-indigo-500 rounded text-white hover:bg-indigo-400">
                        <svg class="h-5 w-5 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                    </button>
                </a>
            </dd>
            <dd class="px-1 item">
                <button onclick="submitform();" type="button" class="h-7 px-2 py-1 bg-indigo-500 rounded text-white hover:bg-indigo-400">
                    Фильтровать
                </button>
            </dd>
        </div>
    </form>

<x-app-layout>
    <x-slot name="header">
        @include('layouts.call_filter')
    </x-slot>

    <x-slot name="script">

        <script>
            function sureDeleteTS(){
                if (confirm("Удалить?")) {
                    return true;
                } else {
                    return false;
                }
            }

                var $self = '';

                $(document).ready(function(){
                    //******************************************
                    var interval = setInterval(function()
                    {
                        $.ajax({
                            url: '{{ route('setonline') }}',
                            type: "GET",
                            success: function (data) {
                                $('#online').text(data);
                            },
                            error: function (data) {
                                $('#online').text(data);
                                console.log('ERR !!! setonline=' + data);
                            }
                        });
                    },120000);
                    //******************************************

                    $('input').on('focus',function(){
                        $self = $(this).attr("name");
                        //$('#result').text($self.attr('id'));

                    });

                    document.onkeydown = function(evt) {
                           evt = evt || window.event
                           /*var isEscape = false
                           if ("key" in evt) {
                         	//isEscape = (evt.key === "Escape" || evt.key === "Esc")
                           } else {
                         	isEscape = (evt.keyCode === 27)
                           }*/
                           if (evt.keyCode === 13 && $self=='search') {
                                submitform();
                           }
                           console.log('evt.keyCode=' + evt.keyCode + ' |  $self=' +  $self );
                         };


                });
        </script>

        <script src="{{ asset('chosen/chosen.jquery.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('chosen/chosen.css') }}">

        <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
        <script src="{{ asset('js/jquery-ui.js') }}"></script>

        <script>
        /* Локализация datepicker */
        $.datepicker.regional['ru'] = {
            closeText: 'Закрыть',
            prevText: 'Предыдущий',
            nextText: 'Следующий',
            currentText: 'Сегодня',
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
            dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
            dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
            dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            weekHeader: 'Не',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['ru']);
        </script>

        <script>

                var modalEdit = false;

                var MainCommunication = 'Сommunication'; // communication
                var MainIsWorkerRole = 'IsWorkerRole'; // rol
                var MainExperience = 'Experience'; // exp
                var MainAppFederal = 'AppFederal'; // appfederal
                var MainMark = 'Mark'; // mark
                var MainStudyDate = 'StudyDate'; // sty

                var MainKEGE = 'KEGE'; // keg
                var MainRegionStudy = 'RegionStudy'; // rst
                var MainAppRegion = 'AppRegion'; // appr

                $(document).ready(function(){

                    
                    $(function(){
                        $(".datepicker").datepicker();
                    });

                    var page_cnt = {{$page_cnt}};
                    var page = {{$page}};

                    for (let i = 1; i <= page_cnt; i++) { // выведет 0, затем 1, затем 2
                        if (page == i) {
                            $('#pageselect').append('<option class="bg-red-300" value="'+i+'" selected>'+i+'</option>');
                        } else {
                            $('#pageselect').append('<option value="'+i+'">'+i+'</option>');
                        }
                    }

                    $( window ).resize(function(){ //
                        resizeHeight();
                    });


                    $('select[name="reg[]"]').on('change',function(){
                            $('input[name=page]').val(1);
                            resizeHeight();
                           // $("#formsearch" ).submit();
                    });


                    $('#pageselect').on('change',function(){
                        var pag_cur = parseInt($(this).val());
                        var page_cnt = {{$page_cnt}};

                        if ((pag_cur) > 1 && pag_cur <= page_cnt ) {
                            $('input[name=page]').val((pag_cur));
                            $("#formsearch" ).submit();
                        }
                    });


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $(".callstr").dblclick(function() {
                        var uid = $(this).attr('data-id');
                        $.ajax({
                            url: '{{ route('CallEdit') }}',
                            type: "POST",
                            data: {uid:uid},
                            success: function (data) {
                                if (data.err == 0) {

                                } else {

                                }
                                $('#modal_body').html(data);
                                loadCallEdit();
                                toggleModal();
                            },
                            error: function (msg) {

                            }
                        });
                    });

                         var closemodal = document.querySelectorAll('.modal-close')
                         for (var i = 0; i < closemodal.length; i++) {
                           closemodal[i].addEventListener('click', toggleModal)
                         }

                });


                         function toggleModal () {
                            if (modalEdit===false) {
                                modalEdit = true;
                             } else {
                                modalEdit = false;
                             }

                           const body = document.querySelector('body')
                           const modal = document.querySelector('.modal')
                           modal.classList.toggle('opacity-0')
                           modal.classList.toggle('pointer-events-none')
                           body.classList.toggle('modal-active')
                         };

                         function CallSave() {
                             var uid = $('input[name=uid]').val();

                             var communication = getValue(MainCommunication);
                             var rol = getValue(MainIsWorkerRole);
                             var exp = getValue(MainExperience);
                             var mark = getValue(MainMark);
                             var sty = getValue(MainStudyDate);
                             var keg = getValue(MainKEGE);
                             var rst = getValue(MainRegionStudy);
                             var appr = getValue(MainAppRegion);
                             var appfederal = getValue(MainAppFederal);

      
                             if ( proverkaSave()) {
                                $.ajax({
                                    url: '{{ route('CallSave') }}',
                                    type: "POST",
                                    data: { uid:uid,
                                            communication:communication,
                                            rol:rol,
                                            exp:exp,
                                            sty:sty,
                                            keg:keg,
                                            rst:rst,
                                            appr:appr,
                                            mark:mark,
                                            appfederal:appfederal,
                                            },
                                    success: function (data) {
                                        if (data.err == 0) {                                            
                                            $('#tr'+uid).html(data.msg);
                                            toggleModal();
                                        } else {                                            
                                            $('#errsave').text(data.msg);                                            
                                        }
                                    },
                                    error: function (msg) {                                        
                                        $('#errsave').text(msg);                                        
                                    }
                                });
                            }
                         };

                        function proverkaSave() {
                            $('#errsave').text('');
                            onchange_communication();
                            onchange_rol();
                            var rezult = true;
                            var errsave = '';

                             var communication = getValue(MainCommunication);
                             var rol = getValue(MainIsWorkerRole);
                             var exp = getValue(MainExperience);
                             var mark = getValue(MainMark);
                             var sty = getValue(MainStudyDate);
                             var keg = getValue(MainKEGE);
                             var rst = getValue(MainRegionStudy);
                             var appr = getValue(MainAppRegion);
                             var appfederal = getValue(MainAppFederal);
                            
                            if (communication == -1) {
                                    $('#'+MainCommunication).removeClass('border-blue-800');
                                    $('#'+MainCommunication).addClass('border-red-800');
                                    errsave += '| Сommunication';
                                    rezult = false;
                            } else {
                                    $('#'+MainCommunication).removeClass('border-red-800');
                                    $('#'+MainCommunication).addClass('border-blue-800');
                            }

                            if (communication == 3) {
                                if (rol == -1) {
                                    $('#' + MainIsWorkerRole).removeClass('border-blue-800');
                                    $('#' + MainIsWorkerRole).addClass('border-red-800');
                                    errsave += '| IsWorkerRole';
                                    rezult = false;
                                } else {
                                    $('#' + MainIsWorkerRole).removeClass('border-red-800');
                                    $('#' + MainIsWorkerRole).addClass('border-blue-800');
                                }
                            }

                            if (rol == 1 || rol == 2) {
                                if (exp == -1) {
                                    $('#' + MainExperience).removeClass('border-blue-800');
                                    $('#' + MainExperience).addClass('border-red-800');
                                    errsave += ' exp';
                                    rezult = false;
                                } else {
                                    $('#' + MainExperience).removeClass('border-red-800');
                                    $('#' + MainExperience).addClass('border-blue-800');
                                }
                                if (sty == -1) {
                                    $('#' + MainStudyDate).removeClass('border-blue-800');
                                    $('#' + MainStudyDate).addClass('border-red-800');
                                    errsave += ' Experience';
                                    rezult = false;
                                } else {
                                    $('#' + MainStudyDate).removeClass('border-red-800');
                                    $('#' + MainStudyDate).addClass('border-blue-800');
                                }
                                if (keg == -1) {
                                    $('#' + MainKEGE).removeClass('border-blue-800');
                                    $('#' + MainKEGE).addClass('border-red-800');
                                    errsave += ' KEGE';
                                    rezult = false;
                                } else {
                                    $('#' + MainKEGE).removeClass('border-red-800');
                                    $('#' + MainKEGE).addClass('border-blue-800');
                                }
                                if (rst == -1) {
                                    $('#' + MainRegionStudy).removeClass('border-blue-800');
                                    $('#' + MainRegionStudy).addClass('border-red-800');
                                    errsave += ' RegionStudy';
                                    rezult = false;
                                } else {
                                    $('#' + MainRegionStudy).removeClass('border-red-800');
                                    $('#' + MainRegionStudy).addClass('border-blue-800');
                                }
                                if (appr == -1) {
                                    $('#' + MainAppRegion).removeClass('border-blue-800');
                                    $('#' + MainAppRegion).addClass('border-red-800');
                                    errsave += ' AppRegion';
                                    rezult = false;
                                } else {
                                    $('#' + MainAppRegion).removeClass('border-red-800');
                                    $('#' + MainAppRegion).addClass('border-blue-800');
                                }
                                if (mark == -1) {
                                    $('#' + MainMark).removeClass('border-blue-800');
                                    $('#' + MainMark).addClass('border-red-800');
                                    errsave += ' Mark';
                                    rezult = false;
                                } else {
                                    $('#' + MainMark).removeClass('border-red-800');
                                    $('#' + MainMark).addClass('border-blue-800');
                                }
                                if (appfederal == -1) {                                    
                                    $('#' + MainAppFederal).removeClass('border-blue-800');
                                    $('#' + MainAppFederal).addClass('border-red-800');                                    
                                    errsave += ' appfederal';
                                    rezult = false;
                                } else {
                                    $('#' + MainAppFederal).removeClass('border-red-800');
                                    $('#' + MainAppFederal).addClass('border-blue-800');                                    
                                }



                            }
                            if (!rezult) $('#errsave').text(errsave);
                            return rezult;
                        };

                         function loadCallEdit() {
                            onchange_communication();
                            onchange_rol();
                         };

                         function noRed() {
                            onchange_communication();
                            onchange_rol();
                         };

                         function resizeHeight() {
                            var form_height = $('#formh').height();
                            var height = $( window ).height();
                            $('#call_work').height(height - form_height - 120);
                         };

                        function onchange_communication() {                            
                            var communication = getValue(MainCommunication);

                            if (communication ==3) {                                                              
                                select_enabled('' + MainIsWorkerRole + '');
                                select_enabled('' + MainExperience + '');
                                select_enabled('' + MainAppFederal + '');
                                select_enabled('' + MainKEGE + '');
                                select_enabled('' + MainStudyDate + '');
                                select_enabled('' + MainRegionStudy + '');
                                select_enabled('' + MainAppRegion + '');
                                select_enabled('' + MainMark + '');
                                select_enabled_checkbox();
                            } else {
                                select_disabled('' + MainIsWorkerRole + '');
                                select_disabled('' + MainExperience + '');
                                select_disabled('' + MainAppFederal + '');                                
                                select_disabled('' + MainKEGE + '');
                                select_disabled('' + MainStudyDate + '');
                                select_disabled('' + MainRegionStudy + '');
                                select_disabled('' + MainAppRegion + '');
                                select_disabled('' + MainMark + '');
                                select_disabled_checkbox();
                            }

                            onchange_rol();
                        };

                        function onchange_rol() {
                            var rol = getValue(MainIsWorkerRole);

                            if (rol ==1 ||  rol ==2) {
                                select_enabled('' + MainExperience + '');
                                select_enabled('' + MainAppFederal + '');
                                select_enabled('' + MainKEGE + '');
                                select_enabled('' + MainStudyDate + '');
                                select_enabled('' + MainRegionStudy + '');
                                select_enabled('' + MainAppRegion + '');
                                select_enabled('' + MainMark + '');
                                select_enabled_checkbox();
                            } else {
                                select_disabled('' + MainExperience + '');
                                select_disabled('' + MainAppFederal + '');
                                select_disabled('' + MainKEGE + '');
                                select_disabled('' + MainStudyDate + '');
                                select_disabled('' + MainRegionStudy + '');
                                select_disabled('' + MainAppRegion + '');
                                select_disabled('' + MainMark + '');
                                select_disabled_checkbox();
                            }
                        };

                        function select_disabled(name) {
                            $('#'+name).prop('disabled', true);
                        };

                        function select_enabled(name) {
                            $('#'+name).prop('disabled', false);
                        };

                        function select_disabled_checkbox() {                            
                            $('.questionBlock input[type="checkbox"]').each(function( index ) {		
                                $(this).prop('disabled', true);
                            });
                        };

                        function select_enabled_checkbox() {
                            $('.questionBlock input[type="checkbox"]').each(function( index ) {		
                                $(this).prop('disabled', false);
                            });
                        };

                        // Считывает GET переменные из URL страницы и возвращает их как ассоциативный массив.
                        function getUrlVars()
                        {
                            var vars = [], hash;
                            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                            for(var i = 0; i < hashes.length; i++)
                            {
                                hash = hashes[i].split('=');
                                vars.push(hash[0]);
                                vars[hash[0]] = hash[1];
                            }
                            return vars;
                        };

                        function orderFIO() {
                            if ($('input[name=order]').val()==1) {
                                $('input[name=order]').val('2');
                            } else {
                                $('input[name=order]').val('1');
                            }
                            $( "#formsearch" ).submit();
                        };

                        function orderRegion() {
                            if ($('input[name=order]').val()==3) {
                                $('input[name=order]').val('4');
                            } else {
                                $('input[name=order]').val('3');
                            }
                            $( "#formsearch" ).submit();
                        };

                        function orderDate() {
                            if ($('input[name=order]').val()==5) {
                                $('input[name=order]').val('6');
                            } else {
                                $('input[name=order]').val('5');
                            }
                            $( "#formsearch" ).submit();
                        };

                        function pagepref() {
                            var pag_cur = parseInt($('input[name=page]').val());
                            var page_cnt = {{$page_cnt}};

                            if (pag_cur > 1 && (pag_cur-1) <= page_cnt) {
                                $('input[name=page]').val((pag_cur-1));
                                $("#formsearch" ).submit();
                            }

                        };

                        function pagenext() {
                            var pag_cur = parseInt($('input[name=page]').val());
                            var page_cnt = {{$page_cnt}};

                            if ((pag_cur+1) >= 1 && (pag_cur+1) <= page_cnt ) {
                                $('input[name=page]').val((pag_cur+1));
                                $("#formsearch" ).submit();
                            }
                        };

                        function submitform() {
                            $('input[name=page]').val(1);
                            $("#formsearch" ).submit();
                        };

                        function buttoncopy() {
                           var value = $('#phonecopy').text().trim();
                           var $temp = $("<input>");
                           console.log(value);
                            $("body").append($temp);
                            $temp.val(value).select();
                            document.execCommand("copy");
                            $temp.remove();

                            $('#buttoncopy').html('<span class="text-gray-200">copy...</span>');

                            window.setTimeout(
                                function() {
                                    $('#buttoncopy').html('<button onclick="buttoncopy();" type="button" class="h-6 px-1 bg-indigo-300 rounded text-white hover:bg-indigo-200"><svg class="h-4 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="8" y="8" width="12" height="12" rx="2" />  <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg></button>');
	                            } , 3000 );
                        };

                        function getValue($id){
                            $value = '';
                            if (($('#' + $id).attr('data-id') == 'select') || ($('#' + $id).attr('data-id') == 'varchar')) $value = $('#' + $id).val();
                            if (($('#' + $id).attr('data-id') == 'check') || ($('#' + $id).attr('data-id') == 'radio')) {
                                $('#parent_' + $id + ' input').each(function( index ) {
                                    if ($(this).is(':checked')){
                                        $value = $value + $(this).val().toString();
                                    }
                                });
                            }
                            if ($('#' + $id).attr('data-id') == 'text') $value = $('#' + $id).html();
                            return $value;
                        }

        </script>
    </x-slot>

    <div class="py-1">
        <div class="max-w-full mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 bg-white border-b border-gray-200">

                    <div id="call_work" style="height: 85vh;" class="flex flex-col">
                        <div class="flex-grow overflow-auto">
                            @include('layouts.call_table')
                        </div>
                    </div>

                    @include('layouts.call_modal')

                    </div>
                </div>

                @include('layouts.call_footer')

        </div>
    </div>
</x-app-layout>

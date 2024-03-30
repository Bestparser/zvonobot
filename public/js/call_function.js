  function toggleModal () {
                           const body = document.querySelector('body')
                           const modal = document.querySelector('.modal')
                           modal.classList.toggle('opacity-0')
                           modal.classList.toggle('pointer-events-none')
                           body.classList.toggle('modal-active')
                         };

                         function CallSave() {
                             var cid = $('input[name=cid]').val();
                             var communication = $('select[name=communication]').val();
                             var rol = $('select[name=rol]').val();
                             var exp = $('select[name=exp]').val();
                             var sty = $('select[name=sty]').val();
                             var keg = $('select[name=keg]').val();
                             var rst = $('select[name=rst]').val();
                             var appr = $('select[name=appr]').val();
                             var mark = $('select[name=mark]').val();
                             var che0 = $('input[name=che0]').is(':checked') ? '0' : '';
                             var che1 = $('input[name=che1]').is(':checked') ? '1' : '';
                             var che2 = $('input[name=che2]').is(':checked') ? '2' : '';
                             var che3 = $('input[name=che3]').is(':checked') ? '3' : '';
                             var che4 = $('input[name=che4]').is(':checked') ? '4' : '';
                             var appfederal = '' + che0 + che1 + che2 + che3 + che4;

                             console.log('CallSave cid=' + cid);

                             if ( proverkaSave()) {
                                $.ajax({
                                    url: '{{ route('CallSave') }}',
                                    type: "POST",
                                    data: { cid:cid,
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
                                            $('#tr'+cid).html(data.msg);
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
                            var communication = $('select[name="communication"]').val();
                            var rol = $('select[name=rol]').val();
                            var exp = $('select[name=exp]').val();
                            var sty = $('select[name=sty]').val();
                            var keg = $('select[name=keg]').val();
                            var rst = $('select[name=rst]').val();
                            var appr = $('select[name=appr]').val();
                            var mark = $('select[name=mark]').val();
                            var che0 = $('input[name=che0]').is(':checked') ? '0' : '';                            
                            var che1 = $('input[name=che1]').is(':checked') ? '1' : '';
                            var che2 = $('input[name=che2]').is(':checked') ? '2' : '';
                            var che3 = $('input[name=che3]').is(':checked') ? '3' : '';
                            var che4 = $('input[name=che4]').is(':checked') ? '4' : '';
                            var appfederal = '##' + che0 + che1 + che2 + che3 + che4;

                            if (communication == -1) {
                                    $('select[name=communication]').removeClass('border-blue-800');
                                    $('select[name=communication]').addClass('border-red-800');
                                    errsave += '| Сommunication';
                                    rezult = false;
                            } else {
                                    $('select[name=communication]').removeClass('border-red-800');
                                    $('select[name=communication]').addClass('border-blue-800');
                            }

                            if (communication == 3) {
                                if (rol == -1) {
                                    $('select[name=rol]').removeClass('border-blue-800');
                                    $('select[name=rol]').addClass('border-red-800');
                                    errsave += '| IsWorkerRole';
                                    rezult = false;
                                } else {
                                    $('select[name=rol]').removeClass('border-red-800');
                                    $('select[name=rol]').addClass('border-blue-800');
                                }
                            }

                            if (rol == 1 || rol == 2) {
                                if (exp == -1) {
                                    $('select[name=exp]').removeClass('border-blue-800');
                                    $('select[name=exp]').addClass('border-red-800');
                                    errsave += ' exp';
                                    rezult = false;
                                } else {
                                    $('select[name=exp]').removeClass('border-red-800');
                                    $('select[name=exp]').addClass('border-blue-800');
                                }
                                if (sty == -1) {
                                    $('select[name=sty]').removeClass('border-blue-800');
                                    $('select[name=sty]').addClass('border-red-800');
                                    errsave += ' Experience';
                                    rezult = false;
                                } else {
                                    $('select[name=sty]').removeClass('border-red-800');
                                    $('select[name=sty]').addClass('border-blue-800');
                                }
                                if (keg == -1) {
                                    $('select[name=keg]').removeClass('border-blue-800');
                                    $('select[name=keg]').addClass('border-red-800');
                                    errsave += ' KEGE';
                                    rezult = false;
                                } else {
                                    $('select[name=keg]').removeClass('border-red-800');
                                    $('select[name=keg]').addClass('border-blue-800');
                                }
                                if (rst == -1) {
                                    $('select[name=rst]').removeClass('border-blue-800');
                                    $('select[name=rst]').addClass('border-red-800');
                                    errsave += ' RegionStudy';
                                    rezult = false;
                                } else {
                                    $('select[name=rst]').removeClass('border-red-800');
                                    $('select[name=rst]').addClass('border-blue-800');
                                }
                                if (appr == -1) {
                                    $('select[name=appr]').removeClass('border-blue-800');
                                    $('select[name=appr]').addClass('border-red-800');
                                    errsave += ' AppRegion';
                                    rezult = false;
                                } else {
                                    $('select[name=appr]').removeClass('border-red-800');
                                    $('select[name=appr]').addClass('border-blue-800');
                                }
                                if (mark == -1) {
                                    $('select[name=mark]').removeClass('border-blue-800');
                                    $('select[name=mark]').addClass('border-red-800');
                                    errsave += ' Mark';
                                    rezult = false;
                                } else {
                                    $('select[name=mark]').removeClass('border-red-800');
                                    $('select[name=mark]').addClass('border-blue-800');
                                }
                                if (appfederal == '##') {
                                    $('#checkboxerr').addClass('bg-red-200');
                                    errsave += ' AppFederal';
                                    rezult = false;
                                } else {
                                    $('#checkboxerr').removeClass('bg-red-200');
                                }
                            }
                            if (!rezult) $('#errsave').text(errsave);
                            return rezult;
                        };

                         function loadCallEdit() {
                            console.log('loadCallEdit');
                            onchange_communication();
                            onchange_rol();
                         };

                         function noRed() {
                            console.log('loadCallEdit');
                            onchange_communication();
                            onchange_rol();
                         };

                         function resizeHeight() {
                            var height = $( window ).height();
                            $('#call_work').height(height - 150);
                            console.log(height + ' ======= ' + $('#call_work').height());
                         };

                        function onchange_communication() {
                            var communication = $('select[name="communication"]').val();

                            if (communication ==3) {
                                select_enabled('rol');
                                select_enabled('exp');
                                select_enabled('keg');
                                select_enabled('sty');
                                select_enabled('rst');
                                select_enabled('appr');
                                select_enabled('mark');
                                select_enabled_checkbox();
                            } else {
                                select_disabled('rol');
                                select_disabled('exp');
                                select_disabled('keg');
                                select_disabled('sty');
                                select_disabled('rst');
                                select_disabled('appr');
                                select_disabled('mark');
                                select_disabled_checkbox();
                            }

                            onchange_rol();
                        };

                        function onchange_rol() {
                            var rol = $('select[name="rol"]').val();

                            if (rol ==1 ||  rol ==2) {
                                select_enabled('exp');
                                select_enabled('keg');
                                select_enabled('sty');
                                select_enabled('rst');
                                select_enabled('appr');
                                select_enabled('mark');
                                select_enabled_checkbox();
                            } else {
                                select_disabled('exp');
                                select_disabled('keg');
                                select_disabled('sty');
                                select_disabled('rst');
                                select_disabled('appr');
                                select_disabled('mark');
                                select_disabled_checkbox();
                            }
                        };

                        function select_disabled(name) {
                            $('select[name="'+name+'"] option[value="-1"]').attr("selected", "selected");
                            $('select[name="'+name+'"]').prop('disabled', true);
                            $('select[name="'+name+'"] option:first').remove();
                            $('select[name="'+name+'"]').prepend('<option value="-1" selected>-</option>');
                        };

                        function select_enabled(name) {
                            $('select[name="'+name+'"]').prop('disabled', false);
                           // $('select[name="'+name+'"] option:first').remove();
                           // $('select[name="'+name+'"]').prepend('<option value="-1" selected>-</option>');
                           // $('select[name="'+name+'"] option[value="-1"]').attr("selected", "selected");
                        };

                        function select_disabled_checkbox() {
                            $('input[name=che1]').prop('checked', false);
                            $('input[name=che2]').prop('checked', false);
                            $('input[name=che3]').prop('checked', false);
                            $('input[name=che4]').prop('checked', false);
                            $('input[name=che0]').prop('checked', false);
                            $('input[name=che1]').prop('disabled', true);
                            $('input[name=che2]').prop('disabled', true);
                            $('input[name=che3]').prop('disabled', true);
                            $('input[name=che4]').prop('disabled', true);
                            $('input[name=che0]').prop('disabled', true);
                        };

                        function select_enabled_checkbox() {
                            $('input[name=che1]').prop('disabled', false);
                            $('input[name=che2]').prop('disabled', false);
                            $('input[name=che3]').prop('disabled', false);
                            $('input[name=che4]').prop('disabled', false);
                            $('input[name=che0]').prop('disabled', false);
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
                            //console.log(getUrlVars()['com']);
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

                        function pagepref() {
                            var pag_cur = parseInt($('input[name=page]').val());
                            var page_cnt = {{$page_cnt}};

                            if (pag_cur > 1 && (pag_cur-1) <= page_cnt) {
                                console.log('pagepref');
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

$(document).ready(function(){

                    resizeHeight();

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

                    $('select[name="reg"]').on('change',function(){
                            /*var reg = $(this).val();
                            var url = '{{ route('call') }}' + '?reg=' + reg;
                            $(location).attr('href', url);*/
                            $("#formsearch" ).submit();
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
                        console.log($(this).attr('data-id'));
                        var cid = $(this).attr('data-id');
                        $.ajax({
                            url: '{{ route('CallEdit') }}',
                            type: "POST",
                            data: {cid:cid},
                            success: function (data) {
                                if (data.err == 0) {

                                } else {

                                }
                                $('#modal_body').html(data);
                                loadCallEdit();
                                toggleModal();
                                //console.log(data);

                            },
                            error: function (msg) {

                            }
                        });
                    });

                         var closemodal = document.querySelectorAll('.modal-close')
                         for (var i = 0; i < closemodal.length; i++) {
                           closemodal[i].addEventListener('click', toggleModal)
                         }

                         document.onkeydown = function(evt) {
                           evt = evt || window.event
                           var isEscape = false
                           if ("key" in evt) {
                         	isEscape = (evt.key === "Escape" || evt.key === "Esc")
                           } else {
                         	isEscape = (evt.keyCode === 27)
                           }
                           if (isEscape && document.body.classList.contains('modal-active')) {
                         	toggleModal()
                           }
                         };

                });
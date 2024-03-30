        /* функция добавления ведущих нулей */
        /* (если число меньше десяти, перед числом добавляем ноль) */
        function zero_first_format(value)
        {
            if (value < 10)
            {
                value='0'+ value;
            }
            return value;
        }

        /* функция получения текущей даты и времени */
        function date_time()
        {
            var current_datetime = new Date();
            var day = zero_first_format(current_datetime.getDate());
            var month = zero_first_format(current_datetime.getMonth()+1);
            var year = current_datetime.getFullYear();
            var hours = zero_first_format(current_datetime.getHours());
            var minutes = zero_first_format(current_datetime.getMinutes());
            var seconds = zero_first_format(current_datetime.getSeconds());

            return day+"."+month+"."+year+" "+hours+":"+minutes+":"+seconds;
        }

        cnt = 0;

        function toggleModal () {
             const body = document.querySelector('body')
             const modal = document.querySelector('.modal')
             modal.classList.toggle('opacity-0')
             modal.classList.toggle('pointer-events-none')
             body.classList.toggle('modal-active')
        }

        function printPDF(urlpdf, cid, pp, kim){

          $('#kim').text(kim);

          $('#printNo').one('click', {cid:cid, pp:pp}, function(event){
            printNo(cid,pp);
          });
          $('#printYes').one('click', {cid:cid, pp:pp}, function(event){
            printYes(cid,pp);
          });

          $('#cmodal').hide();
          toggleModal();

            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              var aeid = $("input[name='aeid']").val();

           $.ajax({
                url: '{{ route('printpdf_check') }}',
                type: "POST",
                data: {cid:cid, aeid:aeid},
                success: function (data) {
                  console.log(data);

                  if (data.err == 0) {
                      printJS({
                      	type: 'pdf',
                      	showModal: true,
                        modalMessage: 'Загрузка PDF',
                      	printable: urlpdf,
                        onPrintDialogClose: onPrintDialogClose(cid),
                        onLoadingEnd: onLoadingEnd(cid)
                      });
                  } else {
                    $('#printdate' + pp).addClass('text-red-700 font-bold');
                    $('#printdate' + pp).text(data.err_msg);
                  }

                },
                error: function (msg) {
                  $('#printdate' + pp).addClass('text-red-700 font-bold');
                  $('#printdate' + pp).text('ошибка');
                  console.log(msg);
                }
              });

        };

        function onLoadingEnd(cid){
          $('#cmodal').show();
        };

        function onPrintDialogClose(cid){

        };

        function printYes(cid,pp){
          toggleModal();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

        var aeid = $("input[name='aeid']").val();

          $.ajax({
            url: '{{ route('printYes') }}',
            type: "POST",
            data: {cid:cid, aeid:aeid},
            success: function (data) {
              $('#printdate' + pp).text(date_time());
              if (data.rid != 2) {
                $('#pbutton' + pp).hide();
              } else {
                $('#pbutton_text' + pp).text('Перепечатать');
                $('#pbutton' + pp).removeClass('bg-blue-500');
                $('#pbutton' + pp).addClass('bg-blue-800');
              }
              console.log(data);
            },
            error: function (msg) {
              console.log(msg);
            }
          });

        };

        function printNo(cid){
          console.log('printNo');
          toggleModal();
        };
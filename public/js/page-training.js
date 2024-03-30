console.log('##########0000');


    /* функция добавления ведущих нулей */
    /* (если число меньше десяти, перед числом добавляем ноль) */
    function zero_first_format(value)
    {
        if (value < 10)
        {
            value='0'+value;
        }
        return value;
    };

console.log('##########1');

    /* функция получения текущей даты и времени */
    function date_time(f)
    {
        var current_datetime = new Date();
        var day = zero_first_format(current_datetime.getDate());
        var month = zero_first_format(current_datetime.getMonth()+1);
        var year = current_datetime.getFullYear();
        var hours = zero_first_format(current_datetime.getHours());
        var minutes = zero_first_format(current_datetime.getMinutes());
        var seconds = zero_first_format(current_datetime.getSeconds());
          if (f==1) {
              return year+"-"+month+"-"+day+"T"+hours+":"+minutes+":"+seconds;
          } else {
              return day+"."+month+"."+year+" "+hours+":"+minutes+":"+seconds;
          }
    };

    /* выводим текущую дату и время на сайт в блок с id "current_date_time_block" */
    document.getElementById('current_date_time_block').innerHTML = '' + date_time(0);
    document.getElementById('sdate').value = '' + date_time(1);

    cnt = 0;

  function toggleModal () {
       const body = document.querySelector('body')
       const modal = document.querySelector('.modal')
       modal.classList.toggle('opacity-0')
       modal.classList.toggle('pointer-events-none')
       body.classList.toggle('modal-active')
  };

  function printPDF() {
    toggleModal();
    printJS({
    	type: 'pdf',
    	showModal: false,
      modalMessage: 'Загрузка PDF',
    	printable: '{{ route('printtestpdf') }}',
      onLoadingEnd: onLoadingEnd()
    });
  };

  function onLoadingEnd(){
      setTimeout(function(){toggleModal();}, 5000);
  };


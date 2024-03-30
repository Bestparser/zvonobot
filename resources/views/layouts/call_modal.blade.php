<!--Modal-->
<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
<div class="modal-overlay absolute w-full h-full bg-gray-300 opacity-50"></div>

<div class="modal-container bg-white w-11/12 mx-auto rounded shadow-lg z-50 overflow-y-auto">

  <!-- <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
	<svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
	  <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
	</svg>
	<span class="text-sm">(Esc)</span>
  </div> -->

  <!-- Add margin if you want to see some of the overlay behind the modal-->
  <div class="modal-content py-4 text-left px-6">

	<!--Body-->
	<div id="modal_body"></div>

	<!--Footer-->
	<div class="flex justify-end pt-1">
	  <button onclick="toggleModal()" class="px-4 py-1 mr-10 bg-gray-100 bg-transparent rounded-lg text-indigo-500 hover:bg-gray-200 hover:text-indigo-400">Отмена</button>
	  <button onclick="CallSave();" class="px-4 py-1 bg-indigo-500 rounded-lg text-white hover:bg-indigo-400">Сохранить</button>
	</div>

  </div>
</div>
</div>

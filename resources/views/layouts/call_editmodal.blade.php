
<div class="flex justify-between">
	<div class="item w-1/4 pr-6">
        <input type="hidden" name="uid" value="{{ $i->UID }}">
        <table class="w-full bg-white text-gray-800 text-xs border border-gray-200">
            <tbody>
                <tr class="border border-gray-200 bg-gray-50">
                    <td class="pl-1">ФИО:</td>
                    <td class="px-3 text-base">{{ $i->Worker}}</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="pl-1">Телефон:</td>
                    <td class="px-3 text-base items-baseline"><span id="phonecopy" class="">{{ $i->PhoneNumber }}<span>
                        <span id="buttoncopy">
                            <button title="Скопировать в буфер обмена" onclick="buttoncopy('{{ $i->PhoneNumber }}');" type="button" class="h-6 px-1 bg-indigo-300 rounded text-white hover:bg-indigo-200">
                            <svg class="h-4 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="8" y="8" width="12" height="12" rx="2" />  <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                        </button>
                        <span>
                    </td>
                </tr>
                <tr class="border border-gray-200 bg-gray-50">
                    <td class="pl-1">Регион:</td>
                    <td class="px-3 text-base">({{ $i->RegionID}}) {{ $i->RegionName}}</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="pl-1">Должность:</td>
                    <td class="px-3 text-base">{{ $i->PositionName}}</td>

                </tr>
                <!--<tr class="border border-gray-200 bg-gray-50">
                    <td class="pl-1">ППЭ:</td>
                    <td class="px-3 text-base">{{ $i->StationCode}}</td>
                </tr>-->
                <tr class="border border-gray-200">
                    <td class="pl-1">UID:</td>
                    <td class="px-3">{{ $i->UID }}</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="pl-1">Email:</td>
                    <td class="px-3">{{ $i->Email}}</td>
                </tr>  
                <tr class="border border-gray-200">
                    <td class="pl-1">Код ОО:</td>
                    <td class="px-3">{{ $i->OrgID}}</td>
                </tr> 
                <tr class="border border-gray-200">
                    <td class="pl-1">ОО:</td>
                    <td class="px-3">{{ $i->OrgName}}</td>
                </tr>                                                
            </tbody>
        </table>

        <table class="w-full mt-10 bg-white text-gray-300 text-xs border border-gray-200">
            <tbody>
                <tr class="border border-gray-200 bg-gray-50">
                    <td class="pl-1">Оператор:</td>
                    <td class="px-3 text-base">{{ $i-> UserName }}</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="pl-1">Дата:</td>
                    <td class="px-3 text-base">{{ $i-> CreateDate }}</td>
                </tr>
            </tbody>
        </table>
        <div id="errsave" class="mt-4 text-red-500 test-sm"></div>
    </div>
	<div class="item w-3/4">
        <div class="questionBlock">
            @include('layouts.ankets.edit')
        </div>
    </div>
    <!--<div class="item">
        <div onclick="toggleModal();" class="modal-close cursor-pointer z-50">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
              <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
          </div>
    </div>-->
</div>



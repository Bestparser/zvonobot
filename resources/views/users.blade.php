<x-app-layout>
    <x-slot name="header">
        <div class="h-7">
            <div class="font-normal addUserButton">
                <div class="mr-2">
                    <a href="{{ route('users') }}?action=addUser" class=" button-with-icon hover:bg-green-700 bg-green-600 rounded text-white px-3 py-2 pr-5 hover:drop-shadow-md flex items-center uppercase text-sm">
                        <svg fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="24px" height="24px"><path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 11 7 L 11 11 L 7 11 L 7 13 L 11 13 L 11 17 L 13 17 L 13 13 L 17 13 L 17 11 L 13 11 L 13 7 L 11 7 z"/></svg>
                        Создать
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="script">
        <script>
                $(document).ready(function(){
                    //******************************************
                    var interval = setInterval(function()
                    {
                        $.ajax({
                            url: '{{ route('setonline') }}',
                            type: "GET",
                            success: function (data) {
                                $('#online').text(data);
                                console.log('setonline=' + data);
                            },
                            error: function (data) {
                                $('#online').text(data);
                                console.log('ERR !!! setonline=' + data);
                            }
                        });
                    },10000);
                    //******************************************
                });
        </script>
    </x-slot>

    <div class="py-1">

        <div class="max-w-full mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 bg-white border-b border-gray-200">

                    <div style="height: 80vh;" class="flex flex-col">
                        <div class="flex-grow overflow-auto px-10">                            
                            @if ($UserID > 0)
                                @include('users.useredit')
                            @elseif ($action == 'addUser')
                                @include('users.useradd')
                            @else
                                <table class="usersTable mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
                                    <thead>
                                        <tr class="h-10">
                                            <th class="sticky top-0 bg-blue-50">ИД</th>
                                            <th class="sticky top-0 bg-blue-50">Логин</th>
                                            <th class="sticky top-0 bg-blue-50">Пароль</th>
                                            <th class="sticky top-0 bg-blue-50">Имя пользователя</th>
                                            <th class="sticky top-0 bg-blue-50">OnLine</th>
                                            <th class="sticky top-0 bg-blue-50">Дата OnLine</th>
                                            <th class="sticky top-0 bg-blue-50">Группа</th>
                                            <th class="sticky top-0 bg-blue-50">Примечание</th>
                                            <th class="sticky top-0 bg-blue-50">
                                                Управление
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        @php $r = 1; @endphp
                                        @forelse ($users as $u)
                                        @php
                                        if ($u-> OnLineDate==null) {
                                            $dt = '-';
                                        } else {
                                            $dt = Carbon\Carbon::parse($u->OnLineDate)->format('d.m.Y H:i:s');
                                        }
                                        @endphp
                                        <tr class="whitespace-nowrap callstr {{ ($r % 2 == 0 ? '' : 'bg-gray-50') }}">
                                            <td class="p-1">{{ $u-> UserID }}</td>
                                            <td class="p-1">{{ $u-> login }}</td>
                                            <td class="p-1">{{ $u-> password }}</td>
                                            <td class="p-1">{{ $u-> UserName }}</td>
                                            <td class="p-1">                                                
                                                @if  ($u-> OnLineDate > Carbon\Carbon::now()->subMinute(10) && $u->Offline == 0)
                                                <svg class="m-auto h-6 w-6 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <path d="M9 12l2 2l4 -4" /></svg>
                                                @endif
                                            </td>
                                            <td class="p-1">{{ $dt }}</td>
                                            <td class="p-1">{{ $u-> RoleName }}</td>
                                            <td class="p-1">{{ $u-> UserDetails }}</td>
                                            <td class="p-1">                                                
                                                <div class="flex flex-col space-y-2 flex-nowrap justify-center items-center">
                                                    <a href="users?UserID={{ $u->UserID }}" class="editUserButton padding-button inline-flex cursor-pointer justify-center items-center whitespace-nowrap focus:outline-none transition-colors focus:duration-150 border rounded ring-blue-700 p-2 hover:bg-gray-50 bg-white text-black border-gray-300 last:mr-0" type="button">
                                                        <span class="inline-flex justify-center items-center w-6">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" class="fill-white w-5 h-5"><path d="M4.479 15.646H5.5l7.562-7.563-1.02-1.041-7.563 7.562ZM15.708 7.25l-2.812-2.854.875-.875q.396-.396.906-.396.511 0 .885.396l1.042 1.041q.375.355.354.907-.02.552-.375.906Zm-.854.833-8.812 8.813H3.229v-2.813l8.813-8.812Zm-2.292-.521-.52-.52 1.02 1.041Z"></path></svg>        
                                                        </span>
                                                        <span class="padding-0">Изменить</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $r = $r+1;  @endphp
                                        @empty
                                            <tr><td colspan="8" class="border border-blue-200 px-2 py-10 text-center text-red-500">нет данных</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>

                </div>
            </div>


            <div class="m-2 w-full text-xs text-center">
                {{ config('app.name') }}, {{ config('app.ver') }} U{{ Auth::user()->UserID }} <span id="online"></span>
            </div>


        </div>
    </div>
</x-app-layout>

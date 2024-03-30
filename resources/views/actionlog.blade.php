<x-app-layout>
    <x-slot name="header">
        <div class="h-7">
            <div class="font-normal addUserButton">
                <div class="mr-2">

                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="script">
        <script>
                $(document).ready(function(){
 
                });
        </script>
    </x-slot>

    <div class="py-1">

        <div class="max-w-full mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 bg-white border-b border-gray-200">
                    <div style="height: 80vh;" class="flex flex-col">
                        <div class="flex-grow overflow-auto px-10">
                            

                            <table class="mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
                                <tr class="h-10">
                                    <th class="bg-blue-50">Дата удаления</th>
                                    <th class="bg-blue-50">Кто удалил</th>
                                    <th class="bg-blue-50">Кого удалил</th>                                    
                                </tr>
                                <tbody class="divide-y">
                                    @foreach ($workersDeleted as $row)
                                        <tr class="whitespace-nowrap callstr">
                                            <td class="p-1">{{ $row->deleted_at }}</td>
                                            <td class="p-1">{{ $row->UserName }}</td>
                                            <td class="p-1">{{ $row->LastName }} {{ $row->FirstName }} {{ $row->MiddLeName }}. {{ $row->UID }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>                            


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

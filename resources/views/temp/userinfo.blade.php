<x-app-layout>
  <x-slot name="header">
      <div class="sm:grid sm:grid-cols-2">
              <dt class="">
                <h2 class="text-blue-800 font-semibold text-xl leading-tight flex items-stretch">

                </h2>
              </dt>
              <dd class="text-xl text-gray-900 text-right">
                <x-sname/>
      </div>
  </x-slot>



    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

<h2 class="text-2xl font-semibold text-xl text-gray-500 leading-tight">
    Пользователь
</h2>

<div class="md:px-32 py-8 w-full">
  <div class="shadow overflow-hidden rounded border-b border-gray-200">
    <table class="min-w-full bg-white">
      <thead class="bg-gray-300 text-white">
        <tr>
          <th class="text-left py-1 px-2 uppercase font-semibold text-sm">Параметр</th>
          <th class="text-left py-1 px-2 uppercase font-semibold text-sm">Значение</th>
        </tr>
      </thead>
    <tbody class="text-gray-700">

          <tr class="border-b hover:bg-orange-100">
            <td class="text-left py-1 px-2">UID</td>
            <td class="text-left py-1 px-2">{{ Auth::user()->UID }}</td>
          </tr>
          <tr class="border-b hover:bg-orange-100">
            <td class="text-left py-1 px-2">RoleID</td>
            <td class="text-left py-1 px-2">{{ Auth::user()->RoleID }}</td>
          </tr>
          <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">StationID</td>
              <td class="text-left py-1 px-2">{{ Auth::user()->StationID }}</td>
          </tr>
          <tr class="border-b hover:bg-orange-100">
            <td class="text-left py-1 px-2">login</td>
            <td class="text-left py-1 px-2">{{ Auth::user()->login }}</td>
          </tr>
          <tr class="border-b hover:bg-orange-100">
            <td class="text-left py-1 px-2">password</td>
            <td class="text-left py-1 px-2">{{ Auth::user()->password }}</td>
          </tr>
          <tr class="border-b hover:bg-orange-100">
            <td class="text-left py-1 px-2">CreateDate</td>
            <td class="text-left py-1 px-2">{{ Auth::user()->CreateDate }}</td>
          </tr>
          <tr class="border-b hover:bg-orange-100">
            <td class="text-left py-1 px-2">RoleDescription</td>
            <td class="text-left py-1 px-2">{{ Auth::user()->RoleDescription }}</td>

  </tr>
  </tbody>
  </table>
  </div>
  </div>


  <h2 class="uppercase font-semibold text-xl text-blue-900 leading-tight">
      Сессия
  </h2>

  <div class="md:px-32 py-8 w-full">
    <div class="shadow overflow-hidden rounded border-b border-gray-200">
      <table class="min-w-full bg-white">
        <thead class="bg-gray-300 text-white">
          <tr>
            <th class="text-left py-1 px-2 uppercase font-semibold text-sm">Параметр</th>
            <th class="text-left py-1 px-2 uppercase font-semibold text-sm">Значение</th>
          </tr>
        </thead>
      <tbody class="text-gray-700">

            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">TestTypeCode</td>
              <td class="text-left py-1 px-2">{{ Session::get('TestTypeCode') }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">TestTypeName</td>
              <td class="text-left py-1 px-2">{{ Session::get('TestTypeName') }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">RegionID</td>
              <td class="text-left py-1 px-2">{{ Session::get('RegionID') }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">RegionName</td>
              <td class="text-left py-1 px-2">{{ Session::get('RegionName') }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">StationID</td>
              <td class="text-left py-1 px-2">{{ Session::get('StationID') }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">PHP v</td>
              <td class="text-left py-1 px-2">{{ PHP_VERSION }}</td>
            </tr>
  </tr>
    </tbody>
    </table>
    </div>
    </div>




  <h2 class="uppercase font-semibold text-xl text-blue-900 leading-tight">
      ППЭ
  </h2>

    @foreach (Auth::user()->getStation() as $station)

  <div class="md:px-32 py-8 w-full">
    <div class="shadow overflow-hidden rounded border-b border-gray-200">
      <table class="min-w-full bg-white">
        <thead class="bg-gray-300 text-white">
          <tr>
            <th class="text-left py-1 px-2 uppercase font-semibold text-sm">Параметр</th>
            <th class="text-left py-1 px-2 uppercase font-semibold text-sm">Значение</th>
          </tr>
        </thead>
      <tbody class="text-gray-700">

            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">StationID</td>
              <td class="text-left py-1 px-2">{{ $station->StationID }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">Region</td>
              <td class="text-left py-1 px-2">{{ $station->Region }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">RegionName</td>
              <td class="text-left py-1 px-2">{{ $station->RegionName }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">StationCode</td>
              <td class="text-left py-1 px-2">{{ $station->StationCode }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">StationName</td>
              <td class="text-left py-1 px-2">{{ $station->StationName }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">StationDetails</td>
              <td class="text-left py-1 px-2">{{ $station->StationDetails }}</td>
            </tr>
            <tr class="border-b hover:bg-orange-100">
              <td class="text-left py-1 px-2">CreateDate</td>
              <td class="text-left py-1 px-2">{{ $station->CreateDate }}</td>
            </tr>


    </tr>
    </tbody>
    </table>
    </div>
    </div>

    @endforeach


    <h2 class="uppercase font-semibold text-xl text-blue-900 leading-tight">
        Аудитории
    </h2>

      @foreach (Auth::user()->getAuditoriums() as $aud)

    <div class="md:px-32 py-8 w-full">
      <div class="shadow overflow-hidden rounded border-b border-gray-200">
        <table class="min-w-full bg-white">
          <thead class="bg-gray-300 text-white">
            <tr>
              <th class="text-left py-1 px-2 uppercase font-semibold text-sm">Параметр</th>
              <th class="text-left py-1 px-2 uppercase font-semibold text-sm">Значение</th>
            </tr>
          </thead>
        <tbody class="text-gray-700">

              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">AuditoriumID</td>
                <td class="text-left py-1 px-2">{{ $aud->AuditoriumID }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">Region</td>
                <td class="text-left py-1 px-2">{{ $aud->Region }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">RegionName</td>
                <td class="text-left py-1 px-2">{{ $aud->RegionName }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">StationID</td>
                <td class="text-left py-1 px-2">{{ $aud->StationID }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">AuditoriumType</td>
                <td class="text-left py-1 px-2">{{ $aud->AuditoriumType }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">TypeName</td>
                <td class="text-left py-1 px-2">{{ $aud->TypeName }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">AuditoriumCode</td>
                <td class="text-left py-1 px-2">{{ $aud->AuditoriumCode }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">AuditoriumName</td>
                <td class="text-left py-1 px-2">{{ $aud->AuditoriumName }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">AuditoriumDetails</td>
                <td class="text-left py-1 px-2">{{ $aud->AuditoriumDetails }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">Volume</td>
                <td class="text-left py-1 px-2">{{ $aud->Volume }}</td>
              </tr>
              <tr class="border-b hover:bg-orange-100">
                <td class="text-left py-1 px-2">CreateDate</td>
                <td class="text-left py-1 px-2">{{ $aud->CreateDate }}</td>
              </tr>


      </tr>
      </tbody>
      </table>
      </div>
      </div>

      @endforeach


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

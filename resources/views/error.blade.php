<x-app-layout>
  <x-slot name="script"></x-slot>
    <x-slot name="header">
        <div class="sm:grid sm:grid-cols-2">
                <dt class="">
                  <h2 class="text-blue-800 font-semibold text-xl leading-tight flex items-stretch">

                  </h2>
                </dt>
                  <x-sname/>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2 class="font-semibold text-xl text-blue-800 leading-tight">
                        {{ $title }}
                    </h2>

<div class="flex items-center">
<div class="my-24 mx-auto text-center">

<table class="table-auto">
  <tbody>
    <tr>
      <td>
     <svg class="mx-5 flex-shrink-0 object-cover object-center h-10 w-10 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />  <line x1="12" y1="9" x2="12" y2="13" />  <line x1="12" y1="17" x2="12.01" y2="17" /></svg>
	</td>
	<td class="text-xl">{{ $msg }}</td>
    </tr>
  </tbody>
</table>

</div>
</div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

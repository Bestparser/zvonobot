<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-xl text-gray-500 leading-tight">
            Этап 1
        </h2>
    </x-slot>




    <div class="p-12 md:w-1/2 flex flex-col items-start">
            <a class="inline-flex items-center">
              <span class="flex-grow flex flex-col pl-4">
                <span class="">Alper Kamu</span>
                <span class="">DESIGNER</span>
              </span>
              <svg class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center h-6 w-6 text-green-800"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
            </a>
    </div>


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @php
                    $cnt =0;
                      $x = new App\Models\Exam;
                      $exams = $x->all();
                    @endphp

                    <h2 class="text-2xl font-semibold text-xl text-gray-500 leading-tight">
                        Выбор экзамена
                    </h2>

                    <!-- component -->
                    <div class="md:px-32 py-8 w-full">
                      <div class="shadow overflow-hidden rounded border-b border-gray-200">
                        <table class="min-w-full bg-white">
                          <thead class="bg-gray-800 text-white">
                            <tr>
                              <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Дата</th>
                              <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Предмет</th>
                              <th class="text-left py-3 px-4 uppercase font-semibold text-sm"></th>
                            </tr>
                          </thead>
                        <tbody class="text-gray-700">
                          @foreach ($exams as $exam)

                          <tr class="border-b hover:bg-orange-100" @php $cnt++; if (fmod($cnt, 2) == 0) { echo 'class="bg-gray-100"';} @endphp>
                            <td class="text-left py-3 px-4">{{$exam->ExamDate}}</td>
                            <td class="text-left py-3 px-4">{{$exam->SubjectName}}</td>
                            <td class="text-left py-3 px-4">
                              <a href="{{ URL::route('register') }}/">
                                <button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                  Выбрать
                                </button>
                              </a>
                              <!--<button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>-->

                            </td>
                          </tr>
                              @endforeach

                        </tbody>
                        </table>
                      </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<h3 class="title">Вопросы для анкеты "{{ $anketa }}"</h3>
<table class="usersTable mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
    <thead>
        <tr class="h-10">
            <th class="sticky top-0 bg-blue-50">ИД</th>
            <th class="sticky top-0 bg-blue-50">Вопрос</th>
            <th class="sticky top-0 bg-blue-50">Тег</th>
            <th class="sticky top-0 bg-blue-50">Поле</th>
            <th class="sticky top-0 bg-blue-50">Видимость</th>
            <th class="sticky top-0 bg-blue-50">Сортировка</th>
            <th class="sticky top-0 bg-blue-50">Управление</th>
        </tr>
    </thead>
    <tbody class="divide-y">                                    
        @foreach ($questions as $question)
            <tr class="whitespace-nowrap callstr">
                <td class="p-1">{{ $question->id }}</td>
                <td style="text-align: left;" class="p-1">{{ $question->q_name }}</td>
                <td class="p-1">{{ $question->teg }}</td>                
                <td class="p-1">{{ $question->field }}</td>
                <td class="p-1">                    
                    @if ($question->hidden == 0) Да @endif
                    @if ($question->hidden == 1) Нет @endif
                </td>
                <td class="p-1">{{ $question->order }}</td>
                <td class="p-1">
                    <div class="flex flex-col space-y-2 flex-nowrap justify-center items-center">
                        <a href="ankets?editQuestionID={{ $question->id }}" class="editUserButton padding-button inline-flex cursor-pointer justify-center items-center whitespace-nowrap focus:outline-none transition-colors focus:duration-150 border rounded ring-blue-700 p-2 hover:bg-gray-50 bg-white text-black border-gray-300 last:mr-0" type="button">
                            <span class="inline-flex justify-center items-center w-6">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" class="fill-white w-5 h-5"><path d="M4.479 15.646H5.5l7.562-7.563-1.02-1.041-7.563 7.562ZM15.708 7.25l-2.812-2.854.875-.875q.396-.396.906-.396.511 0 .885.396l1.042 1.041q.375.355.354.907-.02.552-.375.906Zm-.854.833-8.812 8.813H3.229v-2.813l8.813-8.812Zm-2.292-.521-.52-.52 1.02 1.041Z"></path></svg>        
                            </span>
                            <span class="padding-0">Изменить</span>
                        </a>
                    </div>
                </td>
            </tr>    
        @endforeach                                    
    </tbody>
</table>
</br>
<button type="button" onclick="location.href='{{ route('ankets') }}'" type="button" class="px-4 py-1 mr-10 bg-gray-100 bg-transparent rounded-lg text-indigo-500 hover:bg-gray-200 hover:text-indigo-400">Назад</button>

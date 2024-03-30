<h3 class="title">Редактирование анкеты</h3>
<div class="editUserForm">
    <form action="{{ route('ankets.editsave') }}" method="post">
        @csrf
        <input type="hidden" name="anketaID" value="{{$anketaID}}" />
        <table class="mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
            <tbody class="divide-y">            
                <tr>
                    <td class="p-1">Название:</td>
                    <td class="p-2">
                        <input type="text" name="anketaName" value="{{ $anketa->a_name }}" />
                    </td>
                </tr>
                <tr>
                    <td class="p-1">Описание:</td>
                    <td class="p-2">
                        <textarea name="anketaDesc">{{ $anketa->desc }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="p-1">Видимость:</td>
                    <td class="p-2">
                        <select name="anketaHidden">
                            <option @if ($anketa->hidden == 0) selected @endif value="0">Да</option>
                            <option @if ($anketa->hidden == 1) selected @endif value="1">Нет</option>
                        </select>                        
                    </td>
                </tr>
            </tbody>    
        </table>        
        <div class="pt-1 RightColumButtons">
            <button type="button" onclick="window.history.go(-1); return false;" type="button" class="px-4 py-1 mr-10 bg-gray-100 bg-transparent rounded-lg text-indigo-500 hover:bg-gray-200 hover:text-indigo-400">Отмена</button>
            <button class="px-4 py-1 bg-indigo-500 rounded-lg text-white hover:bg-indigo-400">Сохранить</button>
        </div>    
        <div class="pt-1 LeftColumButtons">
            <a href="?questionsAnketaID={{$anketaID}}">Вопросы данной анкеты</a>
        </div>    

    </form>
    <form class="deleteUserForm" action="{{ route('layouts.ankets.anket_delete') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$anketa->id}}" />
        <button type="submit" class="px-4 py-1 btn orange bg-red-500 float-right rounded-lg text-white hover:bg-red-400">Удалить</button>
    </form>
</div>
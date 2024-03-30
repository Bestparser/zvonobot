<h3 class="title">Добавление новой анкеты</h3>
<div class="editUserForm">
    <form action="{{ route('ankets.addsave') }}" method="post">
        @csrf        
        <table class="mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
            <tbody class="divide-y">            
                <tr>
                    <td class="p-1">Название:</td>
                    <td class="p-2">
                        <input type="text" name="anketaName" />
                    </td>
                </tr>
                <tr>
                    <td class="p-1">Описание:</td>
                    <td class="p-2">
                        <textarea name="anketaDesc"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="p-1">Видимость:</td>
                    <td class="p-2">
                        <select name="anketaHidden">
                            <option value="0">Да</option>
                            <option value="1">Нет</option>
                        </select>                        
                    </td>
                </tr>
            </tbody>    
        </table>        
        <div class="pt-1 RightColumButtons">
            <button type="button" onclick="window.history.go(-1); return false;" type="button" class="px-4 py-1 mr-10 bg-gray-100 bg-transparent rounded-lg text-indigo-500 hover:bg-gray-200 hover:text-indigo-400">Отмена</button>
            <button class="px-4 py-1 bg-indigo-500 rounded-lg text-white hover:bg-indigo-400">Сохранить</button>
        </div>    
    </form>
</div>
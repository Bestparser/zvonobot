<h3 class="title">Новый пользователь</h3>
<div class="editUserForm">
    <form action="{{ route('users.useraddsave') }}" method="post">
        @csrf   
        <table class="mt-3 border border-gray-200 text-gray-800 w-full text-sm text-center">
            <tbody class="divide-y">            
                <tr><td class="p-1">Имя пользователя:</td><td class="p-2"><input type="text" name="UserName" /></td></tr>
                <tr><td class="p-1">Логин:</td><td class="p-2"><input type="text" name="login" /></td></tr>
                <tr><td class="p-1">Пароль:</td><td class="p-2"><input type="text" name="password" /></td></tr>
                <tr>
                    <td class="p-1">Группа:</td>
                    <td class="p-2">
                        <select name="role">
                            @foreach($roles as $role)
                                <option value="{{$role->RoleID}}">{{$role->RoleName}}</option>
                            @endforeach    
                        </select>
                    </td>
                </tr>
                <tr><td class="p-1">Примечание:</td><td class="p-2"><textarea name="UserDetails"></textarea></td></tr>        
            </tbody>    
        </table>        
        <div class="pt-1 RightColumButtons">
            <button type="button" onclick="window.history.go(-1); return false;" type="button" class="px-4 py-1 mr-10 bg-gray-100 bg-transparent rounded-lg text-indigo-500 hover:bg-gray-200 hover:text-indigo-400">Отмена</button>
            <button class="px-4 py-1 bg-indigo-500 rounded-lg text-white hover:bg-indigo-400">Сохранить</button>        
        </div>    
    </form>
</div>
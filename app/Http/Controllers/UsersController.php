<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class UsersController extends Controller
{
    public function users(Request $request)
    {
        $returnArr = array();
        $users = DB::table('vUsers')
            ->whereNull('deleted_at')
            ->whereNotIn('UserID',[1])
            ->orderBy('UserID', 'ASC')
            ->get(); //->where('UserHidden', 0)

        // (к) Прям на странице users выводим через get форму редактирования и добавления пользователя
        if ($request->get('UserID') > 0){
            $UserID = $request->get('UserID');
            $userData = User::find($UserID);
            $roles = DB::table('UserRole')->get();
            $returnArr = [
                'UserID' => $UserID,
                'userData' => $userData,
                'roles' => $roles,
                'users' => $users,
            ];
        } elseif ($request->get('action') == 'addUser') {    
            $roles = DB::table('UserRole')->get();
            $returnArr = [              
                'UserID' => 0,
                'users' => $users,
                'action' => 'addUser',                
                'roles' => $roles,
            ];
        } else {
            $editUserID = 0;
            $returnArr = [
                'UserID' => 0,
                'users' => $users,
                'action' => ''
            ];
        }
        return view('users', $returnArr);
    }

    public static function changeOnline($date, $OffLine){ // (к) Замена upsert на (update / insert)
        $userTrue = 0;
        $userTrue = DB::table('OnLine')->where('UserID', Auth::user()->UserID)->count();
        
        if ($userTrue == 0){ // Если нет такого пользователя в базе, то insert
            DB::table('OnLine')->insert([
                'UserID' => Auth::user()->UserID,
                'OnLineDate' => $date,
                'OffLine' => $OffLine
            ]);
        } else { // Если есть такой пользователь в базе, то update
            DB::table('OnLine')->where('UserID', Auth::user()->UserID)->update([
                'OnLineDate' => $date,
                'OffLine' => $OffLine
            ]);
        }
    }


    public static function setOnLine()
    {
        $d = Carbon::now();
        self::changeOnline($d->format('Y-m-d\TH:i:s'), 0);
        return $d->format('d-m-Y H:i:s');
    }

    public static function setOffLine()
    {    
        $d = Carbon::now();
        self::changeOnline($d->format('Y-m-d\TH:i:s'), 1);
        return $d->format('d-m-Y H:i:s');
    }

    public function userEditSave(Request $request) // (к) Сохраняем изменения в редактировании пользователя
    {
        $valid = request()->validate([
            'UserName' => 'string',
            'login' => 'string',
            'password' => 'string',            
        ]);

        DB::table('Users')->where('UserID', $request->post('UserID'))->update([
            'UserName' => $valid['UserName'],
            'login' => $valid['login'],
            'password' => $valid['password'],
            'RoleID' => $request->post('role'),
            'UserDetails' => $request->post('UserDetails')
        ]);        

        return redirect()->route('users');
    }    

    public function userDelete(Request $request) // (к) Удаляем пользователя
    {
        DB::table('Users')->where('UserID', $request->post('UserID'))->delete();
        return redirect()->route('users');
    }

    public function userAddSave(Request $request) // (к) Добавляем нового пользователя
    {
        $valid = request()->validate([
            'UserName' => 'string',
            'login' => 'string',
            'password' => 'string'            
        ]);
    
        DB::table('Users')->insert([
            'UserName' => $valid['UserName'],
            'login' => $valid['login'],
            'password' => $valid['password'],
            'RoleID' => $request->post('role'),
            'UserDetails' => $request->post('UserDetails')
        ]);

        return redirect()->route('users');
    }



}

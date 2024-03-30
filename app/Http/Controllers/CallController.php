<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Call;
use App\Exports\ExportExcel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\Ankets;
use App\Models\Questions;
use App\Models\Answers;
use App\Models\Author;
use App\Models\Book;
use App\Models\CallDelete;
use App\Models\WorkerDelete;


class CallController extends Controller
{
    public function exportToExcel()
    {
        $filename = config('app.name').Carbon::now()->format('_m_d');
        return Excel::download(new ExportExcel, $filename.'.xlsx');
    }

    public function CallSave(Request $request) {
        
        // (к) Заменил upsert на insert и update
        if (!$request->has('uid')) return ['err'=>1,'msg'=>'нет UID'];
        $arrRequest = array(            
            'Сommunication' => $request->communication,
            'IsWorkerRole' => $request->rol,            
            'Experience' => $request->exp,
            'StudyDate' => $request->sty,
            'RegionStudy' => $request->rst,
            'AppFederal' => $request->appfederal,
            'AppRegion' => $request->appr,
            'Mark' => $request->mark,
            'KEGE' => $request->keg,
            
            'UID' => $request->uid,
            'UserID' => Auth::user()->UserID,
            'CreateDate' => Carbon::now()->format('Y-m-d\TH:i:s'),
            'anketa_id' => session('anketaID')
        );

        $updateInsert = 0;
        $uidTrue = 0;
        $uidTrue = DB::table('Calls')
                        ->where('UID', $request->uid)
                        ->where('anketa_id', session('anketaID'))
                        ->count();        

        if ($uidTrue == 0){
            $updateInsert = DB::table('Calls')->insert($arrRequest);
        } else {               
            $updateInsert = DB::table('Calls')
                            ->where('UID', $request->uid)
                            ->where('anketa_id', session('anketaID'))
                            ->update($arrRequest);            
        }               
        $call = Call::where('UID', $request->uid)->first();    
        
        $msg =  view('layouts.call_tr', [
            'i' =>  $call,
        ])->render();
                    
        if ($updateInsert != 1) {//Ошибка записи!!!            
            return [
                'err'=>1,
                'Сommunication'=> $request->communication,
                'update'=> $updateInsert,
                'msg'=>'Ошибка записи !!!'
            ];            
        }
        
        return ['err'=>0,
                'Сommunication'=> $request->communication,
                'update'=> $updateInsert,
                'msg'=>$msg
        ]; 
        
    }

    public function CallEdit(Request $request) {
        
        $ankets = new Ankets();
        $ankets->uid = $request->uid;        
        $dataCall = Call::where('UID', $request->uid)->first();

        return view('layouts.call_editmodal', 
            [
                'i' => $dataCall,
                'ankets' => $ankets->getEditCall($dataCall)                
            ]
        );
    }

    public function callfilter (Request $request){
        $query = Call::query();

            $order = 0;

            //dd($request->all());

            if ($request->has('order')) {
                $order = (int) $request->order;
            } else {
                $order = 0;
            }

            if ($order == 1) {
                $query->orderBy('Worker', 'asc');
            }

            if ($order == 2) {
                $query->orderBy('Worker', 'desc');
            }

            if ($order == 3 || $order == 0) {
                $query->orderBy('RegionID', 'asc');
            }

            if ($order == 4) {
                $query->orderBy('RegionID', 'desc');
            }

            if ($order == 6) {
                $query->orderBy('CreateDate', 'asc');
            }

            if ($order == 5) {
                $query->orderBy('CreateDate', 'desc');
            }

            if ($request->has('user')) {
                $user = (int) $request->user;
                if ($user>0) {
                    $query = $query->where('UserID',$user);
                }
            }

          if ($request->has('start')) {
              if (strlen($request->start) > 8) {
                $start = Carbon::createFromFormat('d.m.Y', $request->start)->format('Y-m-d\T00:00:00');
                $query->whereDate('CreateDate', '>=', $start);
              }
            }

            if ($request->has('end')) {
                if (strlen($request->end) > 8) {
                  $end = Carbon::createFromFormat('d.m.Y', $request->end)->format('Y-m-d\T23:59:59');
                  $query->whereDate('CreateDate', '<=', $end);
                }
              }

            if ($request->has('com')) {
                $com = (int) $request->com;

                if ($com == 99){//Все кроме 5
                    $query = $query->where('Сommunication', '<>' ,5)->whereNotNull('Сommunication');
                }

                if ($com == 88){//Все кроме 3
                    $query = $query->where('Сommunication', '<>' ,3);
                }

                if ($com == 5){//
                    $query = $query->where('Сommunication',5);
                }

                if ($com == 6){//
                    $query = $query->where('Сommunication',6);
                }

                if ($com>=0 && $com<5){
                    $query = $query->where('Сommunication',$com);
                }
                if ($com == -1){
                    $query = $query->where('Сommunication',$com)->orWhere('Сommunication', null);
                }
            }

            if ($request->has('search') && strlen($request->search)>1) {
                $query = $query->where('search','LIKE','%'.$request->search.'%');
            }

            if ($request->has('reg')) {//
                $query = $query->whereIn('RegionID',$request->reg);
            }
            $query = $query->where('anketa_id', '=', session('anketaID'));
           // dd($query->toSQL());

            return ['query'=>$query,'order'=>$order];
    }


    public function call(Request $request) {        
        $regions = DB::select('SELECT
                                    "RegionID",
                                    "RegionName",
                                    "RegionCode"
                                FROM
                                    "Regions"
                                ORDER BY
                                    "RegionID"');
        
        $users = DB::select('SELECT DISTINCT
                                "Users"."UserID",
                                "Users"."UserName"
                            FROM
                                "Users" RIGHT JOIN "Calls" ON "Users"."UserID"="Calls"."UserID"
                            WHERE
                                "Users"."UserID" is not null AND "Calls"."anketa_id" = '.session('anketaID').'
                            ORDER BY
                                "UserName" ASC');

        $page = 1;
        $limit = 1000;

        if ($request->has('page')) {
            $page = (int) $request->page;
        }

        $callfilter = $this->callfilter($request); //Обрабатываем фильтры
        $query = $callfilter['query'];

        $rows_all = $query->count();
        $page_cnt = ceil($rows_all/$limit);
        $calls = $query->offset($limit*($page-1))->limit($limit)->get();
        $rows_real = $calls->count();

        $role = DB::table('Users')->where('UserID', Auth::user()->UserID)->value('RoleID');
        
        return view('call', [   'calls' =>  $calls, // ОБЩИЕ ДАННЫЕ (ВСЯ ПРОСТЫНЯ НА ВЫВОД)
                                'rows_all' => $rows_all, // Количество строк
                                'rows_real' => $rows_real, // Строк в наличии показываются
                                'page' => $page, // Номер страницы
                                'page_cnt' => $page_cnt, // Количество страниц
                                'regions' => $regions, // Регионы
                                'order' => $callfilter['order'], // Из фильтра
                                'users' => $users, // Пользователи, которым уже звонили
                                'role' => $role,
                            ]);
    }

    public function deleteTS(Request $request){ // Удаляем ТС (воркера) на главной странице
        $uid = $request->get('uid');
        
        $dataCall = CallDelete::find($uid);        
        if (!$dataCall == null){
            $dataCall->update([
                'UserID' => Auth::user()->UserID
            ]);
            $dataCall->delete();
        }
        
        $dataWorker = WorkerDelete::find($uid);        
        if (!$dataWorker == null){
            $dataWorker->update([
                'UserID' => Auth::user()->UserID,
                'DeleteType' => 1
            ]);
            $dataWorker->delete();
        }


        return redirect()->route('call');
    }

    public function actionLog(Request $request){ // Страница журнал событий
        $workersDeleted = DB::table('Worker')
                                ->join('Users', 'Worker.UserID', '=', 'Users.UserID')
                                ->select('Worker.*', 'Users.UserName')
                                ->where('DeleteType', 1)
                                ->orderBy('deleted_at', 'desc')
                                ->get();

        return view('actionlog', [
            'workersDeleted' => $workersDeleted,
        ]);
    }


}

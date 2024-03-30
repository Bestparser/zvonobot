<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Call;
use App\Exports\ReportExcel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $report1 = DB::select('SELECT
                                --Users.UserName,
                                date_part(\'day\', "CreateDate") as dd,
                                date_part(\'month\', "CreateDate") as mm,
                                date_part(\'year\', "CreateDate") as yy,
                                COUNT(*) AS cnt,
                                SUM("COM0") as "COM0",
                                SUM("COM1") as "COM1",
                                SUM("COM2") as "COM2",
                                SUM("COM3") as "COM3",
                                SUM("COM4") as "COM4",
                                SUM("COM5") as "COM5",
                                SUM("COM6") as "COM6"
                            FROM
                            "vCallsStat"
                            WHERE "CreateDate" IS NOT NULL
                            AND "anketa_id" = '.session('anketaID').'
                            GROUP BY
                                date_part(\'day\', "CreateDate"),
                                date_part(\'month\', "CreateDate"),
                                date_part(\'year\', "CreateDate")                                
                            LIMIT 50    
                        ');

        $report1_2 = array();
        foreach ($report1 as $obj){      
            $obj->date = date($obj->yy . '-' . $obj->mm . '-' . $obj->dd);            
            array_push($report1_2, (array) $obj);            
        }

        usort($report1_2, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        $report1 = $report1_2; 
        

        $CountAll = DB::table("vCallsStat")->where('anketa_id', session('anketaID'))->count();
        $CountConnect = DB::table("vCallsStat")->whereIn('Сommunication', [2, 3, 4])->where('anketa_id', session('anketaID'))->count();
        $Сommunication5 = DB::table("vCallsStat")->whereIn('Сommunication', [5])->where('anketa_id', session('anketaID'))->count();
        $CountNotConnect = DB::table("vCallsStat")->whereIn('Сommunication', [0, 1])->where('anketa_id', session('anketaID'))->count();
        $needCallOperator = DB::table("vCallsStat")->whereIn('Сommunication', [0, 6])->where('anketa_id', session('anketaID'))->count();

        return view('report', [
            'report1' => $report1,            
            'CountAll' => $CountAll,
            'CountConnect' => $CountConnect,
            'Сommunication5' => $Сommunication5,
            'CountNotConnect' => $CountNotConnect,
            'needCallOperator' => $needCallOperator
        ]);
    }

    public function reportToExcel()
    {       
        $filename = config('app.name').Carbon::now()->format('_m_d');
        return Excel::download(new ReportExcel, $filename.'_report.xlsx');
    }




}

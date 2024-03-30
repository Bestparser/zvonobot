<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{

    public function test(Request $request) {
        //dd($request->all());
        return 'dfdsfdsf################################';
    }

    public function exportLog(Request $request)
    {
        $ExportLog = DB::table('vExportLog')
                                ->orderBy('EID', 'DESC')
                                ->where('anketa_id', '=', session('anketaID'))
                                ->get();

        return view('exportLog', ['ExportLog' => $ExportLog]);
    }

	public static function exportToCSV()
    {
        \Artisan::call('export:csv '.session('anketaID').'');
        return redirect()->route('exportLog');
    }


}

<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\FromQuery;
//use Maatwebsite\Excel\Concerns\Exportable;

class ExportCSV implements FromCollection
{

    //use Exportable;

    //public function query()
    public function collection()
    {
       /* $str = "SELECT w.UID,
        w.RegionID as RegionID,
        w.PositionID as PositionID,
        (w.LastName + ' ' + SUBSTRING(w.FirstName, 1, 1) + '.' + SUBSTRING(w.MiddLeName, 1, 1) + '.') AS Username,
        w.StationCode as StationCode,
        isnull(c.[Сommunication],5) as Сommunication,
        c.IsWorkerRole,
        c.Experience,
        c.KEGE,
        c.StudyDate,
        c.RegionStudy,
        c.AppFederal,
        c.AppRegion,
        c.Mark
        FROM
        Worker AS w
        LEFT JOIN Calls AS c ON w.UID = c.UID
        WHERE
        w.DeleteType = 0
        AND RegionID !=90 ORDER BY RegionID ASC";

        return DB::query($str);*/

        /*$r = DB::table('vCallsStat')->select(DB::raw('COUNT(*) AS cnt'))->where('RegionID','<>',90)->first();
		return   DB::table('vCalls_export')->take($r->cnt)->orderBy('RegionID', 'ASC')->get();*/

        return   DB::table('vCalls_export')->orderBy('RegionID', 'ASC')->get();
    }


	/*public function headings(): array
		{
			return [
				'UID',
				'RegionID',
			];
		}*/

}

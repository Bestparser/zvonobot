<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
//use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class UserChart extends BaseChart
{
    /**
     * Determines the chart name to be used on the
     * route. If null, the name will be a snake_case
     * version of the class name.
     */
    public ?string $name = 'UserChart';

    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directrive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'UserChart';

    /**
     * Determines the prefix that will be used by the chart
     * endpoint.
     */
    public ?string $prefix = '';

    /**
     * Determines the middlewares that will be applied
     * to the chart endpoint.
     */
    public ?array $middlewares = ['auth'];

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
       /* $sports = DB::table('sports')->get();
        $labels = [];
        $count = [];
        foreach ($sports as $sport){
            array_push($labels,$sport->name);
        }
        $values = Sport::with('users' )->get();
        foreach ($values as $item) {
            array_push($count,$item->users->count());
        }
        return Chartisan::build()
            ->labels($labels)
            ->dataset('Sample', $count);*/

            //$chart = Chartisan::build('line', 'highcharts')
            //->setTitle('My nice chart')
            //->setLabels(['First', 'Second', 'Third'])
            //->setValues([5,10,20])
            //->setDimensions(1000,500)
            //->setResponsive(false);


        return Chartisan::build()
            ->labels(['Общее количество специалистов', 'Ожидают звонок', 'Удалось связаться', 'Не удалось связаться'])
            /*->extra([
                'backgroundColor' => 'rgba(99, 132, 33, 0.6)',
            ])*/
            ->dataset('', [5, 7, 9, 12]);
    }
}

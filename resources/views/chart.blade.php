<x-app-layout>
    <x-slot name="header">
        <div class="h-7"></div>
    </x-slot>

    <x-slot name="script">
        <script>
                $(document).ready(function(){

                });
        </script>
    </x-slot>

    <div class="py-1">

        <div class="max-w-full mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 bg-white border-b border-gray-200">






                    <div style="height: 70vh;" class="flex flex-col">
                        <div class="flex-grow overflow-auto px-10">



 <!-- Chart's container -->
 <div id="chart" style="height: 500px;"></div>
 <!-- Charting library -->
 <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
 <!-- Chartisan -->
 <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
 <!-- Your application script -->
 <script>

var othersData = {
         label: 'Others',
         data: [1,2,3],
         backgroundColor: 'rgba(99, 132, 0, 0.6)',
         borderWidth: 0,
          yAxisID: "y-axis-1"
      };

   const chart = new Chartisan({
     el: '#chart',
     url: "@chart('UserChart')",
     loader: {
    color: '#ff00ff',
    size: [30, 30],
    type: 'bar',
    textColor: '#ffff00',
    text: 'Loading some chart data...',
  },
    error: {
    color: '#ff00ff',
    size: [30, 30],
    text: 'Ошибка...',
    textColor: '#ffff00',
    type: 'general',
    debug: true,
  },
  hooks: new ChartisanHooks()
  /*.legend()*/
  /*.axis(true)*/
  .tooltip()
    .colors(['#ECC94B', '#4211E1', '#11C900', '#0099E1'])
    /*.datasets(['bar'])*/
    /*.legend({ bottom: 0 })
    .axis({
        yAxis:{
           type:'value',
           yAxisIndex:1,
           name:"Health",
           position:'left',
           axisLine: {
                show: true,
           },
            axisLabel:{
            formatter: "{value} %",
            min:0,
            max:100,
          },
        },
        yAxis:{
          type:'value',
          yAxisIndex:2,
          name:'Passed tests',
          position:'left',
          axisLine: {
                show: true,
           },
          axisLabel:{
            min:0,
            max:200,
          },
        }
      })*/
    /*.title('This is a sample chart using chartisan!')*/
    .title({
        textAlign: 'center',
        left: '50%',
        text: 'Заголовок диаграммы',
        textColor: 'rgba(255,198,218,1)',
        color: 'rgba(38,255,218,1)',
        fontSize: '20px',
      })
      .tooltip({
        trigger: 'item',
        axisPointer: {
      label: {
        formatter: 'format1',
      },
    },
        textColor: 'rgba(255,198,218,1)',
        color: 'rgba(38,255,218,1)',
      })

    .datasets(
                [
                    {   type: 'line',
                    areaStyle: {
                opacity: 0.5,
                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                    offset: 0,
                    color: 'rgba(128, 255, 165)'
                }, {
                    offset: 1,
                    color: 'rgba(1, 191, 236)'
                }])
            }
                    },
                    {
                        type: 'bar',
                        fill: true
                    },
                    {
                        type: 'bar',
                        fill: true
                    },
                    {
                        type: 'bar',
                        fill: true
                    }
                ]
            )
    /*.datasets([
        {
          type: 'line',
          smooth: false,
          lineStyle: { width: 2 },
          symbolSize: 7,
          animationEasing: 'cubicInOut',
          areaStyle: {
                opacity: 0.8,
                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                    offset: 0,
                    color: 'rgba(128, 255, 165)'
                }, {
                    offset: 1,
                    color: 'rgba(1, 191, 236)'
                }])
            }
        },
        'bar',
      ]),*/
});
 </script>





<link rel="stylesheet" href="{{ asset('css/charts.min.css') }}">
<div id="my-chart" class="h-64" style="max-width: 600px;">
    <table class="charts-css column show-heading show-labels data-spacing-20">
<caption> Single Dataset Table </caption>
<thead>
    <tr>
        <th scope="col"> Month fdg fgdfs gsdfgdsfgdf</th>
        <th scope="col"> Progress </th>
    </tr>
</thead>
<tbody>

<tr><th scope="row"><span  style="margin-top: 20px;">Общее количество специалистов</span></th>
    <td style="--start:0.15; --size:0.32;"><span class="data" style="margin: 10px;"> 32 (10%) </span></td></tr>
<tr><th scope="row"> Sep </th> <td style="--start:0.32; --size:0.6; --color: red;"><span class="data"> 60 </span></td></tr>
<tr><th scope="row"> Oct </th> <td style="--start:0.6; --size:0.9;"><span class="data"> 90 </span></td></tr>
<tr><th scope="row"> Nov </th> <td style="--start:0.9; --size:0.55;"><span class="data"> 55 </span></td></tr>
</tbody>
</table>
</div>

<br><br><br><br><br><br>

<style>
    #my-chart .bar {

    }
</style>




<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["1Element", "Всего", { role: "style" } ],
        ["2Copper", 8.94, "#b87333"],
        ["3Silver", 10.49, "silver"],
        ["4Gold", 19.30, "gold"],
        ["5Platinum", 21.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        width: 800,
        height: 400,
        bar: {groupWidth: "55%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>


                        </div>
                    </div>




                </div>
            </div>


            <div class="m-2 w-full text-xs text-center">
                {{ config('app.name') }}, {{ config('app.ver') }} {{ Auth::user()->UserID }}
            </div>


        </div>
    </div>
</x-app-layout>

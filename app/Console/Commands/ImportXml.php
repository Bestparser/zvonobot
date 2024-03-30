<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ImportController;
use Carbon\Carbon;


class ImportXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import XML из ФИС';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename_yesterday = 'workers_sdo_'.Carbon::now()->yesterday()->format('Y-m-d').'_20-00'.'.zip';
        $dir_t = 'q:\processed';
        $dir_c = 'c:\test2';
        $filename_t = $dir_t.'\\'.$filename_yesterday;
        $filename_c = $dir_c.'\\'.$filename_yesterday;
        $file_xml = $dir_c.'\workers_sdo.xml';

        $this->exec_str('net use Q: \\\85.143.100.30\egeedu /user:certupload uplCert2iK');
        $this->exec_str('xcopy '.$filename_t.' '.$dir_c.'\ /s /e /y /d /q');

        $filename_t = 'q:\\'.$filename_yesterday; 
        $this->exec_str('xcopy '.$filename_t.' '.$dir_c.'\ /s /e /y /d /q'); //для второго каталога  = голова

        $this->exec_str('"c:\Program Files\7-Zip\7z.exe" e -y '.$filename_c.' -o'.$dir_c.' -p18SdoExport');

       ImportController::import($file_xml);

       $this->exec_str('net use Q:  /delete');
       $this->exec_str('rd "c:\test2\workers_sdo_2021-03-11_20-00"');
       $this->exec_str('del "'. $filename_c.'"');

        return 0;
    }

     public static function exec_str($cmd){

        echo $cmd."\n";

        $out=exec($cmd, $output, $value);

        if (is_array($output)) {
            foreach ($output as $o) {
                if (strlen($o) > 1) {
                    echo '    # '.$o."\n";
                }
            }
        } else {
            var_dump($output);
        }

        if (isset($value)) {
            if ($value===0){
                echo "OK\n";
            }
        }
    }
}

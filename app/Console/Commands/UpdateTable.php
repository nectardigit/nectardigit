<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class UpdateTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        try {
          
            $key = 'create_extra_fields_in_table';
            $migration = DB::table('migrations')->where('migration', 'like', '%'.$key.'%')->delete();
            echo "Migration removed \n";
            
            Artisan::call('migrate');
            
            echo "============== \n";
            echo "New fields again migrated \n";
        }catch(\Exception $e){
            echo  $e->getMessage();
        }
    }
}

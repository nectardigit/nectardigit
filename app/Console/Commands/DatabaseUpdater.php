<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class DatabaseUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:table {table_name}';

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
        // dd($this->argument('table_name'));
        try {
            Schema::dropIfExists($this->argument('table_name'));
            echo " table removed \n";
            $key = 'create_'.$this->argument('table_name').'_table';
            $migration = \DB::table('migrations')->where('migration', 'like', '%'.$key.'%')->delete();
            echo "migration removed";
            Artisan::call('migrate');
            // dd($migraiton);
        }catch(\Exception $e){
            echo  $e->getMessage();
        }
    }
}

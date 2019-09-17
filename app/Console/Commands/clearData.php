<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class clearData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DB:clearData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear all data from database';

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
     * @return mixed
     */
    public function handle()
    {
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current',$tables);

        foreach ($tables as $name) {
            DB::table($name)->delete();
        }
        $this->info('clear Data from Database - done!');
    }
}

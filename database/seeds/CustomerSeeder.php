<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('migrate:import-customers');
    }
}

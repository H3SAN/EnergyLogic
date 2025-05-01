<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimeslotCostsSeeder extends Seeder
{
    public function run()
    {
        DB::table('timeslot_costs')->insert([
            [
                'start_time' => '00:00:00',
                'end_time' => '06:00:00',
                'cost_per_kwh' => 0.15,
                'label' => 'off-peak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'start_time' => '06:00:00',
                'end_time' => '10:00:00',
                'cost_per_kwh' => 0.50,
                'label' => 'peak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'start_time' => '10:00:00',
                'end_time' => '17:00:00',
                'cost_per_kwh' => 0.30,
                'label' => 'mid-peak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'start_time' => '17:00:00',
                'end_time' => '21:00:00',
                'cost_per_kwh' => 0.40,
                'label' => 'peak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'start_time' => '21:00:00',
                'end_time' => '00:00:00',
                'cost_per_kwh' => 0.20,
                'label' => 'off-peak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

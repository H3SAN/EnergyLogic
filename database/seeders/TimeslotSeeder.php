<?php

namespace Database\Seeders;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TimeslotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('timeslots')->insert([
            [
                'name' => '00:00:00',
                'start_time' => '00:00:00',
                'end_time' => '03:00:00',
                'rate_per_kwh' => 0.15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '03:00:00',
                'start_time' => '03:00:00',
                'end_time' => '06:00:00',
                'rate_per_kwh' => 0.18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '06:00:00',
                'start_time' => '06:00:00',
                'end_time' => '09:00:00',
                'rate_per_kwh' => 0.12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '09:00:00',
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'rate_per_kwh' => 0.12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '12:00:00',
                'start_time' => '12:00:00',
                'end_time' => '15:00:00',
                'rate_per_kwh' => 0.22,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '15:00:00',
                'start_time' => '15:00:00',
                'end_time' => '18:00:00',
                'rate_per_kwh' => 0.10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '18:00:00',
                'start_time' => '18:00:00',
                'end_time' => '21:00:00',
                'rate_per_kwh' => 0.17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '21:00:00',
                'start_time' => '21:00:00',
                'end_time' => '00:00:00',
                'rate_per_kwh' => 0.25,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

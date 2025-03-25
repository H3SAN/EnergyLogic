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
        DB::table('timeslot')->insert([[
            'name' => '00:00:00',
            'rate_per_kwh' => 0.15
        ],
        [
            'name' => '03:00:00',
            'rate_per_kwh' => 0.18
        ],
        [
            'name' => '06:00:00',
            'rate_per_kwh' => 0.12
        ],
        [
            'name' => '12:00:00',
            'rate_per_kwh' => 0.22
        ],
        [
            'name' => '15:00:00',
            'rate_per_kwh' => 0.10
        ],
        [
            'name' => '18:00:00',
            'rate_per_kwh' => 0.17
        ],
        [
            'name' => '21:00:00',
            'rate_per_kwh' => 0.25
        ]
        ]);
    }
}

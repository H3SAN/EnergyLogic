<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ApplianceSeeder extends Seeder
{
    public function run(): void
    {
        $appliances = [
            'Refrigerator', 'Washing Machine', 'Dryer', 'Microwave', 'Dishwasher',
            'Electric Kettle', 'Toaster', 'Television', 'Air Conditioner', 'Heater',
            'Laptop', 'Desktop Computer', 'Ceiling Fan', 'Vacuum Cleaner', 'Hair Dryer',
            'Iron', 'Water Heater', 'Electric Stove', 'Oven', 'Coffee Maker',
            'Blender', 'Game Console', 'Router', 'Smart Speaker', 'Printer'
        ];

        $statuses = ['on', 'off', 'standby'];
        $ratings = ['A++', 'A+', 'A', 'B', 'C', 'D', 'E'];

        foreach ($appliances as $appliance) {
            DB::table('appliances')->insert([
                'user_id' => 1,//rand(1, 5),
                'name' => $appliance,
                'power_rating_watts' => rand(50, 3000),
                'status' => $statuses[array_rand($statuses)],
                'schedule_time' => Carbon::createFromTime(rand(0, 23), rand(0, 59))->format('H:i:s'),
                'daily_usage_hours' => round(rand(10, 200) / 10, 2), // e.g., 1.0 to 20.0 hours
                'duration' => round(rand(10, 30) / 10, 1), // e.g., 1.0 to 3.0 hours
                'energy_efficiency_rating' => $ratings[array_rand($ratings)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

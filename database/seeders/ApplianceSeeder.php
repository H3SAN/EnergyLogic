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
                'power_consumption' => rand(50, 3000),
                'status' => $statuses[array_rand($statuses)],
                'energy_efficiency_rating' => $ratings[array_rand($ratings)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

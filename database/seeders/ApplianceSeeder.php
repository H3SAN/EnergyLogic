<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class AppliancesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('appliances')->truncate(); // Clears existing data

        $appliances = [
            [1, 1, 'Refrigerator', 1728, 'off', '18:00', 2.3, 'B', '2025-03-23 17:49:33', '2025-03-31 17:49:33'],
            [2, 1, 'Washing Machine', 433, 'on', '03:00', 4.1, 'A+', '2025-03-13 17:49:33', '2025-03-14 17:49:33'],
            [3, 1, 'Microwave', 1080, 'on', '03:00', 5.1, 'C', '2025-03-16 17:49:33', '2025-03-17 17:49:33'],
            [4, 1, 'Air Conditioner', 1749, 'off', '12:00', 5.9, 'C', '2025-03-01 17:49:33', '2025-03-08 17:49:33'],
            [5, 1, 'Television', 2704, 'standby', '15:00', 3.6, 'D', '2025-02-28 17:49:33', '2025-03-01 17:49:33'],
            [6, 1, 'Water Heater', 2666, 'standby', '15:00', 3.9, 'B', '2025-02-28 17:49:33', '2025-03-08 17:49:33'],
            [7, 1, 'Dishwasher', 2116, 'off', '06:00', 1.5, 'E', '2025-03-11 17:49:33', '2025-03-20 17:49:33'],
            [8, 1, 'Oven', 2682, 'on', '15:00', 4.2, 'D', '2025-02-25 17:49:33', '2025-03-05 17:49:33'],
            [9, 1, 'Fan', 2352, 'standby', '00:00', 1.6, 'C', '2025-03-04 17:49:33', '2025-03-13 17:49:33'],
            [10, 1, 'Laptop', 2612, 'on', '15:00', 0.9, 'A', '2025-03-18 17:49:33', '2025-03-23 17:49:33'],
            [11, 1, 'Coffee Maker', 2927, 'on', '09:00', 0.5, 'A', '2025-03-02 17:49:33', '2025-03-11 17:49:33'],
            [12, 1, 'Toaster', 2796, 'on', '12:00', 0.9, 'C', '2025-03-04 17:49:33', '2025-03-10 17:49:33'],
            [13, 1, 'Iron', 2386, 'on', '00:00', 0.6, 'A', '2025-02-27 17:49:33', '2025-03-08 17:49:33'],
            [14, 1, 'Vacuum Cleaner', 118, 'on', '21:00', 5.9, 'B', '2025-03-17 17:49:33', '2025-03-23 17:49:33'],
            [15, 1, 'Hair Dryer', 1530, 'on', '21:00', 5.1, 'B', '2025-02-28 17:49:33', '2025-03-04 17:49:33'],
            [16, 1, 'Heater', 794, 'standby', '15:00', 5.7, 'A+', '2025-02-23 17:49:33', '2025-03-05 17:49:33'],
            [17, 1, 'Freezer', 1904, 'off', '15:00', 4.7, 'C', '2025-03-07 17:49:33', '2025-03-14 17:49:33']
        ];

        foreach ($appliances as $app) {
            DB::table('appliances')->insert([
                'id' => $app[0],
                'user_id' => $app[1],
                'name' => $app[2],
                'power_rating_watts' => $app[3],
                'status' => $app[4],
                'schedule_time' => $app[5],
                'daily_usage_hours' => $app[6],
                'energy_efficiency_rating' => $app[7],
                'created_at' => Carbon::parse($app[8]),
                'updated_at' => Carbon::parse($app[9]),
            ]);
        }
    }
}

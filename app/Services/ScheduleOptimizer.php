<?php
namespace App\Services;

use App\Models\Appliances;
use App\Models\Timeslot;
use App\Models\Schedule;

class ScheduleOptimizer
{
    public function optimize(array $applianceIds, int $userId)
    {
        $appliances = Appliances::whereIn('id', $applianceIds)->get();

        $appliances = $appliances->sortByDesc(function ($a) {
            return $a->power_consumption * $a->daily_usage_hours;
        });

        // Keep original Eloquent models and add temp property
        $timeslots = Timeslot::orderBy('rate_per_kwh')->get();
        foreach ($timeslots as $slot) {
            $slot->remaining_hours = 3; // add temp property to object
        }

        $assignments = [];

        foreach ($appliances as $appliance) {
            foreach ($timeslots as $slot) {
                if ($slot->remaining_hours >= $appliance->duration) {
                    $slot->remaining_hours -= $appliance->duration;
        
                    $assignments[] = [
                        'appliance_id' => $appliance->id,
                        'timeslot_id' => $slot->id,
                        'estimated_cost' => $appliance->power_rating + $appliance->duration + $slot->rate_per_kwh,
                        'duration' => $appliance->duration,
                    ];
        
                    break;
                }
            }
        }
        

        $schedule = Schedule::create([
            'user_id' => $userId,
            'name' => 'Optimized Schedule - ' . now()->format('Y-m-d H:i'),
        ]);

        foreach ($assignments as $assignment) {
            $schedule->applianceAssignments()->create($assignment);
        }

        return $schedule->load('applianceAssignments');
    }
}

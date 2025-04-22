<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appliances;
use App\Models\ApplianceSchedule;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Services\ScheduleOptimizer;
use App\Models\Timeslot;

class ScheduleController extends Controller
{
    public function index()
{
    //This displays the appliances on the active schedule
    $data = ApplianceSchedule::whereHas('schedule', function ($query) {
        $query->where('is_active', 1);
    })->with(['appliance', 'schedule', 'timeslot'])->get();

    // This displays the active schedule name
    $activeSchedule = Schedule::where('is_active', 1)
    ->where('user_id', 1)
    ->first();

    // This is to display all available schedules 
    $schedules = Schedule::where('user_id', 1)->get(); // change this to auth()->id() later

    // This is to display all available appliances 
    $AllAppliances = Appliances::where('user_id', 1)->get(); // change this to auth()->id() later

    return view('schedule.index', [
        'appliances' => $data,
        'ActiveSchedule' => $activeSchedule,
        'schedule' => $schedules,
        'AllAppliances' => $AllAppliances
    ]);
}

public function addSchedule(Request $request)
{
    // Validate input
    // dd($request->all());
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'appliances' => 'required|array',
        'appliances.*' => 'exists:appliances,id',
        'timeslots' => 'required|array',
        'durations' => 'required|array',
    ]);
        $isActive = $request->has('is_active') ? 1 : 0;

    // Create Schedule
    $schedule = Schedule::create([
        'name' => $validated['name'],
        'is_active' => $isActive,
        'user_id' => 1 // auth()->id()
    ]);

    // Attach appliances with timeslot and duration
    foreach ($validated['appliances'] as $applianceId) {
        $timeslotId = $validated['timeslots'][$applianceId];
        $durationMinutes = $validated['durations'][$applianceId];
    
        $cost = $this->calculateEstimatedCost($applianceId, $durationMinutes, $timeslotId);
    
        $schedule->appliances()->attach($applianceId, [
            'timeslot_id' => $timeslotId,
            'duration_minutes' => $durationMinutes,
            'estimated_cost' => $cost,
        ]);
    }
    
    

    return redirect()->route('schedule.index')->with('success', 'Schedule created successfully!');
}

// public function addSchedule(Request $request)
//     {
//         // dd($request->all());
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'appliances' => 'required|array',
//             'appliances.*' => 'exists:appliances,id',
//             'is_active' => 'nullable|boolean',
//         ]);
    
//         $isActive = $request->has('is_active') ? 1 : 0;
//         $userId = 1; // Replace with auth()->id() when ready
    
//         // Step 1: Run optimization
//         $optimizer = new ScheduleOptimizer();
//         $schedule = $optimizer->optimize($validated['appliances'], $userId);
    
//         // Step 2: Update schedule metadata
//         $schedule->name = $request->input('name');
//         $schedule->user_id = $userId;
//         // $schedule->description = $request->input('desc');
//         $schedule->is_active = $isActive;
//         $schedule->save();
    
//         return redirect()->back()->with('success', 'Schedule optimized and saved!');
//     }


    public function setActive($id)
    {
    // Find the schedule first
    $schedule = Schedule::findOrFail($id);
    
    // Get the user ID associated with that schedule
    $userId = $schedule->user_id;

    // Set all schedules for this user to inactive
    Schedule::where('user_id', $userId)->update(['is_active' => 0]);

    // Set the chosen schedule to active
    $schedule->is_active = 1;
    $schedule->save();

    return redirect()->back()->with('success', 'Appliance deleted successfully!');
    }
    
    public function delete($id)
{
    // Delete all appliance_schedule records linked to this schedule first
    ApplianceSchedule::where('schedule_id', $id)->delete();

    // Now delete the schedule itself
    $schedule = Schedule::find($id);
    $schedule?->delete(); // Just in case it's already null

    return redirect()->back()->with('success', 'Schedule and related appliances deleted successfully!');
}
/**
 * Calculate the estimated cost of running an appliance.
 *
 * @param int $applianceId
 * @param int $durationMinutes
 * @return float
 */
private function calculateEstimatedCost($applianceId, $durationMinutes, $timeslotId)
{
    $appliance = Appliances::find($applianceId);
    $timeslot = Timeslot::find($timeslotId);

    // Fallback if either is missing
    if (!$appliance || !$timeslot) {
        return 0;
    }

    $powerRating = $appliance->power_rating_watts; // in W or kW
    $costPerKwh = $timeslot->cost_per_kwh;
    $durationHours = $durationMinutes / 60;

    // If stored in W, convert to kW
    if ($powerRating > 10) { // crude check
        $powerRating = $powerRating / 1000;
    }

    $energyConsumed = $powerRating * $durationHours;
    $estimatedCost = $energyConsumed * $costPerKwh;

    return round($estimatedCost, 2);
}


}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appliances;
use App\Models\ApplianceSchedule;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Services\ScheduleOptimizer;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
{
    //This displays the appliances on the active schedule
    $data = ApplianceSchedule::whereHas('schedule', function ($query) {
        $query->where('is_active', 1);
    })->with(['appliance', 'schedule'])->get();

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
    //dd($request->all());
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i',
        'appliances' => 'required|array',
        'appliances.*' => 'exists:appliances,id',
        'timeslots' => 'required|array',
        'timeslots.*.duration' => 'required|integer|min:1',
    ]);

    $isActive = $request->has('is_active') ? 1 : 0;

// Create the Schedule
$schedule = Schedule::create([
    'name' => $validated['name'],
    'is_active' => $isActive,
    'user_id' => 1, // Use auth()->id() in real use
    'start_time' => $validated['start_time'],
    'end_time' => $validated['end_time'],
]);


// Attach Appliances
foreach ($validated['appliances'] as $applianceId) {
    $durationMinutes = $validated['timeslots'][$applianceId]['duration'];

    $cost = $this->calculateEstimatedCost($applianceId, $durationMinutes);

    $schedule->appliances()->attach($applianceId, [
        'duration_minutes' => $durationMinutes,
        'estimated_cost' => $cost,
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
    ]);
}
    return redirect()->route('schedule.index')->with('success', 'Schedule created successfully!');
}

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
private function calculateEstimatedCost($applianceId, $durationMinutes)
{
    // Fixed cost per hour
    $costPerHour = 0.2;

    // Get the appliance
    $appliance = Appliances::findOrFail($applianceId);

    // Power consumed per hour in watts (from database)
    $powerConsumedWatts = $appliance->power_consumption;

    // Convert power consumption to kilowatt-hours (kWh)
    $powerConsumedKWh = $powerConsumedWatts / 1000; // because 1 kW = 1000 W

    // Calculate duration in hours
    $durationHours = $durationMinutes / 60;

    // Total energy used in kWh
    $energyUsed = $powerConsumedKWh * $durationHours;

    // Calculate estimated cost
    $estimatedCost = $energyUsed * $costPerHour;

    // Round to 2 decimal places for currency
    return round($estimatedCost, 2);
}

}

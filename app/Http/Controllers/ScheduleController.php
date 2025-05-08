<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appliances;
use App\Models\ApplianceSchedule;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Services\ScheduleOptimizer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
{
    $userId = 1; // later replace with auth()->id()

    // Get the active schedule
    $activeSchedule = Schedule::where('is_active', 1)
        ->where('user_id', $userId)
        ->first();

    // Initialize total saved
    $totalSaved = 0;

    if ($activeSchedule) {
        // Sum cost_saved dynamically for the active schedule
        $totalSaved = ApplianceSchedule::where('schedule_id', $activeSchedule->id)
            ->sum('cost_saved');
    }

    // Displays appliances on the active schedule
    $data = ApplianceSchedule::whereHas('schedule', function ($query) {
        $query->where('is_active', 1);
    })->with(['appliance', 'schedule'])->get();

    // All available schedules 
    $schedules = Schedule::where('user_id', $userId)->get();

    // All available appliances 
    $AllAppliances = Appliances::where('user_id', $userId)->get();

    // Total cost saved across all schedules for this user
    $totalCostSaved = $this->getTotalCostSaved(1);

    return view('schedule.index', [
        'appliances' => $data,
        'ActiveSchedule' => $activeSchedule,
        'schedule' => $schedules,
        'AllAppliances' => $AllAppliances,
        'TotalSaved' => $totalSaved,
        'TotalCostSaved' => $totalCostSaved
    ]);
}


public function addSchedule(Request $request)
{
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

    // Make other schedules inactive if needed
    if ($isActive) {
        Schedule::where('user_id', 1)->update(['is_active' => 0]);
    }

    $schedule = Schedule::create([
        'name' => $validated['name'],
        'is_active' => $isActive,
        'user_id' => 1, // Replace with auth()->id() if authentication is used
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
    ]);

    $scheduleStart = Carbon::parse($validated['start_time']);
    $scheduleEnd = Carbon::parse($validated['end_time']);

    foreach ($validated['appliances'] as $applianceId) {
        $duration = (int) $validated['timeslots'][$applianceId]['duration'];

        $appliance = Appliances::find($applianceId);
        $isHeavy = $appliance->power_consumption > 1500;

        if ($isHeavy) {
            $startTime = $this->findCheapestTimeSlot($scheduleStart, $scheduleEnd, $duration);
        } else {
            $startTime = $this->randomTimeBetween($scheduleStart, $scheduleEnd->copy()->subMinutes($duration));
        }

        $endTime = $startTime->copy()->addMinutes($duration);

        // Destructure the returned array
        $costData = $this->calculateEstimatedCost($applianceId, $duration, $startTime);
        $energyUsed = $costData['energy_used_kwh'];
        $estimatedCost = $costData['estimated_cost'];

        $baselineCost = $this->calculateBaselineCost($applianceId, $duration);
        $savings = $baselineCost - $estimatedCost;

        $schedule->appliances()->attach($applianceId, [
            'duration_minutes' => $duration,
            'estimated_cost' => $estimatedCost,
            'cost_saved' => $savings,
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'power_consumed' => $energyUsed,
        ]);
    }

    return redirect()->route('schedule.index')->with('success', 'Schedule created successfully!');
}



// Helper function to get a random Carbon time between two Carbon instances
private function randomTimeBetween(Carbon $start, Carbon $end): Carbon
{
    $startMinutes = $start->diffInMinutes(Carbon::createFromTime(0, 0), false) * -1;
    $endMinutes = $end->diffInMinutes(Carbon::createFromTime(0, 0), false) * -1;

    $randomMinute = rand($startMinutes, $endMinutes);

    return Carbon::createFromTime(0, 0)->addMinutes($randomMinute);
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
protected function deactivateOtherSchedules($userId)
{
    $query = Schedule::where('user_id', $userId)->where('is_active', 1);

    $query->update(['is_active' => 0]);
}

private function getCostPerHour(Carbon $time)
{
    $slot = DB::table('timeslot_costs')
        ->where('start_time', '<=', $time->format('H:i:s'))
        ->where('end_time', '>', $time->format('H:i:s'))
        ->first();

    return $slot ? (float) $slot->cost_per_kwh : 0.2; // fallback default
}


private function calculateEstimatedCost($applianceId, $durationMinutes, Carbon $startTime)
{
    // Get the appliance
    $appliance = Appliances::findOrFail($applianceId);
    $powerConsumedWatts = $appliance->power_consumption;
    $powerConsumedKWh = $powerConsumedWatts / 1000;
    $durationHours = $durationMinutes / 60;
    $energyUsed = $powerConsumedKWh * $durationHours;

    // Get cost from timeslot
    $slotCost = DB::table('timeslot_costs')
        ->where('start_time', '<=', $startTime->format('H:i:s'))
        ->where('end_time', '>', $startTime->format('H:i:s'))
        ->value('cost_per_kwh');

    $costPerKwh = $slotCost ?? 0.2; // fallback default
    $estimatedCost = round($energyUsed * $costPerKwh, 2);

    return [
        'energy_used_kwh' => $energyUsed,
        'estimated_cost' => $estimatedCost,
    ];
}

private function findCheapestTimeSlot(Carbon $scheduleStart, Carbon $scheduleEnd, int $durationMinutes)
{
    $allSlots = DB::table('timeslot_costs')->orderBy('cost_per_kwh')->get();
    foreach ($allSlots as $slot) {
        $slotStart = Carbon::createFromFormat('H:i:s', $slot->start_time);
        $slotEnd = Carbon::createFromFormat('H:i:s', $slot->end_time);

        // Check if slot is within the user's schedule range
        if ($slotStart->between($scheduleStart, $scheduleEnd) &&
            $slotEnd->diffInMinutes($slotStart) >= $durationMinutes) {
            return $slotStart;
        }
    }

    // Fallback to a random time if no slot fits
    return $this->randomTimeBetween($scheduleStart, $scheduleEnd->copy()->subMinutes($durationMinutes));
}

private function calculateBaselineCost($applianceId, $durationMinutes)
{
    $appliance = Appliances::findOrFail($applianceId);
    $powerConsumedWatts = $appliance->power_consumption;
    $powerConsumedKWh = $powerConsumedWatts / 1000;
    $durationHours = $durationMinutes / 60;
    $energyUsed = $powerConsumedKWh * $durationHours;

    $flatRate = 0.20; // assumed average cost

    return round($energyUsed * $flatRate, 2);
}
public function getTotalCostSaved($userId)
{
    $total = ApplianceSchedule::whereHas('schedule', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })->sum('cost_saved');

    return $total;
}
}

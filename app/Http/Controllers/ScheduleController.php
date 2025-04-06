<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appliances;
use App\Models\ApplianceSchedule;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Services\ScheduleOptimizer;

class ScheduleController extends Controller
{
    public function index()
{
    //This displays the appliances on the active schedule
    $data = ApplianceSchedule::whereHas('schedule', function ($query) {
        $query->where('is_active', 1)
              ->where('user_id', 1); // change this to auth()->id() later
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
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'appliances' => 'required|array',
            'appliances.*' => 'exists:appliances,id',
            'is_active' => 'nullable|boolean',
        ]);
    
        $isActive = $request->has('is_active') ? 1 : 0;
        $userId = 1; // Replace with auth()->id() when ready
    
        // Step 1: Run optimization
        $optimizer = new ScheduleOptimizer();
        $schedule = $optimizer->optimize($validated['appliances'], $userId);
    
        // Step 2: Update schedule metadata
        $schedule->name = $request->input('name');
        $schedule->user_id = $userId;
        // $schedule->description = $request->input('desc');
        $schedule->is_active = $isActive;
        $schedule->save();
    
        return redirect()->back()->with('success', 'Schedule optimized and saved!');
    }
    
    
    
}

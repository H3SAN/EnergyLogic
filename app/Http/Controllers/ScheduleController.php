<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appliances;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {   
        $data = Appliances::all();
        $schedules = Schedule::all();
        
        return view('schedule.index', [
            'appliances' => $data,
            'schedule' => $schedules
        ]);
        
    }
    public function addSchedule(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'appliances' => 'required|array',
            'appliances.*' => 'exists:appliances,id',
            'is_active' => 'nullable|boolean',
        ]);

        $isActive = $request->has('is_active') ? 1 : 0;
        
        $schedule = new Schedule();
        $schedule->name = $request->input('name');
        $schedule->user_id = 1;
        $schedule->description = $request->input('desc');
        $schedule->is_active = $isActive;
        $schedule->save();
            // Attach appliances to the schedule
        $schedule->appliances()->attach($validated['appliances']);
    
        return redirect()->back()->with('success', 'Schedule created successfully!');
    }
}

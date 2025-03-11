<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appliances;

class ApplianceController extends Controller
{
    public function appliances()
    {
        $data = Appliances::all();

        return view('appliances.apptable', compact('data'));
    }

    public function appliancedetail()
    {
        return view('appliances.appdetails');
    }

    public function add_appliance(Request $request)
{
    // Validate incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'power_rating_watts' => 'required|numeric|min:1',
        'status' => 'required|in:on,off,standby',
        'schedule_time' => 'nullable|date_format:H:i:s',
        'daily_usage_hours' => 'required|numeric|min:0|max:24',
        'energy_efficiency_rating' => 'required|in:A++,A+,A,B,C,D,E',
    ]);

    // Create and save the appliance
    $appliance = new Appliances();
    $appliance->name = $request->name;
    $appliance->power_rating_watts = $request->power_rating_watts;
    $appliance->status = $request->status;
    $appliance->schedule_time = $request->schedule_time ?? null;
    $appliance->daily_usage_hours = $request->daily_usage_hours;
    $appliance->energy_efficiency_rating = $request->energy_efficiency_rating;
    $appliance->save();

    return redirect()->back()->with('success', 'Appliance added successfully!');
}

}

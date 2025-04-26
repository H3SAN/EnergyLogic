<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appliances;
use App\Models\UsageRecord;

class ApplianceController extends Controller
{
    public function index()
    {
        $data = Appliances::all();

        return view('appliances.apptable', compact('data'));
    }

    public function view($id)
{
    // Search for the record by ID
    $appliance = Appliances::findOrFail($id); // This throws a 404 if not found

    // Pass the appliance data to a view
    return view('appliances.appdetails', ['appliance' => $appliance]);
}

    public function add(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'power_consumption' => 'required|numeric|min:1',
            'status' => 'required|in:on,off,standby',
            'schedule_time' => 'nullable|date_format:H:i:s',
            'daily_usage_hours' => 'required|numeric|min:0|max:24',
            'energy_efficiency_rating' => 'required|in:A++,A+,A,B,C,D,E',
        ]);

        // Create and save the appliance
        $appliance = new Appliances();
        $appliance->name = $request->name;
        $appliance->power_consumption = $request->power_consumption;
        $appliance->status = $request->status;
        $appliance->schedule_time = $request->schedule_time ?? null;
        $appliance->daily_usage_hours = $request->daily_usage_hours;
        $appliance->energy_efficiency_rating = $request->energy_efficiency_rating;
        $appliance->save();

        toastr()->closeButton()->timeOut(5000)->addSuccess('Appliance added successfully!');

        return redirect()->back();
    }

    public function delete($id)
    {
         // Delete all usage records linked to this appliance first
        UsageRecord::where('schedule_id', $id)->delete();

        $appliance = Appliances::find($id); // Find the appliance by ID
        $appliance->delete(); // Delete it
        $appliance?->delete(); // Just in case it's already null
        return redirect()->back()->with('success', 'Appliance deleted successfully!');
    }
}

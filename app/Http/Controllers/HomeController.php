<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Appliances;
use App\Models\UsageRecord;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function home()
    {
        $user = Auth::user();
        return view('home.index', compact('user'));
    }

    // Cost analysis functions
    public function costanalysis(Request $request)
    {
        $query = UsageRecord::with('appliance'); // load appliance names

        // Check if start_date and end_date are provided and filter accordingly
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Get totals within the filtered range
        $totalPower = $query->sum('power_consumed');
        $totalCost = $query->sum('cost');

        // Group by appliance and sum power_consumed & cost
        $usage = $query->selectRaw('appliance_id, SUM(power_consumed) as total_power, SUM(cost) as total_cost, SUM(time_used) as used_time')
            ->groupBy('appliance_id')
            ->with('appliance')
            ->get();

        // Get the appliance with the highest cost
        $highestCost = $usage->sortByDesc('total_cost')->first();
        // Get the appliance with the Most power
        $highestPower = $usage->sortByDesc('total_power')->first();

        //dd($request->all());
        return view('home.costanalysis', [
            'usage' => $usage,
            'totalPower' => $totalPower,
            'totalCost' => $totalCost,
            'highestCost' => $highestCost,
            'highestPower' => $highestPower
        ]);
    }
}

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
    public function costanalysis(Request $request){
        $Power = UsageRecord::sum('power_consumed'); //returns the total power consumed
        $totalCost = $Power * 0.15; //assuming cost per

        dd($request -> all());
        return view('home.costanalysis', [
            'totalPowerConsumed' => $Power,
            'totalCost' => $totalCost
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplianceController extends Controller
{
    public function appliances()
    {
        return view('appliances.apptable');
    }

    public function appliancedetail()
    {
        return view('appliances.appdetails');
    }
}

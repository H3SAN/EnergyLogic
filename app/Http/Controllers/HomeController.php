<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.index');
        
    }
    public function home()
    {
        $user =Auth::user();
        return view('home.index', compact('user'));
    }

    public function costanalysis(){
        return view('home.costanalysis');
    }
}

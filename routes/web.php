<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApplianceController;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Middleware;

Route::get('/', [HomeController::class,'home']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// Route for the admin page
route::get('admin/dashboard', [HomeController::class,'index'])->middleware(['auth','admin']);
// Routes for the Appliance pages
Route::get('/appliances', [ApplianceController::class,'appliances']);
Route::get('/appliancedetail', [ApplianceController::class,'appliancedetail']);
Route::post('/add-appliance', [ApplianceController::class, 'add_appliance']);


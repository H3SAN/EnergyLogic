<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApplianceController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Middleware;

Route::middleware(['auth'])->group(function () {
Route::get('/', [HomeController::class,'home']);
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// Route for the admin page
route::get('admin/dashboard', [HomeController::class,'index'])->middleware(['auth','admin']); // Link to the admin page

// Routes for the Appliance pages
Route::middleware(['auth'])->group(function () {
    Route::prefix('appliances')->group(function () {
        Route::get('/', [ApplianceController::class, 'index'])->name('appliances.index'); // List all appliances
        Route::get('/view', [ApplianceController::class, 'show'])->name('appliances.show'); // View appliance details
        Route::post('/add', [ApplianceController::class, 'add'])->name('appliances.add'); // Add appliance
        Route::get('/delete/{id}', [ApplianceController::class, 'delete'])->name('appliances.delete'); // Delete appliance
    });
});

// Routes for the cost analysis
Route::get('/cost-analysis', [HomeController::class,'costanalysis']);

// Routes for the schedule pages
Route::prefix('schedule')->group(function () {
    Route::get('/', [ScheduleController::class, 'index'])->name('schedule.index'); // route to schedule page
    Route::post('/add', [ScheduleController::class, 'addSchedule'])->name('schedule.add'); // add Schedule
    Route::get('/delete/{id}', [ScheduleController::class, 'delete'])->name('schedule.delete'); // add Schedule
    Route::get('/setActive/{id}', [ScheduleController::class, 'setActive'])->name('schedule.setActive'); // add Schedule
});
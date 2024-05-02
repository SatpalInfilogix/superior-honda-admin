<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::resources([
        'dashboard' => DashboardController::class,
        'profile' => ProfileController::class
    ]);
});

Route::get('/', function (){
    return redirect()->route('dashboard.index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

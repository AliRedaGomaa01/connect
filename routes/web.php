<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('lang')->group(function () {

    require __DIR__.'/auth.php';

    Route::get('/', function () {
        return view('zz-unused.coming-soon');
    })->name('landing');

    Route::get('/r', function () {
        return view('zz-unused.all-routes');
    })->name('routes');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware('auth')->prefix('portfolio')->name('portfolio.')->group(function () {
            Route::resource('work', WorkController::class);
            Route::resource('user', UserController::class)->only(['index','show']);
    });
});
    
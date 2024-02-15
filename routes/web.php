<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
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
    // Testing
    Route::get('/t', function () {

    })->name('test');

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

    Route::middleware('auth')->prefix('portfolio')->group(function () {
        # works
        // Route::controller(WorkController::class)->group(function () {
        //     Route::get('users/{user}/works', 'userWorks')->name('users.works');
        // });
        Route::resource('works', WorkController::class);
        # images
        // Route::controller(ImageController::class)->group(function () {});
        Route::resource('images', ImageController::class)->only('create','store','destroy');
        # users
        Route::controller(UserController::class)->group(function () {
            Route::get('users/search', 'search')->name('users.search');
            Route::post('users/search-result', 'searchResult')->name('users.search.result');
        });
        Route::resource('users', UserController::class);
    });
});
    
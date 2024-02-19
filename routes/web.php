<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use App\Models\Follow;
use App\Models\Work;
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
    /* Testing */
    // Route::get('/t', function () {

    // })->name('test');
    // ****************************************************************************
    // Route::get('/test', [UserController::class, 'index'])->name('test');
    // ****************************************************************************
    /* Show main routes*/
    // Route::get('/r', function () {
    //     return view('zz-unused.all-routes');
    // })->name('routes');
    // ****************************************************************************
    // Route::get('/', function () {
    //     return view('zz-unused.coming-soon');
    // })->name('landing');
    // ****************************************************************************
    Route::view('/', 'landing')->name('landing');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware('auth')->prefix('portfolio')->group(function () {
        # users
        Route::get('users/{id}/images',[ImageController::class, 'index'])->name('users.images');
        Route::get('users/{id}/works',[WorkController::class, 'index'])->name('users.works');
        Route::get('users/{id}/followers/{status?}',[UserController::class, 'index'])->name('follows');  // status ['following' , 'followed']
        Route::controller(UserController::class)->group(function () {
            Route::get('users/search', 'search')->name('users.search');
            Route::post('users/search-result', 'searchResult')->name('users.search.result');
        });
        Route::resource('users', UserController::class);
        # works
        // Route::controller(WorkController::class)->group(function () {
        //     Route::get('users/{user:id}/works', 'userWorks')->name('users.works');
        // });
        Route::resource('works', WorkController::class);
        # images
        // Route::controller(ImageController::class)->group(function () {});
        Route::resource('images', ImageController::class);
        # follows
        Route::post('follows', FollowController::class)->name('follows');
        Route::post('likes', LikeController::class)->name('likes');
    });
});
    
<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WorkController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('/test', function () {  })->name('test');

Route::name('api.v1.')->middleware('lang')->prefix('v1')->group( function () {

    Route::get('/test-locale', function () {
        return response()->json(__('Updated Successfully'));
    })->name('test.locale');
    
    # Auth
        Route::group([ 'middleware' => 'guest'], function () {
            
            Route::controller(AuthenticationController::class)->group( function () {
                Route::post('/register', 'register')->name('register');
                Route::post('/login', 'login')->name('login');
                Route::post('/logout', 'logout')->withoutMiddleware('guest')->middleware('auth:sanctum')->name('logout');
            });
            Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');
            // reset password will be via the web 
        });
        
        Route::group([ 'middleware' => 'auth:sanctum'], function () {

            Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware(['throttle:6,1',''])
            ->name('verification.send');
            // verify email will be via the web 
            Route::put('password', [PasswordController::class, 'update'])->name('password.update');
        
        });
    #  End of auth

    Route::group([ 'middleware' => 'auth:sanctum'], function () {
        # start of profile edit
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        # end of profile edit


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
        Route::resource('works', WorkController::class);
        # images
        Route::resource('images', ImageController::class);
        # follows
        Route::post('follows', FollowController::class)->name('follows');
        # likes
        Route::post('likes', LikeController::class)->name('likes');
    });
    // end of prefix api/v1 
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Traits\MultiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    use MultiResponse;
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->multiResponse(response()->json(['status' => 'Email is verified']) ,redirect()->intended(RouteServiceProvider::HOME)) ;
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->multiResponse(response()->json(['status' => 'verification-link-sent']) ,back()->with('status', 'verification-link-sent')) ;
    }
}
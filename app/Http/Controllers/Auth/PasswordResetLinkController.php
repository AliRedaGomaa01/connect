<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\MultiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    use MultiResponse;
    /**
     * Display the password reset link request view.
     */
    public function create()
    {
        return $this->multiResponse( response()->json(['status' => session('status')]) , view('auth.forgot-password') );
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? ($this->multiResponse( response()->json(['status' => __($status)]) , back()->with('status', __($status))) )
                    : ($this->multiResponse( response()->json(['email' => __($status)]) , back()->withInput($request->only('email'))->withErrors(['email' => __($status)]))) ;
    }
}
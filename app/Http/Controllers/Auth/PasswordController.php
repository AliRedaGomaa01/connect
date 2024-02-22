<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\MultiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{

    use MultiResponse;
    /**
     * Update the user's password.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        if ($validator->fails()) {
            $errors =  $validator->errors();
            $data= [
                'status' => false,
                'errors' => $errors
            ];
            return $this->multiResponse( response()->json($data) , redirect()->back()->withInput()->withErrors($errors, 'updatePassword') ) ;
        }
        $validated = $validator->safe()->only('password');
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        return $this->multiResponse( response()->json(['status' => 'password-updated']) , back()->with('status', 'password-updated') ) ;
    }
}
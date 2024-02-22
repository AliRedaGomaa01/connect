<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthenticationController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'password' => ['required','string','max:255','confirmed',Password::min(8)],
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                throw new \Exception($errors);
            } else {
                $validated = $validator->safe()->all();
                $validated['password'] = bcrypt($validated['password']);
                DB::beginTransaction();
                $user = User::create($validated);
                DB::commit();
                event(new Registered($user));
                $token = $user->createToken('authToken of '.$user->name)->plainTextToken;
                $data = [
                    'status' => true,
                    'token' => $token,
                    'user'=> $user,
                ];
            }
        } catch(\Exception $e){
            $data = [
                'status' => false,
                'message' => $e?->getMessage() ?? 'BE error',
            ];
        }
        return response()->json($data, 200);
    }
    /**
     * check if the user exists in database
     */
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
            'email' => ['required','string','max:255'],
            'password' => ['required','string','max:255'],
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                throw new \Exception($errors);
            } else {
                $validated = $validator->safe()->all();
                User::where('email', $validated['email'])->count() == 0 ? throw new \Exception('Invalid credentials') : $user = User::where('email', $validated['email'])->first();
                !Hash::check($validated['password'], $user->password) ? throw new \Exception('Invalid credentials') : null;
                $user->tokens()?->delete();
                $token = $user->createToken('authToken of '.$user->name)->plainTextToken;
                $data = [
                    'status' => true,
                    'token' => $token,
                    'user'=> $user,
                ];
            }
        } catch(\Exception $e){
            $data = [
                'status' => false,
                'message' => $e?->getMessage() ?? 'BE error',
            ];
        }
        return response()->json($data, 200);
    }
    /**
     * logout the user
     */
    public function logout(Request $request)
    {
        try{
            $request->user()->tokens()?->delete();
            $data = [
                'status' => true,
                'message' => 'Done Successfully',
            ];
        } catch(\Exception $e){
            $data = [
                'status' => false,
                'message' => $e?->getMessage() ?? 'BE error',
            ];
        }
        return response()->json($data, 200);
    }
}
<?php
namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request) : JsonResponse
    {
        return  response()->json(['user' => $request->user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($request->user()->id)],
            'bio' => ['nullable', 'string', 'max:1023'],
            'cv_link' => ['nullable', 'url:http,https' , 'max:255'],
        ]);
        if ($validator->fails()) {
            $errors =  $validator->errors();
            $data= [
                'status' => false,
                'errors' => $errors
            ];
            return response()->json($data) ;
        }
        $validated = $validator->safe()->all();
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        return response()->json(['status' => __('profile-updated')]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'current_password'],
        ]);
        if ($validator->fails()) {
            $errors =  $validator->errors();
            $data= [
                'status' => false,
                'errors' => $errors
            ];
            return response()->json($data) ;
        }
        $validated = $validator->safe()->all();
        $user = $request->user();
        $user->tokens()?->delete();
        $user->delete();
        $data= [
            'status' => true,
            'message' => __('Deleted Successfully')
        ];
        return response()->json($data);
    }
}
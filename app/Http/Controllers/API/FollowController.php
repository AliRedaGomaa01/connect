<?php

namespace App\Http\Controllers\Api;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FollowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) : JsonResponse
    {
        // making following and unfollowing actions
        // then returns following status 
        $validator = Validator::make($request->all(), [
            "followed_id" => ['required' , 'numeric' , 'min:1' ,'exists:users,id'],
            "following_id" => ['required' , 'numeric' , 'min:1' ,'exists:users,id'],
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
        if (auth()->user()->followStatus($validated['followed_id']) == 'unfollowing') {
            // return response()->json($validated);
            DB::beginTransaction();
            $follow = new Follow();
            $follow->followed_id = $validated['followed_id'];
            $follow->following_id = $validated['following_id'];
            $follow->save();
            DB::commit();
            return response()->json(auth()->user()->followStatus($validated['followed_id']));
        };
        if (auth()->user()->followStatus($validated['followed_id']) == 'following') {
            Follow::where('followed_id', $validated['followed_id'])->where('following_id', $validated['following_id'])?->delete();
            return response()->json(auth()->user()->followStatus($validated['followed_id']));
        }
    }
}
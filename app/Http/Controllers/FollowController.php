<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // making following and unfollowing actions
        // then returns following status 
        $validated = $request->validate([
            "followed_id" => ['required' , 'numeric' , 'min:1' ,'exists:users,id'],
            "following_id" => ['required' , 'numeric' , 'min:1' ,'exists:users,id'],
        ]);
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

        // // Show follows count 
        // $userIds = User::pluck('id')->toArray();
        // if (  in_array($id , $userIds) && $status == 'following') {
        //     $user = User::find($id);
        //     return response()->json($user->following()->count());
        // } elseif ( in_array($id , $userIds) && $status == 'followed') {
        //     $user = User::find($id);
        //     return response()->json($user->following()->count());
        // } else {
        //     return abort(404);
        // }
    }
  
}
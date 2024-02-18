<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Follow $follow)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow $follow)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follow $follow)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return abort(404);
    }
}
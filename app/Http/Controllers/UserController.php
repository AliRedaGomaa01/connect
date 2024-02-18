<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Searching for a user or for users
     */
    public function search(Request $request)
    {
        $searchable = User::pluck('name','email')->toArray();
        return view('portfolio.users.search', compact('searchable'));
    } 
        /**
     * Searching for a user or for users
     */
    public function searchResult(Request $request)
    {
        if ($request->has('email')) {
            $validated =  $request->validate(['email' => 'required|string|email|min:3|max:255']);
            $q = User::where('email',$validated['email']);
            if ($q->exists()) {
                $user = $q->first();
                $link = route('users.show',$user->id);
                return response()->json([
                    'link' => $link,
                    'name' => $user->name,
                    'email' => $user->email,
                ],200);
            } 
        } 
    }
    /**
     * Display a listing of the resource.
     */
    public function index( $id = 'notset' , ?string $status = 'notset' )
    {
        $perPage = 15;
        $ids = User::pluck('id')->toArray();
        if ($id == 'notset' && !in_array($id, $ids)) {
            $id = auth()->id();
        }  
        $user = User::find($id);
        if ($status == 'following') {
            $users = $user->following()?->paginate($perPage)?->toArray();
        } else if ($status == 'followed') {
            $users = $user->followedBy()?->paginate($perPage)?->toArray();
        } else {
            $users = User::paginate($perPage)?->toArray();
        }
        return view('portfolio.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(?string $id='notset')
    {
        if ($id=='notset'){
            $id = auth()->id();
        }
        $user = User::find($id);
        $followStatus = auth()->user()->followStatus($user->id);
        return view('portfolio.users.show', compact('user','followStatus'));
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
        return abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return abort(404);
    }

}
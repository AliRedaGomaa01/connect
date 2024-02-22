<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Searching for a user or for users
     */
    public function search(Request $request)
    {
        $searchable = User::pluck('name','email')->toArray();
        $data= [
            'status' => true,
            'data' => ['searching-list' => $searchable]
        ];
        return response()->json($data);
    } 
        /**
     * Searching for a user or for users
     */
    public function searchResult(Request $request)
    {
        $validator = Validator::make($request->all(), 
            ['email' => 'required|string|email|min:3|max:255']
        );
        if ($validator->fails()) {
            $errors =  $validator->errors();
            $data= [
                'status' => false,
                'errors' => $errors
            ];
            return response()->json($data) ;
        }
        $validated = $validator->safe()->all();
        $q = User::where('email',$validated['email']);
        if ($q->exists()) {
            $user = $q->first();
            $link = route('api.v1.users.show',$user->id);
            $data= [
                'status' => true,
                'data' => [
                    'link' => $link,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ];
            return response()->json($data);
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
        $data= [
            'status' => true,
            'data' => compact('users')
        ];
        return response()->json($data);
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
        $followingCount = $user->following()->count();
        $followedByCount = $user->followedBy()->count();
        // return response
        $data= [
            'status' => true,
            'data' => compact('user','followStatus' , 'followingCount' , 'followedByCount' )
        ];
        return response()->json($data);
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
<?php

namespace App\Http\Controllers\Api;

use App\Enums\WorkTypesEnum;
use App\Models\Work;
use App\Http\Requests\WorkRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        $perPage = 15;
        $id = $request->id ?? null ;
        if ($id == null) {
            $user = auth()->user();
            $followingIds = $user->following?->pluck('id')?->toArray();
            $works = collect(Work::whereIn('user_id', $followingIds)->orderBy('id', 'desc')?->paginate($perPage))?->toArray();
            // return response
            $data= [
                'status' => true,
                'data' => compact('works','user') 
            ];
            return response()->json($data);
        } else {
            $userIds = User::pluck('id')->toArray();
            if (in_array($id,$userIds)) {
                $user = User::find($id);
                $works = collect($user->works()->orderBy('id', 'desc')->paginate($perPage))->toArray();
                $data= [
                    'status' => true,
                    'data' => compact('works','user') 
                ];
                return response()->json($data);
            } else {
                return abort(404);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $workTypes = WorkTypesEnum::toArray(); 
        $data= [
            'status' => true,
            'data' => compact('workTypes')
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'category' => ['required','string','max:255'],
            'title' => ['required','string','max:255'],
            'description' => ['required','string','max:2047'],
            'url' => ['required','string', 'url:http,https' ,'max:255'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors =  $validator->errors();
            $data= [
                'status' => false,
                'errors' => $errors
            ];
            return response()->json($data) ;
        }
        $validated = $validator->safe()->all();
        auth()->user()->works()->create($validated);
        $data= [
            'status' => true,
            'message' =>  __('Stored Successfully')
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Work $work)
    {
        $likesCount = $work->likes()->count();
        $likeStatus = $work->likes()->where('user_id', auth()->id())->count() > 0 ? 'liked' : 'notLiked' ;
        $work = $work->toArray();
        $work['likesCount'] = $likesCount;
        $work['likeStatus'] = $likeStatus;
        // return response
        $data= [
            'status' => true,
            'data' => compact('work')
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Work $work)
    {
        $workTypes = WorkTypesEnum::toArray(); 
        // return response
        $data= [
            'status' => true,
            'data' => compact('work','workTypes')
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Work $work)
    {
        $rules = [
            'category' => ['required','string','max:255'],
            'title' => ['required','string','max:255'],
            'description' => ['required','string','max:2047'],
            'url' => ['required','string', 'url:http,https' ,'max:255'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors =  $validator->errors();
            $data= [
                'status' => false,
                'errors' => $errors
            ];
            return response()->json($data) ;
        }
        $validated = $validator->safe()->all();
        $work->update($validated);
        // return response
        $data= [
            'status' => true,
            'data' =>  __("Updated Successfully")
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work)
    {
        $work->delete();
        // return response
        $data= [
            'status' => true,
            'data' => __("Deleted Successfully")
        ];
        return response()->json($data);
    }
}
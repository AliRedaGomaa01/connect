<?php

namespace App\Http\Controllers;

use App\Enums\WorkTypesEnum;
use App\Models\Work;
use App\Http\Requests\WorkRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
            return view('portfolio.works.index', compact('works','user'));

        } else {
            $userIds = User::pluck('id')->toArray();
            if (in_array($id,$userIds)) {
                $user = User::find($id);
                $works = collect($user->works()->orderBy('id', 'desc')->paginate($perPage))->toArray();
                return view('portfolio.works.index', compact('works','user'));
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
        return view('portfolio.works.create',compact('workTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkRequest $request)
    {
        $validated = $request->validated();
        auth()->user()->works()->create($validated);
        return redirect()->route('works.index',['id' => auth()->id()])->with('success', __("Stored Successfully"));
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
        return view('portfolio.works.show', compact('work'));   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Work $work)
    {
        if ( auth()->user()->can('isOwner', $work->user_id) == false ) {
            return abort(403);
        }
        $workTypes = WorkTypesEnum::toArray(); 
        return view('portfolio.works.edit', compact('work','workTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkRequest $request, Work $work)
    {
        if ( auth()->user()->can('isOwner', $work->user_id) == false ) {
            return abort(403);
        }
        $validated = $request->validated();
        $work->update($validated);
        return redirect()->route('works.index',['id' => auth()->id()])->with('success', __("Updated Successfully"));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work)
    {
        if ( auth()->user()->can('isOwner', $work->user_id) == false ) {
            return abort(403);
        }
        $work->delete();
        return redirect()->route('works.index',['id' => auth()->id()])->with('success', __("Deleted Successfully"));
    }
}
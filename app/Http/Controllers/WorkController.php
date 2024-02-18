<?php

namespace App\Http\Controllers;

use App\Enums\WorkTypesEnum;
use App\Models\Work;
use App\Http\Requests\WorkRequest;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(?User $user=null)
    {
        $perPage = 15;
        if ($user == null) {
            $user = auth()->user();
            $followingIds = $user->following?->pluck('id')?->toArray();
            $works = collect(Work::whereIn('user_id', $followingIds)->orderBy('id', 'desc')?->paginate($perPage))?->toArray();
            return view('portfolio.works.index', compact('works','user'));
        } else {
            $works = collect($user->works()->orderBy('id', 'desc')->paginate($perPage))->toArray();
            return view('portfolio.works.index', compact('works','user'));
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
        return redirect()->route('works.index')->with('success', __('Stored Successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Work $work)
    {
        $work = $work->load('user')->toArray();
        return view('portfolio.works.show', compact('work'));   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Work $work)
    {
        $workTypes = WorkTypesEnum::toArray(); 
        return view('portfolio.works.edit', compact('work','workTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkRequest $request, Work $work)
    {
        $validated = $request->validated();
        $work->update($validated);
        return redirect()->route('works.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work)
    {
        $work->delete();
        return redirect()->route('works.index')->with('success', __('Deleted Successfully'));
    }
}
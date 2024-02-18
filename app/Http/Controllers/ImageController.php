<?php

namespace App\Http\Controllers;

use App\Models\Image ;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
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
            $images = collect(Image::whereIn('user_id', $followingIds)->orderBy('id', 'desc')?->paginate($perPage))?->toArray();
            return view('portfolio.images.index', compact('images','user'));

        } else {
            $images = collect($user->images()->orderBy('id', 'desc')->paginate($perPage))->toArray();
            return view('portfolio.images.index', compact('images','user'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portfolio.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => [ 'required' , 'image' , 'extensions:jpg,png,jpeg' , 'mimes:jpeg,png,jpg' , 'max:10240'] ,
        ]);
        ImageService::save($request);
        return redirect()->back()->with('success', __("Stored Successfully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(image $image)
    {
        return response()->file('storage/' . $image->path);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(image $image)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, image $image)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(image $image)
    {
        ImageService::delete($image->path);
        $image->delete();
        return redirect()->back()->with('success', __("Deleted Successfully"));
    }
}
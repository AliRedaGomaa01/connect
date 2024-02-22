<?php
namespace App\Http\Controllers\Api;


use App\Models\Image ;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
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
            $images = collect(Image::whereIn('user_id', $followingIds)->orderBy('id', 'desc')?->paginate($perPage))?->toArray();
            return response()->json(compact('images','user'));
        } else {
            $userIds = User::pluck('id')->toArray();
            if (in_array($id,$userIds)) {
                $user = User::find($id);
                $images = collect($user->images()->orderBy('id', 'desc')->paginate($perPage))->toArray();
                return response()->json(compact('images','user'));
            } else {
                return response()->json(['status'=>false], 404);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required' , 'image' , 'extensions:jpg,png,jpeg' , 'mimes:jpeg,png,jpg' , 'max:10240'] ,
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
        ImageService::save($request);
        $data= [
            'status' => true,
            'message' => __('Stored Successfully')
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(image $image)
    {
        $likesCount = $image->likes()->count();
        $likeStatus = $image->likes()->where('user_id', auth()->id())->count() > 0 ? 'liked' : 'notLiked' ;
        $image = $image->toArray();
        $image['likesCount'] = $likesCount;
        $image['likeStatus'] = $likeStatus;
        $data= [
            'status' => true,
            'data' => compact('image')
        ];
        return response()->json($data);
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
        ImageService::delete($image->path ?? 'not_set');
        $image->delete();
        $data= [
            'status' => true,
            'message' => __('Deleted Successfully')
        ];
        return response()->json($data);
    }
}
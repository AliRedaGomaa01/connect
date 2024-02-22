<?php
namespace App\Http\Controllers\Api;


use App\Models\Image;
use App\Models\Like;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    /**
     * Handle the incoming request.
     * Making like and dislike actions.
     * Then returns likes count & like status.
     */
    public function __invoke(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "user_id" => ['required' , 'numeric' , 'min:1' ,'exists:users,id'],
            "likeable_id" => ['required' , 'numeric' , 'min:1'],
            "likeable_type" => ['required' , 'string' , 'in:Image,Work'],
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
        if ($validated['likeable_type'] == "Work") {
            $likeable = Work::find($validated['likeable_id']);
        } else if ($validated['likeable_type'] == "Image") {
            $likeable = Image::find($validated['likeable_id']);
        }
        // show like status
        $status = $likeable->likes()->where('user_id', $validated['user_id'])?->count() > 0 ? 'liked' : 'notLiked' ;
        // do actions
        if ($status == 'notLiked') {
            DB::beginTransaction();
            $like = $likeable->likes()->create([
                'user_id' => $validated['user_id'],
            ]);
            DB::commit();
        } else if ($status == 'liked') {
            $likeable->likes()->where('user_id', $validated['user_id'])?->delete();
        }
        // returns new status 
        $status = $likeable->likes()->where('user_id', $validated['user_id'])?->count() > 0 ? 'liked' : 'notLiked' ;
        $count = $likeable->likes()->count();
        $data = compact('status','count');
        $data= [
            'status' => true,
            'data' => $data 
        ];
        return response()->json($data,200);
    }
}
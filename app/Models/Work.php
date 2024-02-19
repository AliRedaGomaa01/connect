<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    # Relations 
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable' , 'likeable_type', 'likeable_id');
    }

    // /**
    //  * if a work is liked.
    // */
    // public function isLiked($id = null)
    // {
    //     if ($id) {
    //         return $this->likes()->where('user_id', $id)->count() > 0 ? 'liked' : 'notLiked' ;
    //     }
    // }
}
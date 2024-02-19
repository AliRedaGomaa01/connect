<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Image extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    # Relations 
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
    // /**
    //  * if an image is liked.
    // */
    // public function isLiked($id = null)
    // {
    //     if ($id) {
    //         return $this->likes()->where('user_id', $id)->count() > 0;
    //     }
    // }
}
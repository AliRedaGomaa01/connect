<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Work extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    # Relations 
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all of the work's likes.
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        "userId", "productId", "rate", "advantages", "disadvantages", "comment"
    ];

    public function user(){
        return $this->belongsTo(User::class, "userId");
    }
    public function image(){
        return $this->hasMany(ReviewImage::class, "reviewId");
    }    
    public function likes(){
        return $this->hasMany(ReviewLike::class, "reviewId");
    }
    public function dislikes(){
        return $this->hasMany(ReviewDislike::class, "reviewId");
    }
}

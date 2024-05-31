<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ["userId", "productId", "count", "quantity", "price"];

    public function users(){
        return $this->belongsTo(User::class, "userId");
    }
    public function products(){
        return $this->belongsTo(Product::class, "productId");
    }
}

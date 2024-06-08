<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ["productId", "postIndex", "quantity", "price", "userId"];

    public function products(){
        return $this->belongsTo(Product::class, "productId");
    }
    public function user(){
        return $this->belongsTo(User::class, "userId");
    }
}

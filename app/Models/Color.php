<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        "image", "color", "productId"
    ];
    public function getSlider(){
        return $this->hasMany(Slider::class, "colorId");
    }
}

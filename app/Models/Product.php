<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "name", "price", "image","percent", "specificationId"
    ];

    public function getSpecification(){
        return $this->hasMany(Specification::class);
    }
    public function getSlider(){
        return $this->hasMany(Slider::class);
    }
    public function getReviews(){
        return $this->hasMany(Review::class);
    }
    public function getCategories(){
        return $this->belongsToMany(Category::class, "product_categories");
    }
    public function getTypeProduct(){
        return $this->belongsToMany(Category::class, "product_categories");
    }
}

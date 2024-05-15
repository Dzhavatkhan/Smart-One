<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "name", "price", "image","percent", "description", "brand"
    ];

    public function getSpecification(){
        return $this->hasMany(Specification::class, "productId");
    }
    public function getSlider(){
        return $this->hasMany(Slider::class, "productId");
    }
    public function getReviews(){
        return $this->hasMany(Review::class);
    }
    public function getColor(){
        return $this->hasMany(Color::class, "productId");
    }
    public function getCategories(){
        return $this->belongsToMany(Category::class, "product_categories", "productId", "categoryId")
                    ->withTimestamps();
    }
    public function getColors(){
        return $this->hasMany(Color::class, "productId");
    }
    public function getTypeProduct(){
        return $this->belongsToMany(TypeProduct::class, "product_categories", "productId", "typeProductId")
                    ->withTimestamps();
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Cart;
use App\Models\Color;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Review;
use App\Models\Specification;
use App\Models\TypeProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $categories = Product::with("getCategories")->findOrFail($this->id);
        $categories = $categories->getCategories[0]->name;

        if (Cart::where("productId", $this->id)->where("userId", Auth::id())->count() != null) {
            $quantityInCart = Cart::where("productId", $this->id)->where("userId", Auth::id())->first()->quantity;
        }
        else{
            $quantityInCart = 0;
        }

        $reviews = ReviewResource::collection(Review::with("user","image", "likes", "dislikes")->where("productId", $this->id)->orderBy('reviews.updated_at', 'desc')->get());
        $avg = round(Review::where("productId", $this->id)->avg("rate"), 0);

        $typeProduct = Product::with("getTypeProduct")->findOrFail($this->id);
        $typeProduct = $typeProduct->getTypeProduct[0]->name;

        $slider = Product::with("getSlider")->findOrFail($this->id);
        $slider = $slider->getSlider;


        $specification = Product::with("getSpecification")->findOrFail($this->id);
        $specification = $specification->getSpecification;

        $color = Color::where("productId", $this->id)->first();
        
        if(Favorite::where("productId", $this->id)->where("userId", Auth::id())->count() > 0){
            $isFavorite = true;
        } else{
            $isFavorite = false;
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "brand" => $this->brand,
            "description" => $this->description,
            "percent" => $this->percent,
            "date" => $this->created_at->format("d.m.Y"),
            "color" => $color->color,
            "currentColor" => $color,
            "colors" => $this->getColors,
            "image" => $color->image,
            "categories" => $typeProduct,
            "subcategories" => $categories,
            "price" => number_format($this->price, 0, '.', ' '),
            "slider" => $slider,
            "specification" => $specification,
            "typeProduct" => "$typeProduct/$categories",
            "reviews" => $reviews,
            "avg" => $avg,
            "isFavorite" => $isFavorite,
            "quantityInCart" => $quantityInCart,
            "info" => Auth::id(), 
            "info2" => Favorite::where("productId", $this->id)->where("userId", Auth::id())->count()
        ];
    }
}

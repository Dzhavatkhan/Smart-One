<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $categories = Product::findOrFail($this->id)->getCategories();
        $slider = Product::findOrFail($this->id)->getSlider();
        $reviews = [
            "review" => Product::findOrFail($this->id)->getReviews(),
            //if isMy review (in future)
    ];
        $typeProduct = Product::findOrFail($this->id)->getTypeProduct();

        return [
            "id" => $this->id,
            "productName" => $this->name,
            "categories" => $categories,
            "slider" => $slider,
            "typeProduct" => $typeProduct,
            "reviews" => $reviews
        ];
    }
}

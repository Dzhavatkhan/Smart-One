<?php

namespace App\Http\Resources;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Specification;
use App\Models\TypeProduct;
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
        $categories = Product::with("getCategories")->findOrFail($this->id);
        $categories = $categories->getCategories[0]->name;

        $slider = Product::findOrFail($this->id)->getSlider();
        $reviews = Product::findOrFail($this->id)->getReviews();

        $typeProduct = Product::with("getTypeProduct")->findOrFail($this->id);
        $typeProduct = $typeProduct->getTypeProduct[0]->name;

        $specification = Product::with("getSpecification")->findOrFail($this->id);
        $specification = $specification->getSpecification;



        $color = Color::where("productId", $this->id)->first();

        return [
            "id" => $this->id,
            "name" => $this->name,
            "brand" => $this->brand,
            "description" => $this->description,
            "percent" => $this->percent,
            "date" => $this->created_at->format("d.m.Y"),
            "color" => $color->color,
            "image" => $color->image,
            "categories" => $categories,
            "price" => number_format($this->price, 0, '.', ' '),
            "slider" => $slider,
            "specification" => $specification,
            "typeProduct" => "$typeProduct/$categories",
            "reviews" => $reviews
        ];
    }
}

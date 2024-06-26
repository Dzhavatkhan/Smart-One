<?php

namespace App\Http\Resources;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = ProductResource::collection(Product::where("id", $this->productId)->get());
        return [
            "products" => $products
        ];
    }
}

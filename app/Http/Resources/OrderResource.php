<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = Product::findOrFail($this->productId)->name;
        return [
            "id" => $this->id,
            "postIndex" => $this->postIndex,
            "product" => $product,
            "price" => $this->price,
            "productId" => $this->productId,
            "quantity" => $this->quantity,
            "user" => $this->user,
            "created_at" => $this->created_at->format("d.m.Y")
        ];
    }
}

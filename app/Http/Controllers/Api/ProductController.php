<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        //
    }

    public function addProductToCart($id)
    {
       if (Cart::where("productId", $id)->where("userId", Auth::id()) != null) {
            $quantity = Cart::where("productId", $id)->where("userId", Auth::id())->first()->quantity;
            Cart::where("productId", $id)->where("userId", Auth::id())->update([
                "quantity" => $quantity + 1
            ]);
       }
       else{
            Cart::create([
                "productId" => $id,
                "userId" => Auth::id(),
                "price" => Product::findOrFail($id)->price,
                "quantity" => 1
            ]);
       }
    }

    public function addProductToFavorites($id)
    {
        if (Favorite::where("productId", $id)->where("userId", Auth::id()) != null) {
            Favorite::where("productId", $id)->where("userId", Auth::id())->delete();
            return response()->json([
                "message" => "Товар удален из избранного"
            ]);
        } else {
            Favorite::create([
                "productId" => $id,
                "userId" => Auth::id()
            ]);
            return response()->json([
                "message" => "Товар добавлен в избранное"
            ]);
        }

    }


    public function show(string $id)
    {
        return response()->json([
            "product" => ProductResource::collection(Product::findOrFail($id))
        ]);
    }

    public function writeReview(Request $request, $id){
        try {
            $data = $request->all(["advantages", "disadvantages", "comment", "rate"]);
            Review::create([
                "productId" => $id,
                "userId" => Auth::id(),
                $data
            ]);
            return response()->json([
                "message" => "Отзыв успешно отправлен"
            ]);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error
            ], 500);
        }
    }
    public function updateMyReview(Request $request, $id){
        $data = $request->all(["advantages", "disadvantages", "comment", "rate"]);
        Review::findOrFail($id)->update($data);
    }
    public function deleteMyReview($id){
        Review::findOrFail($id)->delete();
        return response()->json([
            "message" => "Отзыв успешно удален"
        ]);
    }
    public function deleteProductFromCart(string $id)
    {
        Cart::where("productId", $id)->where("userId", Auth::id())->delete();
        return response()->json([
            "message" => "Товар удален из корзины"
        ]);
    }
    public function deleteProductFromFavorite(string $id)
    {
        Favorite::where("productId", $id)->where("userId", Auth::id())->delete();
        return response()->json([
            "message" => "Товар удален из избранного"
        ]);
    }
}

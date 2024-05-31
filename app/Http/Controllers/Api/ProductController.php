<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewDisike;
use App\Models\ReviewImage;
use App\Models\ReviewLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        //
    }

    public function getPopularProducts(){
        $products = Product::join('orders', 'products.id', 'orders.productId')
        ->groupBy('products.id')
        ->orderBy('orders.quantity', 'desc')
        ->get();        
        return response()->json([
            "products" => $products
        ]);
    }

    public function getNewProducts(){
        $products = ProductResource::collection(Product::latest()->simplePaginate(10));        
        return response()->json([
            "products" => $products
        ]);
    }

    public function getCart(){
        $products = ProductResource::collection(Product::leftJoin("carts", "products.id", "carts.productId")->where("carts.userId", Auth::id())->selectRaw("products.*")->get());     
        return response()->json([
            "cart" => $products
        ]);
    }
    public function getFavorite(){
        $products = ProductResource::collection(Product::leftJoin("favorites", "products.id", "favorites.productId")->where("favorites.userId", Auth::id())->selectRaw("products.*")->get());     
        return response()->json([
            "favorites" => $products
        ]);
    }
    public function addProductToCart($id)
    {
       if (Cart::where("productId", $id)->where("userId", Auth::id())->count() != null) {
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
       return response()->json([
            "message" => "Добавлено в корзину!"
       ]);
    }

    public function addProductToFavorite($id)
    {
        if (Favorite::where("productId", $id)->where("userId", Auth::id())->count() != null) {
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
        $product = ProductResource::make(Product::findOrFail($id));
        return response()->json([
            "product" => $product
        ]);
    }

    public function writeReview(ReviewRequest $request, $id){
        try {
            $data = $request->all(["advantages", "reviewImage", "disadvantages", "comment", "rate"]);
            $reviewImageData = [];
            $reviewImages = $request->file('reviewImage');

            $review = Review::create([
                "productId" => $id,
                "userId" => Auth::id(),
                "rate" => $data['rate'],
                "comment" => $data['comment'],
                "advantages" => $data['advantages'],
                "disadvantages" => $data['disadvantages']
            ]);
            foreach ($reviewImages as $reviewImage) {
                $nameImage = $reviewImage->getClientOriginalName();
                $reviewImage->move(public_path("img/products/review"), $nameImage);
                $reviewImageData = [
                    "reviewId" => $review->id,
                    "image" => $nameImage
                ];
                ReviewImage::create($reviewImageData);
            }



            return response()->json([
                "message" => "Отзыв успешно отправлен"
            ]);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error->getMessage()
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
    public function deleteItemFromCart(string $id)
    {
        $product = Cart::where("productId", $id)->where("userId", Auth::id())->first();
        $quantity = $product->quantity - 1;
        $product->update([
            "quantity" => $product->quantity - 1
        ]);
        return response()->json([
            "message" => "Товар удален из корзины"
        ]);
    }
    public function likeReview(string $id)
    {
        if(ReviewDisike::where("reviewId", $id)->where("userId", Auth::id())->count() >=1){
            ReviewDisike::where("reviewId", $id)->where("userId", Auth::id())->delete();
        }
        if(ReviewLike::where("reviewId", $id)->count() > 0){

            if(ReviewLike::where("reviewId", $id)->where("userId", Auth::id())->count() >=1){
                ReviewLike::where("reviewId", $id)->where("userId", Auth::id())->delete();
            }
            else{
                ReviewLike::create([
                    "userId" => Auth::id(),
                    "reviewId" => $id
                ]);
            }
        }
        else{
            ReviewLike::create([
                "userId" => Auth::id(),
                "reviewId" => $id
            ]);
        }

        return response()->json([
            "message" => "Вы поставили реакцию"
        ]);
    }
    public function dislikeReview(string $id)
    {
        if(ReviewLike::where("reviewId", $id)->where("userId", Auth::id())->count() >=1){
            ReviewLike::where("reviewId", $id)->where("userId", Auth::id())->delete();
        }
        if(ReviewDisike::where("reviewId", $id)->count() > 0){

            if(ReviewDisike::where("reviewId", $id)->where("userId", Auth::id())->count() >=1){
                ReviewDisike::where("reviewId", $id)->where("userId", Auth::id())->delete();
            }
            else{
                ReviewDisike::create([
                    "userId" => Auth::id(),
                    "reviewId" => $id
                ]);
            }
        }
        else{
            ReviewDisike::create([
                "userId" => Auth::id(),
                "reviewId" => $id
            ]);
        }
        return response()->json([
            "message" => "Вы поставили реакцию"
        ]);
    }
}

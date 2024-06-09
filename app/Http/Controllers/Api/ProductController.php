<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewDislike;
use App\Models\ReviewImage;
use App\Models\ReviewLike;
use App\Models\TypeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        //
    }

    public function getPopularProducts(){
        $products = ProductResource::collection(Product::leftJoin('carts', 'products.id', '=', 'carts.productId')
        ->selectRaw("products.*")
        ->orderBy('carts.quantity', 'desc')
        ->groupBy("products.id") // Включаем все столбцы из таблицы products в GROUP BY
        ->take(5)
        ->get());
        return response()->json([
            "products" => $products
        ]);
    }
    public function getFilterData($category, $subcategory){
        if($subcategory == null || $subcategory == "null"){
            $products = ProductResource::collection(
                Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                ->where("type_products.name", $category)
                ->selectRaw("products.*")
                ->get()
            );     
        } else{
            $products = ProductResource::collection(
                Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                ->leftJoin("categories", "product_categories.categoryId", "categories.id")                
                ->where("type_products.name", $category)
                ->where("categories.name", $subcategory)
                ->selectRaw("products.*")
                ->get()
            );   
        }
        $brands = Product::leftJoin("product_categories", "products.id", "product_categories.productId")
            ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
            ->where("type_products.name", $category)
            ->pluck("products.brand"); 
        $categories = CategoryResource::collection(TypeProduct::where("name", $category)->get());
        $min = Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                ->where("type_products.name", $category)
                ->min("products.price");
        $max = Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                ->where("type_products.name", $category)
                ->max("products.price");

        return response()->json([
            "products" => $products,
            "categories" => $categories,
            "max" => $max,
            "min" => $min,
            "brands" => $brands
        ]);
    }
    public function filter(Request $request){
        if(!isset($request->subcategory) && !isset($request->brand)){
            $products = ProductResource::collection(
                Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                ->where("type_products.name", $request->category)
                ->whereBetween("price", [$request->min, $request->max])
                ->selectRaw("products.*")
                ->get()
            );     

        } else if(!isset($request->brand)){
            $products = ProductResource::collection(
                Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                ->leftJoin("categories", "product_categories.categoryId", "categories.id")                
                ->where("type_products.name", $request->category)
                ->whereBetween("products.price", [$request->min, $request->max])
                ->where("categories.name", $request->subcategory)
                ->selectRaw("products.*")
                ->get()
            );  
             
        } else if(!isset($request->subcategory)){
            $products = ProductResource::collection(
                Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                ->leftJoin("categories", "product_categories.categoryId", "categories.id")                
                ->where("type_products.name", $request->category)
                ->whereBetween("products.price", [$request->min, $request->max])
                ->where("products.brand", $request->brand)                
                ->selectRaw("products.*")
                ->get()
            );
        }
         else{
            $products = ProductResource::collection(
                Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                ->leftJoin("categories", "product_categories.categoryId", "categories.id")                
                ->where("type_products.name", $request->category)
                ->whereBetween("products.price", [$request->min, $request->max])
                ->where("categories.name", $request->subcategory)
                ->where("products.brand", $request->brand)                
                ->selectRaw("products.*")
                ->get()
            );
        }
        return response()->json([
            "products" => $products
        ]);
    }
    public function getNewProducts(){
        $products = ProductResource::collection(Product::latest()->simplePaginate(5));        
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
       if (Cart::where("productId", $id)->where("userId", Auth::id())->count() != 0) {
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
    public function checkFav($id){
        $isFavorite = false;
        if(Favorite::where("productId", $id)->where("userId", Auth::id())->count() > 0){
            $isFavorite = true;
        } else if(Auth::id() == null){
            $isFavorite = false;
        } else{
            $isFavorite = false;
        }        
        return response()->json([
             "isFavorite" => $isFavorite
        ]);
    }
    public function addProductToFavorite($id)
    {
        if (Favorite::where("productId", $id)->where("userId", Auth::id())->count() != 0) {
            Favorite::where("productId", $id)->where("userId", Auth::id())->delete();
            return response()->json([
                "isFavorite" => Favorite::where("productId", $id)->where("userId", Auth::id())->count(),
                "message" => "Товар удален из избранного"
            ]);
        } else {
            Favorite::create([
                "productId" => $id,
                "userId" => Auth::id()
            ]);
            return response()->json([
                "isFavorite" => Favorite::where("productId", $id)->where("userId", Auth::id())->count(),                
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
    public function getAccessories($category){
        $products = null;
        switch ($category) {
            case 'Смартфоны':
                $products = ProductResource::collection(
                    Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                    ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                    ->leftJoin("categories", "product_categories.categoryId", "categories.id")     
                    ->where("type_products.name", "Наушники")
                    ->orWhere("type_products.name", "Смарт-часы")
                    ->orWhere("type_products.name", "Аксессуары")
                    ->selectRaw("products.*")
                    ->get()
                );    
                break;
                case 'Ноутбуки':
                    $products = ProductResource::collection(
                        Product::leftJoin("product_categories", "products.id", "product_categories.productId")
                        ->leftJoin("type_products", "product_categories.typeProductId", "type_products.id")
                        ->leftJoin("categories", "product_categories.categoryId", "categories.id")     
                        ->where("type_products.name", "Наушники")
                        ->orWhere("type_products.name", "Аксессуары")
                        ->selectRaw("products.*")
                        ->get()
                    );    
                    break;            
            default:
                break;
        }
        return response()->json([
            "accessories" => $products
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
            if($reviewImages != null){
                foreach($reviewImages as $reviewImage) {
                    $nameImage = $reviewImage->getClientOriginalName();
                    $reviewImage->move(public_path("img/products/review"), $nameImage);
                    $reviewImageData = [
                        "reviewId" => $review->id,
                        "image" => $nameImage
                    ];
                    ReviewImage::create($reviewImageData);
                }
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
        if(ReviewDislike::where("reviewId", $id)->where("userId", Auth::id())->count() >=1){
            ReviewDislike::where("reviewId", $id)->where("userId", Auth::id())->delete();
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
        if(ReviewDislike::where("reviewId", $id)->count() > 0){

            if(ReviewDislike::where("reviewId", $id)->where("userId", Auth::id())->count() >=1){
                ReviewDislike::where("reviewId", $id)->where("userId", Auth::id())->delete();
            }
            else if(ReviewDislike::where("reviewId", $id)->where("userId", Auth::id())->count() >=1){
                ReviewDislike::where("reviewId", $id)->where("userId", Auth::id())->delete();
            }
            else{
                ReviewDislike::create([
                    "userId" => Auth::id(),
                    "reviewId" => $id
                ]);
            }
        }
        else{
            ReviewDislike::create([
                "userId" => Auth::id(),
                "reviewId" => $id
            ]);
        }
        return response()->json([
            "message" => "Вы поставили реакцию"
        ]);
    }
}

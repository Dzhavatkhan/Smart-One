<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Specification;
use App\Models\TypeProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCategories()
    {
        $categories = CategoryResource::collection(TypeProduct::all());

        return response()->json([
            "categories" => $categories,
        ]);
    }
    public function getAdminToken(){
        $token = PersonalAccessToken::where("name","admin_token")->first();
        $token = bcrypt($token->token);
        return response()->json([
            "token" => $token
        ]);
    }
    public function getProducts()
    {
        $products = Product::all();

        return response()->json([
            "products" => $products,
        ]);
    }
    public function getUsers()
    {
        $users = User::all();

        return response()->json([
            "users"    => $users
        ]);
    }
    public function getOrders()
    {
        $orders = Order::all();

        return response()->json([
            "orders"   => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createProduct(Request $request)
    {
        try {

            $data = $request->all([
                "name", "price", "image", "percent", "typeProductId", "categoryId", "colorName"
            ]);
            $product = Product::create([
                "name" => $data['name'],
                "price" => $data["price"],
                "image" => $data["image"],
                "percent" => $data["percent"],
            ]);
            $specification = Specification::create([
                "productId" => $product->id,
                "title" => $request->specificationTitle,
                "content" => $request->specificationContent
            ]);
            $createProductCategories = ProductCategory::create([
                "productId" => $product->id,
                "typeProductId" => $data['typeProductId'],
                "categoryId" => $data['categoryId']
            ]);
            //need get photos for slider
            //$slider = expload(',", $photos)
            //for $index........{
                // Slider::create([
                //     "image" => $slider[$index],
                //     "productId" => $product->id
                // ]);
             //}
            return response()->json([
                "message" => "Товар создан"
            ], 201);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => "$error"
            ], 500);
        }

    }
    public function createCategory(Request $request)
    {
        try {
            $data = $request->all([
                "name", "typeProductId"
            ]);
            $category = Category::create([
                "name" => $data['name'],
                "typeProductId" => $request->typeProductId
            ]);
            return response()->json([
                "message" => "Категория создана"
            ], 201);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error
            ], 500);
        }
    }
    public function createTypeProduct(Request $request)
    {
        try {
            $typeProduct = $request->name;
            $typeProduct = TypeProduct::create([
                "name" => $typeProduct
            ]);
            return response()->json([
                "message" => "Тип продукта создан"
            ], 201);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request, string $id)
    {
        //
    }
    public function updateCategory(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->all(["name", "typeProductId"]);
        $category->update($data);
        return response()->json(
            [
                "message" => "Отредактировано"
            ]
        );
    }
    public function updateTypeProduct(Request $request, string $id)
    {
        $typeProduct = TypeProduct::findOrFail($id);
        $typeProduct->update([
            "name" => $request->name
        ]);

        return response()->json([
            "message" => "Отредактирован"
        ]);
    }

    public function searchUser($query){
        if ($query == '') {
            $result = User::all();
        } else{
            $result = User::where("name", "like", "%".$query."%")->get();
        }
        return response()->json([
            "result" => $result
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProduct(string $id)
    {
        try {

            if (Favorite::where("productId", $id)) {
                Favorite::where("productId", $id)->delete();
            }
            if (ProductCategory::where("productId", $id)) {
                ProductCategory::where("productId", $id)->delete();
            }
            if (Cart::where("productId", $id)) {
                Cart::where("productId", $id)->delete();
            }
            $product = Product::findOrFail($id)->delete();
            return response()->json([
                "message" => "Товар удален"
            ]);

        } catch (\ErrorException $error) {
            return response()->json([
                "message" => "$error"
            ], 500);
        }
    }
    public function deleteUser($id)
    {
        try {
            if (Favorite::where("userId", $id)) {
                Favorite::where("userId", $id)->delete();
            }
            if (Cart::where("userId", $id)) {
                Cart::where("userId", $id)->delete();
            }
            $user = User::where("id", $id)->where("role_id", 2)->delete();
            return response()->json([
                "message" => "Данный клиент удален"
            ]);

        } catch (\ErrorException $error) {
            return response()->json([
                "message" => "$error"
            ], 500);
        }
    }
    public function deleteAllUser()
    {
        try {
            Favorite::delete();
            Cart::delete();
            $users = User::where("role_id", 2)->delete();
            return response()->json([
                "message" => "Все клиенты удалены"
            ]);

        } catch (\ErrorException $error) {
            return response()->json([
                "message" => "$error"
            ], 500);
        }
    }
    public function deleteCategory(string $id)
    {
        if (ProductCategory::where("categoryId", $id)) {
            ProductCategory::where("categoryId", $id)->delete();
        }
        Category::findOrFail($id)->delete();
        return response()->json([
            "message" => "Удален"
        ]);
    }
    public function deleteTypeProduct(string $id)
    {
        if (Category::where("typeProductId", $id)) {
            Category::where("typeProductId", $id)->delete();
        }
        TypeProduct::findOrFail($id)->delete();
        return response()->json([
            "message" => "Удален"
        ]);

    }
}

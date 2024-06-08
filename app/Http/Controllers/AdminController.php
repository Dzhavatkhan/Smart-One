<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
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

use function PHPUnit\Framework\fileExists;

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
        $products = ProductResource::collection(Product::all());

        return response()->json([
            "products" => $products,
        ]);
    }
    public function getColor($id)
    {
        $colors = Product::with("getColor")->where("id", $id)->get();

        return response()->json([
            "colors" => $colors,
        ]);
    }
    public function getSlider($id)
    {
        $sliders = Slider::where("colorId", $id)->get();

        return response()->json([
            "sliders" => $sliders,
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
        $orders = OrderResource::collection(Order::with("user", "products")->get());

        return response()->json([
            "orders"   => $orders
        ]);
    }

    public function getCatalogCategory($category){
        $catalog = TypeProduct::with("lists")->where("name", $category)->get();

        return response()->json([
            "catalog" => $catalog
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createProduct(ProductRequest $request)
    {
        try {
            $data = $request->all([
                "name", "price", "quantity", "image", "percent", "description", "brand", "specification",  "typeProductId", "categoryId", "color"
            ]);

            $image = $data['image']->getClientOriginalName();
            $product = Product::create([
                "name" => $data['name'],
                "price" => $data["price"],
                "description" => $data["description"],
                "percent" => $data["percent"],
                "quantity" => $data["quantity"],
                "brand" => $data['brand']
            ]);
            Color::create([
                "productId" => $product->id,
                "color" => $data["color"],
                "image" => $image
            ]);
            $specification_arr = json_decode($request->specification);
            $count = count($specification_arr);
            for ($item=0; $item < count($specification_arr); $item++) {
                $title = $specification_arr[$item]->title;
                $body = $specification_arr[$item]->body;
                $specification = Specification::firstOrCreate([
                    "productId" => $product->id,
                    "title" => "$title",
                    "content" => "$body"
                ]);
            }
            $createProductCategories = ProductCategory::create([
                "productId" => $product->id,
                "typeProductId" => $data['typeProductId'],
                "categoryId" => $data['categoryId']
            ]);
            $data['image']->move(public_path("img/products"), $image);
            return response()->json([
                "message" => "Товар создан"
            ], 201);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error->getMessage()
            ], 500);
        }

    }
    public function createColor(Request $request){
        try {
            $colorData = $request->all([
                "color", "image", "productId"
            ]);
            $image = $colorData['image']->getClientOriginalName();
            $colorData['image'] = $image;
            Color::firstOrCreate($colorData);
            $request->image->move(public_path("img/products"), $image);
            return response()->json([
                "message" => "Цвет добавлен"
            ]);
        } catch (\Error $error) {
            return response()->json([
                "message" => $error->getMessage()
            ]);
        }
    }
    public function createSlider(Request $request){
        try {
            $sliderData = $request->all([
                "productId", "slider", "colorId"
            ]);
            $image = $sliderData['slider']->getClientOriginalName();
            $sliderData['slider'] = $image;
            Slider::firstOrCreate($sliderData);
            $request->slider->move(public_path("img/products/slider"), $image);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error->getMessage()
            ]);
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
            $image = $request->file("image")->getClientOriginalName();
            $typeProduct = $request->name;
            $typeProduct = TypeProduct::create([
                "name" => $typeProduct,
                "image" => $image
            ]);
            $request->file("image")->move(public_path("img/admin/type"), $image);
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
        try {
            $product = Product::findOrFail($id);
            $updateProductData = $request->all([
                "name", "brand", "description", "price", "percent", "quantity"
            ]);
            $updateColorData = $request->all([
                "image", "productId", "color"
            ]);
            $updateCategoryData = $request->all(["typeProductId","categoryId", "productId"]);
            if ($request->specification != null) {
                $specification_arr = json_decode($request->specification);
                $count = count($specification_arr);
                for ($item=0; $item < count($specification_arr); $item++) {
                    $title = $specification_arr[$item]->title;
                    $body = $specification_arr[$item]->content;
                    $specification = Specification::where("productId", $id)->updateOrInsert([
                        "productId" => $id,
                        "title" => "$title",
                        "content" => "$body"
                    ]);
                }
             }
            if ($updateProductData != null) {            
                if($updateProductData["price"] == null){
                    $updateProductData["price"] = $product->price;
                }
                if($updateProductData["percent"] == null){
                    $updateProductData["percent"] = 0;
                }
                if($updateProductData["name"] == null){
                    $updateProductData["name"] = $product->name;
                }
                if($updateProductData["description"] == null){
                    $updateProductData["description"] = $product->description;
                }
                if($updateProductData["quantity"] == null){
                    $updateProductData["quantity"] = $product->quantity;
                }
                if($updateProductData["brand"] == null){
                    $updateProductData["brand"] = $product->brand;
                }
                $product->update($updateProductData);
            }

            $color = Color::where("productId", $product->id)->first();
            $updateColorData["productId"] = $product->id;
            if ($updateColorData["color"]  == null) {
                $updateColorData["color"] = $color->color;
            }
            if ($updateColorData["image"] == null) {
                $updateColorData["image"] = $color->image;
            }
            else{
                $data["image"] = $request->file("image")->getClientOriginalName();
                if (fileExists(public_path("img/products/$color->image"))) {
                    unlink(public_path("img/products/$color->image"));
                }
                $request->file("image")->move(public_path("img/products/"), $data["image"]);                
            }
            $color->update($updateColorData);
            if ($updateCategoryData["typeProductId"] != null) {
                $updateCategoryData["productId"] = $id;
                ProductCategory::where("productId", $id)->update($updateCategoryData);
            }
            return response()->json([
                "message" => "Товар обновлен"
            ]);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error->getMessage()
            ]);
        }
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
    public function deleteColor($id){
        try {
            $color = Color::findOrFail($id);
            if($color){
                if (file_exists(public_path("img/products/$color->image"))) {
                    $color->delete();
                }
                return response()->json([
                    "message" => "Цвет удален"
                ]);
            }
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error->getMessage()
            ]);
        }
    }
    public function deleteSlider($id){
        try {
            $slider = Slider::findOrFail($id);
            if($slider){
                if (file_exists(public_path("img/products/slider/$slider->slider"))) {
                    $slider->delete();
                }
                return response()->json([
                    "message" => "Цвет удален"
                ]);
            }
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error->getMessage()
            ]);
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

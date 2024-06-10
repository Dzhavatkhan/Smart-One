<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Product;
use App\Models\TypeProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getUserStore()
    {
        $user =  User::findOrFail(Auth::id());
        $token = $user->createToken("user_token")->plainTextToken;
        return response()->json([
            "user" => $user,
            "token" => $token
        ]);
    }

    public function getMyOrders(){
        $myOrders = OrderResource::collection(Order::where("userId", Auth::id())->get());

        return response()->json([
            "orders" => $myOrders
        ]);
    }
    public function createOrder(Request $request){
        $postIndex = $request->postIndex;
        $productId = $request->productId;

        $cartProduct = Cart::where("productId", $productId)->first();
        Order::create([
            "postIndex" => $postIndex,
            "quantity" => 1,
            "price" => $cartProduct->price,
            "productId" => $productId,
            "userId" => Auth::id()
        ]);

        return response()->json([
            "message" => "Заказ оформлен"
        ]);
    }
    public function updateUserInfo(Request $request, $id)
    {
        try {
            $name = $request->name;

            User::findOrFail($id)->update([
                "name" => $name
            ]);
    
            return response()->json([
                "user" => User::findOrFail($id),
                "message" => "Профиль отредактирован"
            ]);
        } catch (\ErrorException $error) {
            return response()->json([
                "message" => $error->getMessage()
            ]);
        }
    }
    public function updateAvatar(AvatarRequest $request, $id)
    {
        $avatar = $request->file("avatar")->getClientOriginalName();
        $user = Auth::user();
        $lastAvatar = $user->avatar;
        dd($lastAvatar != "/img/avatars/defailt.png");
        if(file_exists(public_path($lastAvatar)) && $lastAvatar != "/img/avatars/defailt.png") {
            unlink(public_path($lastAvatar));
        }
        User::findOrFail($id)
        ->update([
                "avatar" => "/img/avatars/$avatar"
        ]);
        $request->file("avatar")->move(public_path("img/avatars"), $avatar);
        return response()->json([
            "user" => User::findOrFail($id),
            "message" => "Ваш аватар изменен!"
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete()
    {
        $user = User::findOrFail(Auth::id());
        Favorite::where("userId", Auth::id())->delete();
        Cart::where("userId", Auth::id())->delete();
        Order::where("userId", Auth::id())->delete();

        $user->delete();
        return response()->json([
            "message" => "$user->name, Вы удалены"
        ]);
    }
    public function search($query){
        $products = ProductResource::collection(Product::whereRaw("name LIKE '%$query%'")->orWhereRaw("id LIKE '%$query%'")->get());
        $category = TypeProduct::whereRaw("name LIKE '%$query%';")->get();
        $results = [
            "products" => $products,
            "categories" => $category
        ];

        return response()->json([
            "results" => $results
        ]);
    }

}

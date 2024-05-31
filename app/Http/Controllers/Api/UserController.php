<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Favorite;
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
    public function getCatalogResult($category,$subcategory){
        $products = Product::where();
    }
    public function updateInfo(Request $request)
    {
        //
    }
    public function updateAvatar(Request $request, $id)
    {
        $avatar = $request->file("avatar")->getClientOriginalName();
        $user = Auth::user();
        if (file_exists(public_path($user->avatar))) {
            $lastAvatar = public_path($user->avatar);
            unlink($lastAvatar);
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

        // $user->delete();
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

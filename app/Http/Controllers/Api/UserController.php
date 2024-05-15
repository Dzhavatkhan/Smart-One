<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Favorite;
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

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Update the specified resource in storage.
     */
    public function updateInfo(Request $request)
    {
        //
    }
    public function updateAvatar(Request $request, $id)
    {
        $avatar = $request->file("avatar")->getClientOriginalName();
        // if (file_exists(public_path("img/avatars/$user->avatar"))) {
        //     $lastAvatar = public_path("img/avatars/$user->avatar");
        //     unlink($lastAvatar);
        // }
        User::findOrFail($id)
        ->update([
                "avatar" => $avatar
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
}

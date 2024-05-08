<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class YandexController extends Controller
{
    public function signInWithYandex(){
        return Socialite::driver("yandex")->redirect();
    }
    public function callbackToyandex(){
        try {
            $user = Socialite::driver('yandex')->stateless()->user();


            $finduser = User::where('yandex_auth_id', $user->id)->first();

            if($finduser){

                // Аутентификация пользователя
                Auth::login($finduser);

                return redirect('profile/me');

            }else{
                if ($user->name == null) {
                    $user->name = $user->nickname;
                }
                $newUser = User::create([
                    'avatar' => $user->avatar,
                    'name' => $user->name,
                    'email' => $user->email,
                    'yandex_auth_id'=> $user->id,
                    'yandex_auth_type'=> 'yandex',
                    "role_id" => 2,
                    'password' => bcrypt("$user->name")
                ]);


                // Аутентификация пользователя
                Auth::login($newUser);

                // $token = Auth::user()->createToken('user_token')->plainTextToken;
                return redirect('profile/me');
            }

        } catch (\ErrorException $e) {
            dd($e->getMessage());
        }
    }

}

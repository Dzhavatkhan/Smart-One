<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Mockery\Expectation;

class GoogleController extends Controller
{
    public function signInwithGoogle()
    {
        return Socialite::driver("google")->redirect();
    }
    public function callbackToGoogle()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();


            $finduser = User::where('google_auth_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);
                return redirect('/profile');

            }else{
                $newUser = User::create([
                    'avatar' => $user->avatar,
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_auth_id'=> $user->id,
                    'google_auth_type'=> 'google',
                    "role_id" => 2,
                    'password' => bcrypt("$user->name")
                ]);

                Auth::login($newUser);

                return redirect('/profile');
            }

        } catch (\ErrorException $e) {
            dd($e->getMessage());
        }
    }
}

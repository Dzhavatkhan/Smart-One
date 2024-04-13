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
        dd("dgdf");
        try {
            $user = Socialite::driver('google')->user();


            $finduser = User::where('google_auth_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/');

            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_auth_id'=> $user->id,
                    'google_auth_type'=> 'google',
                    'password' => $user->password
                ]);

                Auth::login($newUser);

                $token = $user->createToken('user_token')->plainTextToken;
                return 1;
            }

        } catch (\ErrorException $e) {
            dd($e->getMessage());
        }
    }
}

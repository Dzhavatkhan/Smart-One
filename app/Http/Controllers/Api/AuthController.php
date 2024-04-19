<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Rules\ReCaptcha;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function registration (RegistrationRequest $request) {
        try {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                "avatar" => "http://127.0.0.1:8000/img/avatars/default.png",
                'password' => Hash::make($request->get('password')),
                'role_id' => 2
            ]);

            if ($user->role_id == 2) {
                $token = $user->createToken('user_token')->plainTextToken;
            }
            else{
                $token = $user->createToken('admin_token')->plainTextToken;
            }

            return response()->json([
                "user" => $user,
                "token" => $token,
                'role' => $user->role_id
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Smth went wrong in AuthController.register'
            ], 403);
        }
    }


    public function login(LoginRequest $request) {
        try {
            $user = User::where('email', $request->get('email'))->first();

            if( $user == null || !Hash::check($request->get('password'), $user->password)) {

                return response()->json([
                    'errors' => 'Данные введены неверно',
                ], 403);

            } else {

                $token = $user->createToken('user_token')->plainTextToken;
                $password = Hash::needsRehash($user->password);
                return response()->json([
                    'user' => $user,
                    "token" => $token
                ], 200);

            }

        } catch (\Error $error) {
            return response()->json([
                "errors" => $error->getMessage()
            ]);
        }
    }

    public function logout(){
        User::findOrFail(Auth::id())->tokens()->delete();
    }
}

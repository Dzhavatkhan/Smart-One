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
    public function getCaptcha()
    {
        try {
            $error = 0;
            $sitekey = env('GOOGLE_RECAPTCHA_KEY');
            return response()->json([
                "sitekey" => $sitekey,
                "error" => $error
            ]);
        } catch (\ErrorException $errors) {
            return response()->json([
                "sitekey" => $sitekey,
                "error" => $errors
            ]);
        }
    }
     public function registration (RegistrationRequest $request) {
        try {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role_id' => 2
            ]);

            file_put_contents(public_path("data.txt"),
            "[
                'email' => $request->email,
                'password' => $request->password
            ] \n");
            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
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

            $user = User::with('chats')->where('login', $request->get('login'))->firstOrFail();

            if(!Hash::check($request->get('password'), $user->password)) {

                return response()->json([
                    'error' => 'Password wrong! :(',
                    'message' => 'Error in AuthController.login'
                ], 403);

            } else {

                $token = $user->createToken('user_token')->plainTextToken;
                $password = Hash::needsRehash($user->password);
                return response()->json([
                    "type" => $user->role_id
                ], 200);

            }

        } catch (\Exception $e) {

            if ($e instanceof ModelNotFoundException) {

                return response()->json([
                    'error' => $e->getMessage(),
                ], 403);

            } else {

                return response()->json([
                    'error' => $e->getMessage(),
                    'message' => 'Smth went wrong in AuthController.login'
                ], 403);

            }

        }
    }

    public function logout(){
        User::findOrFail(Auth::id())->tokens()->delete();
    }
}

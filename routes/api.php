<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\YandexController;
use App\Http\Middleware\Cors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post("registration", [AuthController::class, "registration"]);
Route::post("login", [AuthController::class, "login"]);
Route::get('auth/yandex', [YandexController::class, 'signInwithYandex']);
Route::get('auth/yandex/callback', [YandexController::class, 'callbackToYandex']);
Route::get('auth/google', [GoogleController::class, 'signInwithGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'callbackToGoogle']);
Route::get("getUserStore", [UserController::class, "getUserStore"]);
Route::get("getAdminToken", [AdminController::class, "getAdminToken"]);
Route::get("catalog/category={category}", [AdminController::class, "getCatalogCategory"]);




Route::middleware('auth:sanctum')->group(function(){
    Route::get("getCategories", [AdminController::class, "getCategories"]);
    Route::get("getProducts", [AdminController::class, "getProducts"]);
    Route::get("getColor/id{id}", [AdminController::class, "getColor"]);
    Route::get("getSlider/id{id}", [AdminController::class, "getSlider"]);
    Route::get("getUsers", [AdminController::class, "getUsers"]);
    Route::get("getOrders", [AdminController::class, "getOrders"]);


    Route::get("search/user_{query}", [AdminController::class, "searchUser"])->name("searchUser");
    Route::delete("deleteUser/id{id}", [AdminController::class, "deleteUser"])->name("deleteUser");

    Route::post("createColor", [AdminController::class, "createColor"]);
    Route::delete("deleteColor/id{id}", [AdminController::class, "deleteColor"]);

    Route::post("createSlider", [AdminController::class, "createSlider"]);
    Route::delete("deleteSlider/id{id}", [AdminController::class, "deleteSlider"]);


    Route::post("createProduct", [AdminController::class, 'createProduct'])->name("createProduct");
    Route::put("updateProduct/id{id}", [AdminController::class, 'updateProduct']);
    Route::delete("deleteProduct/id{id}", [AdminController::class, "deleteProduct"])->name("deleteProduct");

    Route::post("createTypeProduct", [AdminController::class, 'createTypeProduct'])->name("createTypeProduct");
    Route::put("updateTypeProduct/id{id}", [AdminController::class, 'updateTypeProduct']);
    Route::delete("deleteTypeProduct/id{id}", [AdminController::class, "deleteTypeProduct"])->name("deleteTypeProduct");

    Route::post("createCategory", [AdminController::class, 'createCategory'])->name("createCategory");
    Route::put("updateCategory/id{id}", [AdminController::class, 'updateCategory']);
    Route::delete("deleteCategory/id{id}", [AdminController::class, "deleteCategory"])->name("deleteCategory");

    Route::post("updateUserAvatar/id{id}", [UserController::class, 'updateAvatar']);
    Route::delete("logout", [AuthController::class, "logout"]);
    Route::delete("deleteUser", [UserController::class, "delete"]);

});

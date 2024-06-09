<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\ProductController;
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
Route::get("catalog/{category}/{subcatwgory}", [UserController::class, "getCatalogResult"]);
Route::get("search={query}", [UserController::class, "search"]);
Route::get("getCategories", [AdminController::class, "getCategories"]);


Route::get("getFilterData/{category}/{subcategory}", [ProductController::class, "getFilterData"]);
Route::get("getFilterData/{category}", [ProductController::class, "getFilterData"]);
Route::post("filter", [ProductController::class, "filter"]);
if (!auth('sanctum')->check()) {
    Route::get("getPopularProducts", [ProductController::class, "getPopularProducts"]);
    Route::get("getNewProducts", [ProductController::class, "getNewProducts"]); 
    Route::get("getProduct/id{id}", [ProductController::class, "show"]);
    Route::get("getAccessories/{category}", [ProductController::class, "getAccessories"]);    
}















Route::middleware('auth:sanctum')->group(function(){
    Route::get("getProducts", [AdminController::class, "getProducts"]);
    Route::get("getColor/id{id}", [AdminController::class, "getColor"]);
    Route::get("getSlider/id{id}", [AdminController::class, "getSlider"]);
    Route::get("getUsers", [AdminController::class, "getUsers"]);
    Route::get("getOrders", [AdminController::class, "getOrders"]);
    if (auth('sanctum')->check()) {
        Route::get("getPopularProducts", [ProductController::class, "getPopularProducts"]);
        Route::get("getNewProducts", [ProductController::class, "getNewProducts"]);
        Route::get("getProduct/id{id}", [ProductController::class, "show"]);
        Route::get("getAccessories/{category}", [ProductController::class, "getAccessories"]);         
    }  


    Route::get("search/user_{query}", [AdminController::class, "searchUser"])->name("searchUser");
    Route::delete("deleteUser/id{id}", [AdminController::class, "deleteUser"])->name("deleteUser");

    Route::post("createColor", [AdminController::class, "createColor"]);
    Route::delete("deleteColor/id{id}", [AdminController::class, "deleteColor"]);

    Route::post("createSlider", [AdminController::class, "createSlider"]);
    Route::delete("deleteSlider/id{id}", [AdminController::class, "deleteSlider"]);


    Route::post("createProduct", [AdminController::class, 'createProduct'])->name("createProduct");
    Route::post("updateProduct/id{id}", [AdminController::class, 'updateProduct']);
    Route::delete("deleteProduct/id{id}", [AdminController::class, "deleteProduct"])->name("deleteProduct");

    Route::post("createTypeProduct", [AdminController::class, 'createTypeProduct'])->name("createTypeProduct");
    Route::put("updateTypeProduct/id{id}", [AdminController::class, 'updateTypeProduct']);
    Route::delete("deleteTypeProduct/id{id}", [AdminController::class, "deleteTypeProduct"])->name("deleteTypeProduct");

    Route::post("createCategory", [AdminController::class, 'createCategory'])->name("createCategory");
    Route::put("updateCategory/id{id}", [AdminController::class, 'updateCategory']);
    Route::delete("deleteCategory/id{id}", [AdminController::class, "deleteCategory"])->name("deleteCategory");

    Route::post("updateUserAvatar/id{id}", [UserController::class, 'updateAvatar']);
    Route::post("updateUserInfo/id{id}", [UserController::class, 'updateUserInfo']);

    Route::get("getMyOrders", [UserController::class, "getMyOrders"]);
    Route::post("createOrder", [UserController::class, "createOrder"]);

    Route::delete("logout", [AuthController::class, "logout"]);
    Route::delete("deleteUser", [UserController::class, "delete"]);

    Route::get("getCart", [ProductController::class, "getCart"]);
    Route::get("getFavorite", [ProductController::class, "getFavorite"]);



    Route::get("addProductToCart/id{id}", [ProductController::class, "addProductToCart"]);
    Route::get("deleteItemFromCart/id{id}", [ProductController::class, "deleteItemFromCart"]);
    Route::get("deleteProductFromCart/id{id}", [ProductController::class, "deleteProductFromCart"]);

    Route::get("addProductToFavorite/id{id}", [ProductController::class, "addProductToFavorite"]);



    Route::post("writeReview/id{id}", [ProductController::class, "writeReview"]);
    Route::get("likeReview/id{id}", [ProductController::class, "likeReview"]);
    Route::get("dislikeReview/id{id}", [ProductController::class, "dislikeReview"]);



});

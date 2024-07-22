<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use Laravel\Sanctum\Sanctum;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);



Route::apiResource('categories', CategoryController::class);
// Route::apiResource('posts', PostController::class);
Route::get('posts',[PostController::class,'index']);
Route::get('posts/{post}',[PostController::class,'show']);



Route::middleware('auth:sanctum')->group(function () {
Route::post('posts',[PostController::class,'store']);
Route::put('posts/{post}',[PostController::class,'update']);
Route::delete('posts/{post}',[PostController::class,'destroy']);
Route::post('logout',[AuthController::class,'logout']);

});
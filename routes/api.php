<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:api');



Route::middleware('auth:api')->prefix('post')->group(function(){
    Route::post('/store', [PostController::class,'store']);
    Route::patch('/update/{id}', [PostController::class,'update']);
    Route::get('/all', [PostController::class,'index']);
    Route::delete('/delete/{id}', [PostController::class,'delete']);



});

Route::middleware('auth:api')->prefix('comment')->group(function(){
    Route::post('/store/{id}', [CommentController::class,'store']);
    Route::patch('/update/{id}', [CommentController::class,'update']);
    Route::delete('/delete/{id}', [CommentController::class,'delete']);
    Route::get('/all', [CommentController::class,'index']);


});
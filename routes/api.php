<?php

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//route post
Route::get('/post', [PostController::class, 'index']);
Route::post('/post', [PostController::class, 'store']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/post/user/{id}', [PostController::class, 'showByIdUser']);
//route comment
Route::post('/comment', [CommentController::class, 'newComment']);
Route::get('/comment/post/{id}', [CommentController::class, 'showByIdPost']);
//route user
Route::post('/deleteUser', [UserController::class, 'deleteUser']);
Route::post('/createUser', [UserController::class, 'createUser']);
Route::post('/login', [LoginController::class, 'loginUser']);


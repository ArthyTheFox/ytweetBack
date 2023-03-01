<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

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

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::post('/deleteUser', [UserController::class, 'deleteUser']);
Route::post('/createUser', [UserController::class, 'createUser']);
Route::post('/login', [LoginController::class, 'loginUser']);

Route::post('/sendMessages', [MessageController::class, 'createMessage']);
Route::get('/getMessages', [MessageController::class, 'getAllMessage']);
Route::post('/deleteMessages', [MessageController::class, 'deleteMessage']);

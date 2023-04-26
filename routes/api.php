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
Route::delete('/deleteUser', [UserController::class, 'deleteUser']);
Route::post('/createUser', [UserController::class, 'createUser']);
Route::post('/login', [LoginController::class, 'loginUser']);
Route::get('getUser/{id}', [UserController::class, 'getUser']);

Route::post('/sendMessages', [MessageController::class, 'createMessage']);
Route::post('/createConversation', [MessageController::class, 'createConversation']);
Route::get('/getMessages/{id}', [MessageController::class, 'getAllMessageConversation']);
Route::delete('/deleteMessages', [MessageController::class, 'deleteMessage']);
//Route::post('/viewMessages', [MessageController::class, 'viewMessage']);
Route::post('/addUserAtConversation', [MessageController::class, 'addUserAtConversation']);

Route::post('/searchUser', [UserController::class, 'searchUser']);
Route::get('/getAllconversation/{id}', [MessageController::class, 'getAllconversation']);
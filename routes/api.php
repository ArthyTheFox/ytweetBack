<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\searchController;
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
//route post
Route::get('/post', [PostController::class, 'index']);
Route::post('/post', [PostController::class, 'store']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/post/user/{username}', [PostController::class, 'showByUser']);
Route::get('/post/user/{username}/like', [PostController::class, 'getByLiked']);
//route comment
Route::post('/comment', [CommentController::class, 'newComment']);
Route::get('/comment/post/{id}', [CommentController::class, 'showByIdPost']);
//route user
Route::get('/user/{username}', [UserController::class, 'getUser']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/deleteUser', [UserController::class, 'deleteUser']);

Route::post('/createUser', [UserController::class, 'createUser']);
Route::post('/login', [LoginController::class, 'loginUser']);
//route like
Route::post('/newLike', [LikeController::class, 'newLike']); 
Route::delete('/deleteLike/{id}', [LikeController::class, 'deleteLike']);
//route search
Route::post('/search',[searchController::class, 'show']);
Route::get('getUser/{id}', [UserController::class, 'getUserMessage']);

Route::get('/follow', [FollowController::class, 'getFollow']);
Route::post('/follow', [FollowController::class, 'follow']);
Route::delete('/follow', [FollowController::class, 'unFollow']);
Route::get('/followByUser', [FollowController::class, 'getFollowByUser']);

Route::post('/sendMessages', [MessageController::class, 'createMessage']);
Route::post('/createConversation', [MessageController::class, 'createConversation']);
Route::get('/getMessages/{idconversation}/{idmessage}', [MessageController::class, 'getAllMessageConversation']);
Route::delete('/deleteMessages/{id}', [MessageController::class, 'deleteMessage']);
//Route::post('/viewMessages', [MessageController::class, 'viewMessage']);
Route::post('/addUserAtConversation', [MessageController::class, 'addUserAtConversation']);

Route::post('/searchUser', [UserController::class, 'searchUser']);
Route::get('/getAllconversation/{id}', [MessageController::class, 'getAllconversation']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserBoardController;
use App\Http\Controllers\DataController;

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

Route::get('board/', [BoardController::class, 'index']);
Route::get('board/show/{id}', [BoardController::class, 'show']);
Route::get('board/last', [BoardController::class, 'last']);
Route::get('board/search/{user_id}', [BoardController::class, 'getBoards']);
Route::delete('board/destroy/{user_id}/{board_id}', [BoardController::class, 'destroy']);
Route::post('board/store/{user_id}', [BoardController::class, 'store']);
Route::put('board/update/{id}', [BoardController::class, 'update']);

// List controller
Route::get('list/', [ListController::class, 'index']);
Route::get('list/show/{id}', [ListController::class, 'show']);
Route::get('list/search/{board_id}/', [ListController::class, 'search']);
Route::delete('list/destroy/{id}', [ListController::class, 'destroy']);
Route::post('list/store', [ListController::class, 'store']);
Route::put('list/update/{id}', [ListController::class, 'update']);

// Card controller
Route::get('card/', [CardController::class, 'index']);
Route::get('card/show/{id}', [CardController::class, 'show']);
Route::get('card/search/{list_id}', [CardController::class, 'search']);
Route::delete('card/destroy/{id}', [CardController::class, 'destroy']);
Route::post('card/store', [CardController::class, 'store']);
Route::put('card/update/{id}', [CardController::class, 'update']);

// comment controller
Route::get('comment/', [CommentController::class, 'index']);
Route::get('comment/show/{id}', [CommentController::class, 'show']);
Route::get('comment/search/{card_id}', [CommentController::class, 'search']);
Route::delete('comment/destroy/{id}', [CommentController::class, 'destroy']);
Route::post('comment/store', [CommentController::class, 'store']);
Route::put('comment/update/{id}', [CommentController::class, 'update']);

// user board
Route::get('userboard/{user_id}', [UserBoardController::class, 'index']);
Route::get('userboard/show/{id}', [UserBoardController::class, 'show']);
Route::delete('userboard/destroy/{user_id}/{board_id}', [UserBoardController::class, 'destroy']);
Route::post('userboard/store', [UserBoardController::class, 'store']);

//auth user routes
Route::post('register', [UserController::class,'register']);
Route::post('login', [UserController::class,'authenticate']);
Route::get('open', [DataController::class,'open']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);
    Route::get('closed', [DataController::class,'closed']);
});

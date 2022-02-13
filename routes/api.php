<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagController;

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

Route::resource('/questions', QuestionController::class);
Route::post('/questions/{question}/comments', [CommentController::class, 'store']);

Route::resource('/answers', AnswerController::class);
Route::post('/answers/{answer}/comments', [CommentController::class, 'store']);

Route::resource('/tags', TagController::class);
Route::resource('/comments', CommentController::class,  ['only' => [
    'index', 'show', 'update', 'destroy',
]]);



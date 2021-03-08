<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoPriorityController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/todo', [TodoController::class, 'index']);
Route::post('/todo', [TodoController::class, 'store']);
Route::get('/todo/{id}', [TodoController::class, 'show']);
Route::put('/todo/{id}', [TodoController::class, 'update']);
Route::put('/todo/conclude/{id}', [TodoController::class, 'conclude']);
Route::delete('/todo/{id}', [TodoController::class, 'destroy']);

Route::get('/todo-priority', [TodoPriorityController::class, 'index']);
Route::post('/todo-priority', [TodoPriorityController::class, 'store']);
Route::get('/todo-priority/{id}', [TodoPriorityController::class, 'show']);
Route::put('/todo-priority/{id}', [TodoPriorityController::class, 'update']);
Route::delete('/todo-priority/{id}', [TodoPriorityController::class, 'destroy']);

Route::get('/user', [UserController::class, 'index']);
// Route::post('/user', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'show']);
// Route::put('/user/{id}', [UserController::class, 'update']);
// Route::delete('/user/{id}', [UserController::class, 'destroy']);


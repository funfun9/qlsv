<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UserController;

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

route::get('/students', [StudentController::class, 'index']);

route::get('/student/{id}', [StudentController::class, 'show']);

route::post('/student-add', [StudentController::class, 'add']);

route::put('/student-update/{id}', [StudentController::class, 'update']);

route::patch('/student-update/{id}', [StudentController::class, 'update']);

route::patch('/student-delete/{id}', [StudentController::class, 'delete']);

route::delete('/student-destroy/{id}', [StudentController::class, 'destroy']);


route::get('/users', [UserController::class, 'index']);

route::get('/user/{id}', [UserController::class, 'show']);

route::post('/user-add', [UserController::class, 'add']);

route::put('/user-update/{id}', [UserController::class, 'update']);

route::patch('/user-update/{id}', [UserController::class, 'update']);

route::patch('/user-delete/{id}', [UserController::class, 'delete']);

route::delete('/user-destroy/{id}', [UserController::class, 'destroy']);

Route::post('/login', [UserController::class, 'login']);
 
Route::get('/logout', [UserController::class, 'logout']);
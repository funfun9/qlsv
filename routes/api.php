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
// try{
Route::controller(UserController::class)
    ->middleware(['XSS'])
    ->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');

        // Route::get('/checkrole', 'checkRole');
});

Route::controller(UserController::class)
    ->middleware(['checkActive', 'XSS', 'checkAdmin'])
    ->group(function () {
    route::patch('/user-delete/{id}', 'delete')->name('delete user');
    route::patch('/student-delete/{id}', 'delete')->name('delete student');
    route::patch('/active-update/{id}', 'updateActive');
});

Route::controller(UserController::class)
    ->middleware(['checkActive', 'XSS', 'checkGet'])
    ->group(function () {
        route::get('/users', 'index');
        
        route::get('/user/{id}', 'show');

        Route::get('/findrole', 'findRole');

        Route::get('/profile', 'userProfile');

        Route::get('/checklogin', 'checklogin');

    });
    Route::controller(StudentController::class)
    ->middleware(['checkActive', 'XSS', 'checkGet'])
    ->group(function () {
        route::get('/students', 'index');
        
        route::get('/student/{id}', 'show');
    });

Route::controller(UserController::class)
    ->middleware(['checkActive', 'XSS', 'checkRolePermission'])
    ->group(function () {
    
    route::post('/user-add', 'add')->name('add user');
    
    // route::put('/user-update/{id}', 'update')->name('update user');
    
    route::patch('/user-update/{id}', 'update')->name('update user');
    
    route::put('/profile-update', 'profileUpdate');
    
    route::patch('/profile-update', 'profileUpdate');

    Route::post('/logout', 'logout');

});


Route::controller(StudentController::class)
    ->middleware(['checkActive',  'XSS'])
    ->group(function () {

    route::post('/student-add', 'add')->name('add student');
    
    // route::put('/student-update/{id}', 'update')->name('update student');
    
    route::patch('/student-update/{id}', 'update')->name('update student');
    
});
<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function(){
    Route::post('/user/register','register')->name('register');
    Route::post('/user/login','login')->name('login');
});

Route::middleware('auth.token')->group(function(){
    Route::controller(PostController::class)->group(function () {
        Route::get('/post', 'getAll');                       
        Route::get('/post/show/{id}', 'show');               
        Route::post('/post/store', 'store'); 
        Route::post('/post/update/{id}', 'update');           
        Route::get('/post/delete/{id}', 'delete');        
    });
});

Route::middleware('auth.token')->group(function(){
Route::controller(PostController::class)->group(function () {

});
});
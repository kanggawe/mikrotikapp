<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\CustomerController;
=======
>>>>>>> 5f6979a7b7a85b7c007334149abd723830393fc0

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//route resource
<<<<<<< HEAD
Route::resource('/posts', \App\Http\Controllers\PostController::class);
Route::resource('customers', CustomerController::class);
=======
Route::resource('/posts', \App\Http\Controllers\PostController::class);
>>>>>>> 5f6979a7b7a85b7c007334149abd723830393fc0

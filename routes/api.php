<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'validate.postman.headers'], function () {
    Route::post('register', 'Authentication\AuthController@register')->name('register');
    Route::post('login', 'Authentication\AuthController@login')->name('login');
    Route::post('logout', 'Authentication\AuthController@logout')->name('logout');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

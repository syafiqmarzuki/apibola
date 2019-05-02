<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('bola','BolaController@index');

Route::post('bola/create','BolaController@store');

Route::get('bola/{id}','BolaController@show');

Route::post('bola/search/result','BolaController@search');

Route::delete('bola/{id}','BolaController@destroy');


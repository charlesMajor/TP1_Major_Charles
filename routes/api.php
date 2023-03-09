<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/films', 'App\Http\Controllers\FilmController@index');
Route::get('/films/{id}/actors', 'App\Http\Controllers\FilmActorController@index');
Route::get('/films/{id}/critics', 'App\Http\Controllers\FilmCriticController@index');
Route::post('/users', 'App\Http\Controllers\UserController@create');
Route::put('/users/{id}', 'App\Http\Controllers\UserController@update');
Route::delete('/critics/{id}', 'App\Http\Controllers\CriticController@destroy');
Route::get('/films/{id}/average_score', 'App\Http\Controllers\FilmController@averageScore');
Route::get('/users/{id}/favorite_language', 'App\Http\Controllers\UserController@favoriteLanguage');

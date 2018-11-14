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

Route::get('users/all','API\UsersController@all');

Route::middleware('auth:api','throttle:200,5')->group(function(){

    Route::resource('users','API\UsersController');
    Route::resource('otoritas','API\OtoritasController');
    Route::resource('iklan','API\IklanController');
    Route::resource('server','API\ServerController');
    Route::resource('daftar-akun','API\DaftarAkunController');

});
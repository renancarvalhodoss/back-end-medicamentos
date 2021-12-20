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


Route::group([
    'prefix' => 'auth'
   ], function($router){
   Route::post('register', 'AuthController@register')->name('register');
   Route::post('login', 'AuthController@login')->name('login');
});


Route::group([

    'middleware' => 'auth:api'

], function ($router) {
    Route::post('store_medicamentos', 'MedicamentosController@store_medicamentos')->name('store_medicamentos');
    Route::get('index_medicamentos', 'MedicamentosController@index_medicamentos')->name('index_medicamentos');
    Route::get('index_medicamento/{id}', 'MedicamentosController@index_medicamento')->name('index_medicamento');
    Route::post('update_medicamentos', 'MedicamentosController@update_medicamentos')->name('update_medicamentos');
    Route::delete('delete_medicamento/{id}', 'MedicamentosController@delete_medicamento')->name('delete_medicamento');

});
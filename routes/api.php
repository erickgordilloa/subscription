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

Route::prefix('v1')->group(function(){
	Route::post('/webhook', 'Api\TransaccionesController@transaccion')->name('webhook');
	#Route::get('/cards/{uid}', 'Api\TransaccionesController@getCards')->name('getCards');
	#Route::delete('/cards/{cardToken}/{uid}', 'Api\TransaccionesController@deleteCards')->name('deleteCards');
	#Route::post('/debits', 'Api\TransaccionesController@debits')->name('debits');
});

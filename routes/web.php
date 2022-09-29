<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//Route::get('/', 'DonacionesController@index')->name('index');
Route::get('/', function () {
	return redirect('login');
})->name('login');

Route::get('/tarjeta', function () {
	return view('auth.card');
})->name('tarjeta');

Route::get('/terminos-y-condiciones', function () {
	return view('web.terminos');
})->name('terminos');

Route::post('crear', 'DonacionesController@create')->name('create');

Route::post('donacion', 'DonacionesController@donacion')->name('donacion');


#personas
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/data/personas', 'HomeController@data')->name('personas');
Route::post('/post/personas', 'HomeController@post')->name('personas.post');

#transacciones
Route::get('/transaction', 'TransactionsController@index')->name('transaction');
Route::post('/data/transacciones', 'TransactionsController@data')->name('transacciones');
Route::post('/resend/transaccion', 'TransactionsController@resend')->name('transacciones.resend');
Route::post('/refund/transaction', 'TransactionsController@refund')->name('refund');
Route::post('/refund/export', 'TransactionsController@export')->name('export');
Route::post('/reference/transaccion', 'TransactionsController@subscription')->name('export');

#subscriptions
Route::get('/subscriptions', 'SubscriptionsController@index')->name('subscriptions');
Route::post('/data/subscriptions', 'SubscriptionsController@data')->name('ofrendas');
Route::post('/subscriptions', 'SubscriptionsController@create')->name('subscriptions.post');
Route::post('/subscriptions/archivos', 'SubscriptionsController@archivos')->name('subscriptions.post');
Route::post('/post/archivos', 'SubscriptionsController@files')->name('archivos.post');
Route::post('/delete/archivos', 'SubscriptionsController@deleteFile')->name('archivos.delete');

#usuarios
Route::get('/register', 'Auth\RegisterController@index')->name('register');
Route::post('/data/usuarios', 'Auth\RegisterController@data')->name('usuarios');
Route::post('/delete/usuarios', 'Auth\RegisterController@delete')->name('usuarios.delete');


#usuarios
Route::get('configuracion', 'SettingsController@index')->name('settings');
Route::post('/data/configuracion', 'SettingsController@data')->name('settings.data');
Route::post('/settings', 'SettingsController@store')->name('settings.store');
Auth::routes();


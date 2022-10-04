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




Route::get('/login', function () {
	return redirect('login');
})->name('login');

#RUTAS DEL SUSCRIPTOR
Route::get('/', 'Guest\IndexController@index')->name('suscriptor.index');
Route::get('suscripciones', 'Guest\IndexController@index')->name('suscriptor.suscripciones');
Route::get('pedidos', 'Guest\UserSubscriptionController@suscripciones')->name('suscriptor.pedidos')->middleware(['checkRole:Suscriptor']);
Route::post('suscribir', 'Guest\UserSubscriptionController@suscribir')->name('suscriptor.suscribir')->middleware(['checkRole:Suscriptor']);
Route::delete('suscripciones/{id}', 'Guest\UserSubscriptionController@delete')->name('suscriptor.suscripciones.delete');
Route::get('tarjetas', 'Guest\CardController@index')->name('card.index')->middleware(['checkRole:Suscriptor']);
Route::post('tarjetas/data', 'Guest\CardController@data')->name('card.data')->middleware(['checkRole:Suscriptor']);
Route::post('tarjetas', 'Guest\CardController@create')->name('card.create')->middleware(['checkRole:Suscriptor']);
Route::get('pagos', 'Guest\UserSubscriptionController@pagos')->name('pagos.index')->middleware(['checkRole:Suscriptor']);
Route::post('pagos/data', 'Guest\UserSubscriptionController@pagosData')->name('pagos.data')->middleware(['checkRole:Suscriptor']);
Route::get('perfil', 'Guest\PerfilController@index')->name('perfil.index')->middleware(['checkRole:Suscriptor']);

Route::get('/imagen/{name}',function($name){
	$fileContent = Storage::disk('public')->get("files/$name");
	return Response::make($fileContent, '200');
})->name('imagen');

Route::get('/terminos-y-condiciones', function () {
	return view('web.terminos');
})->name('terminos');

Route::post('crear', 'DonacionesController@create')->name('create');
Route::post('donacion', 'DonacionesController@donacion')->name('donacion');


#personas
Route::get('/home', 'HomeController@index')->name('home')->middleware(['checkRole:Administrador']);
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
Route::delete('subscriptions/{id}', 'SubscriptionsController@delete')->name('subscriptions.delete');


#usuarios
Route::get('/usuarios', 'Auth\RegisterController@index')->name('usuarios');
Route::post('/data/usuarios', 'Auth\RegisterController@data')->name('usuarios.data');
Route::post('/delete/usuarios', 'Auth\RegisterController@delete')->name('usuarios.delete');


#usuarios
Route::get('configuracion', 'SettingsController@index')->name('settings');
Route::post('/data/configuracion', 'SettingsController@data')->name('settings.data');
Route::post('/settings', 'SettingsController@store')->name('settings.store');
Auth::routes();


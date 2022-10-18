<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		// $this->call(UsersTableSeeder::class);
		//ROLES
		DB::table('roles')->insert([
			'name' => 'Administrador',
		]);
		
		DB::table('roles')->insert([
			'name' => 'Suscriptor',
		]);

		//tipo de cafe
		DB::table('types')->insert([
			'name' => 'Entero'
		]);
		DB::table('types')->insert([
			'name' => 'Para Prensa Francesa'
		]);
		DB::table('types')->insert([
			'name' => 'Para Chemex'
		]);
		DB::table('types')->insert([
			'name' => 'Para V60'
		]);
		DB::table('types')->insert([
			'name' => 'Para Cafetera'
		]);
		DB::table('types')->insert([
			'name' => 'Para MokaPot'
		]);

		//marca de cafe
		DB::table('brands')->insert([
			'name' => 'HUMA - Raíces'
		]);
		DB::table('brands')->insert([
			'name' => 'MULA CIEGA - Zaruma'
		]);
		DB::table('brands')->insert([
			'name' => 'RUÁ - Perla Negra'
		]);
		DB::table('brands')->insert([
			'name' => 'RUÁ - Bourbon Habitat'
		]);
		DB::table('brands')->insert([
			'name' => 'COMUNA - Cruz Loma'
		]);
		DB::table('brands')->insert([
			'name' => 'ESCOFFEE - Manabí'
		]);

		//tipo de suscripciones
		DB::table('type_subscriptions')->insert([
			'name' => '1 Mes',
			'month' => '1',
		]);
		DB::table('type_subscriptions')->insert([
			'name' => '6 Meses',
			'month' => '6',
		]);
		DB::table('type_subscriptions')->insert([
			'name' => '12 Meses',
			'month' => '12',
		]);

		//USUARIOS
		DB::table('users')->insert([
			'name' => 'Erick Gordillo',
			'email' => 'egordilloayala@gmail.com',
			'password' => Hash::make('3r1ck'),
			'role_id' => '1',
		]);
		
		DB::table('users')->insert([
			'name' => 'Erick Gordillo A',
			'email' => 'erick.gordillo.a@gmail.com',
			'password' => Hash::make('3r1ck'),
			'role_id' => '2',
		]);
		

		//SUSCRIPCIONES
		for ($i=1; $i < 20; $i++) { 
			DB::table('subscriptions')->insert([
				'nombre' => 'subscription '.$i,
				'detalle' => 'subscriptions '.$i,
				'monto' => range(100,150)[$i],
				'imagen' => 'http://suscripciones.paqucafe.com/storage/files/a8J3wIKqGPPPo1VSiqMuMsaC8aQbgA9GtMbAh8mu.webp'
			]);
		}
	}
}

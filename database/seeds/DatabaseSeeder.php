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
			'password' => Hash::make('123'),
			'role_id' => '1',
		]);
		
		DB::table('users')->insert([
			'name' => 'Erick Gordillo A',
			'email' => 'erick.gordillo.a@gmail.com',
			'password' => Hash::make('123'),
			'role_id' => '2',
		]);
		

		//SUSCRIPCIONES
		for ($i=0; $i < 50; $i++) { 
			DB::table('subscriptions')->insert([
				'nombre' => 'subscription '.$i,
				'detalle' => 'subscriptions '.$i,
				'monto' => range(100,150)[$i],
				//'imagen' => 'https://paqucafe.com/wp-content/uploads/2021/08/CAJA-DOBLE.jpg'
				'imagen' => 'storage/files/uGMloDpGaNSXXhNENNeZZqPSgkDShoJXKso64HUM.webp'
			]);
		}
	}
}

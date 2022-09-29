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
		DB::table('users')->insert([
			'name' => 'Erick Gordillo',
			'email' => 'egordilloayala@gmail.com',
			'password' => Hash::make('123'),
		]);

		DB::table('subscriptions')->insert([
			'nombre' => 'subscription 1',
			'detalle' => 'subscriptions 1',
			'monto' => '0',
		]);

		DB::table('subscriptions')->insert([
			'nombre' => 'subscriptions 2',
			'detalle' => 'subscriptions 2',
			'monto' => '0',
		]);

		DB::table('subscriptions')->insert([
			'nombre' => 'subscriptions 3',
			'detalle' => 'subscriptions 3',
			'monto' => '150',
		]);

		DB::table('subscriptions')->insert([
			'nombre' => 'Otros',
			'detalle' => 'Otros',
			'monto' => '0',
		]);
	}
}

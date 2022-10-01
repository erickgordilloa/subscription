<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('customers', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('nombre', 250)->nullable();
			$table->string('apellido', 250)->nullable();
			$table->string('tipo_identidad', 5)->nullable();
			$table->string('identidad', 20)->nullable();
			$table->string('correo', 250)->nullable();
			$table->string('direccion', 250)->nullable();
			$table->string('celular', 20)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('customers');
	}
}

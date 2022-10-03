<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('subscriptions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('nombre', 250)->nullable();
			$table->string('detalle', 300)->nullable();
			$table->double('monto', 10, 4)->nullable();
			$table->text('imagen')->nullable();
			$table->char('estado', 1)->default('A');
			$table->char('es_editable',1)->nullable();
			$table->text('texto')->nullable();
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
		Schema::dropIfExists('subscriptions');
	}
}

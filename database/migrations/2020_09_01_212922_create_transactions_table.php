<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('transactions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('id_customer');
			$table->double('amount', 10, 4)->nullable();
			$table->bigInteger('subscription_id')->nullable();
			$table->text('comentario')->nullable();
			$table->string('authorization_code', 250)->nullable();
			$table->string('carrier_code', 250)->nullable();
			$table->string('dev_reference', 250)->nullable();
			$table->string('id_response', 250)->nullable();
			$table->string('message', 250)->nullable();
			$table->string('payment_date', 250)->nullable();
			$table->string('transaction_reference', 250)->nullable();
			$table->string('status', 250)->nullable();
			$table->bigInteger('status_detail')->nullable();
			$table->char('refund',2)->nullable();
			$table->string('detail_refund',250)->nullable();
			$table->bigInteger('user_refund')->nullable();
			$table->dateTime('date_refund')->nullable();
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
		Schema::dropIfExists('transactions');
	}
}

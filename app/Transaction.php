<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
	//pertene a
	public function tipo() {
		return $this->belongsTo(Subscription::class, 'reference');
	}

	//pertene a
	public function persona() {
		return $this->belongsTo(Customer::class, 'id_customer');
	}
}

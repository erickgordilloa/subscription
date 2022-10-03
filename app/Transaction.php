<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Transaction extends Model {
	use SoftDeletes;
	//pertene a
	public function tipo() {
		return $this->belongsTo(Subscription::class, 'reference');
	}

	//pertene a
	public function persona() {
		return $this->belongsTo(Customer::class, 'id_customer');
	}
}

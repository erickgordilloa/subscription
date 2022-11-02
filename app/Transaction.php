<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model {
	use SoftDeletes;

	//pertene a
	public function persona() {
		return $this->belongsTo(Customer::class, 'id_customer');
	}

	//pertene a
	public function user() {
		return $this->belongsTo(User::class);
	}
	
	//pertene a
	public function subscription() {
		return $this->belongsTo(Subscription::class);
	}

	public function reference() {
		return $this->belongsTo(UserSubscription::class,'dev_reference');
	}
	
	//pertene a
	public function card() {
		return $this->belongsTo(Card::class);
	}
}

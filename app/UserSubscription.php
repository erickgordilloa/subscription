<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use SoftDeletes;

    public function user() {
		return $this->belongsTo(User::class);
	}
    
    public function subscription() {
		return $this->belongsTo(Subscription::class);
	}
    
    public function typeSubscription() {
		return $this->belongsTo(TypeSubscription::class,'type_subscription_id');
	}
}

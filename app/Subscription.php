<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function adjunto()
    {
    	return $this->hasMany(SubscriptionFiles::class, 'subscription_id');
    }
}

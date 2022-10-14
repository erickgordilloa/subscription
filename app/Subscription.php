<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;
    
    public function adjunto()
    {
    	return $this->hasMany(SubscriptionFiles::class, 'subscription_id');
    }
}

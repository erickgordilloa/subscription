<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class SubscriptionFiles extends Model
{
    use SoftDeletes;
    protected $table = 'subscriptions_files';
}

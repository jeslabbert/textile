<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionSplit extends Model
{
    protected $fillable = [
        'user_id',
        'team_id',
        'role_id',
        'commission',
        'paypal_id'
    ];

}

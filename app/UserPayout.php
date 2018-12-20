<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPayout extends Model
{

    protected $primaryKey = 'payout_id';

    protected $fillable = [
        'payoutprovider_id',
        'user_id',
        'provider_user_details'
    ];

}

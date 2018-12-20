<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayoutProvider extends Model
{
    protected $primaryKey = 'payoutprovider_id';

    protected $fillable = [
        'name',
        'api_link'
    ];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeteredInvoice extends Model
{
    protected $primaryKey = 'meteredinvoice_id';

    protected $fillable = [
        'user_id',
        'team_id',
        'provider_id',
        'total',
        'description',
        'tax,',
        'card_country',
        'billing_state',
        'billing_zip',
        'billing_country',
        'vat_id'
    ];

}

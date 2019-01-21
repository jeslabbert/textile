<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionCalculation extends Model
{
    protected $primaryKey = 'comcalc_id';

    protected $fillable = [
        'invoice_id',
        'invoice_value',
        'billing_period',
        'team_id',
        'global_percentage',
        'comm_percentage',
        'comm_split',
        'comm_type',
        'comm_split',
        'comm_type',
        'comm_value',
        'user_id',
        'status'
    ];
}

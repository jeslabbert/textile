<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteTotal extends Model
{
    protected $primaryKey = 'sitetotal_id';

    protected $fillable = [
        'site_id',
        'portfolio_total',
        'company_total',
        'bu_id',
        'department_total',
        'employeelevel_total',
        'task_total',
        'task_active',
        'billing_month',
        'billing_year',
        'task_transactions_total',
        'mobile_user_total',
        'cloud_user_total',
        'both_user_total',
        'request_user_total',
    ];

}

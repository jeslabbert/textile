<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraModuleBilling extends Model
{
    protected $primaryKey = 'module_billing_id';

    protected $fillable = [
        'name',
        'description'
    ];
}

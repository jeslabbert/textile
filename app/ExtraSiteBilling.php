<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraSiteBilling extends Model
{
    protected $primaryKey = 'site_extra_id';

    protected $fillable = [
        'site_id',
        'module_billing_id',
        'custom_name',
        'custom_description',
        'total',
        'price',

    ];

    public function ModuleBilling()
    {
        return $this->hasOne('App\ExtraModuleBilling', 'module_billing_id', 'module_billing_id');
    }
}



<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'setting_type',
        'setting_name',
        'setting_value',
        'setting_string'
    ];
}

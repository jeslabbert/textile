<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableModule extends Model
{
    protected $primaryKey = 'module_id';

    protected $fillable = [
        'module_name',
        'type',
    ];
}

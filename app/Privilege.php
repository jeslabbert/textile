<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $primaryKey = 'privilege_id';

    protected $fillable = [
        'name',
    ];
}

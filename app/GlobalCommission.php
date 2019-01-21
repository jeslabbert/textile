<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalCommission extends Model
{
    protected $primaryKey = 'globalcomm_id';

    protected $fillable = [
        'team_id',
        'role_id',
        'comm1',
        'comm2',
        'comm3',
        'global_commission'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamCommission extends Model
{
    protected $primaryKey = 'commission_id';

    protected $fillable = [
        'team_id',
        'first_name',
        'first_split',
        'first_user_id',
        'second_name',
        'second_split',
        'second_user_id',
    ];
}


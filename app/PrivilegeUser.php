<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivilegeUser extends Model
{
    protected $fillable = [
        'user_id',
        'team_id',
        'privilege_id'
    ];
}

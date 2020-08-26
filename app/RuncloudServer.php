<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RuncloudServer extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'ip_address',
        'server_id',
        'server_user',
        'server_password',
        'api_key',
        'api_key'
    ];
}

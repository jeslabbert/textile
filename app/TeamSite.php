<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamSite extends Model
{
    protected $fillable = [
        'fqdn',
        'website_id',
        'team_id',
        'creator',
        'creator_email'
    ];
}


<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamSite extends Model
{
    protected $fillable = [
        'fqdn',
        'historical_fqdn',
        'website_id',
        'team_id',
        'creator',
        'creator_email',
        'tenant_sitename',
        'site_url',
        'site_port'
    ];
}


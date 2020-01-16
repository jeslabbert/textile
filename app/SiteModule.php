<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteModule extends Model
{
    protected $primaryKey = 'site_module_id';

    protected $fillable = [
        'team_id',
        'site_id',
        'module_id',
        'hard_lock',
        'soft_lock'
    ];
}

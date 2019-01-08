<?php

namespace App;

use Laravel\Spark\Team as SparkTeam;

class Team extends SparkTeam
{
    //
    public function Site()
    {
        return $this->hasOne('App\TeamSite', 'team_id', 'id');
    }
}

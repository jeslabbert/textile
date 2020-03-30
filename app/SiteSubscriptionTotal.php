<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSubscriptionTotal extends Model
{
    protected $primaryKey = 'site_subscription_total_id';

    protected $fillable = [
        'site_id',
        'user_total',
        'plan',
        'doc_edited_total',
        'doc_created_total',
        'doc_exported_total',
        'doc_viewed_total',
        'doc_total',
        'wallboard_total',
        'add_wallboard_price',
        'add_user_price',
        'add_doc_price'
    ];

    public function Site()
    {
        return $this->hasOne('App\TeamSite', 'id', 'site_id');
    }
}

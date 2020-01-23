<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionTotal extends Model
{
    protected $primaryKey = 'subscription_total_id';

    protected $fillable = [
        'user_total',
        'plan',
        'doc_edited_total',
        'doc_created_total',
        'doc_exported_total',
        'doc_viewed_total',
        'doc_total',
        'doc_active_total',
        'add_user_price',
        'add_doc_price'

    ];
}

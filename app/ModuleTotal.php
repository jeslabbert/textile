<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleTotal extends Model
{
    protected $primaryKey = 'moduletotal_id';

    protected $fillable = [
        'site_id',
        'user_total',
        'doc_edited_total',
        'doc_exported_total',
        'doc_viewed_total',
        'doc_total',
        'doc_active_total',
        'billing_month',
        'billing_year',
    ];
}

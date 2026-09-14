<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionPlan extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'priority',
        'time_suggestion',
        'is_completed',
        'plan_date'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name',
        'appliance_id',
        'user_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'power_consumed_kwh',
        'cost'
    ];
}
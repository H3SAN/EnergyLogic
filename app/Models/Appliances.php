<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appliances extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'appliances';

    protected $fillable = [
        'name',
        'power_rating_watts',
        'status',
        'schedule_time',
        'daily_usage_hours',
        'energy_efficiency_rating'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'power_rating_watts' => 'decimal:2',
        'daily_usage_hours' => 'decimal:2',
        'schedule_time' => 'datetime:H:i:s',
        'last_used' => 'datetime',
    ];
}
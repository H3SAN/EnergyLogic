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

    protected $fillable = ['user_id', 'name', 'power_consumption', 'status'];

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'appliance_schedule')
                    ->withPivot('start_time', 'end_time', 'duration_minutes')
                    ->withTimestamps();
    }
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'power_consumption' => 'decimal:2',
        'daily_usage_hours' => 'decimal:2',
        'schedule_time' => 'datetime:H:i:s',
        'last_used' => 'datetime',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = ['user_id', 'name', 'start_time', 'end_time',];

    public function applianceAssignments(): HasMany
    {
        return $this->hasMany(ApplianceSchedule::class);
    }

    public function appliances()
{
    return $this->belongsToMany(Appliances::class, 'appliance_schedule','schedule_id', 'appliance_id')
                ->withPivot('start_time', 'end_time', 'duration_minutes')
                ->withTimestamps();
}

}


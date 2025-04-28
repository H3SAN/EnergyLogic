<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplianceSchedule extends Model
{
    protected $table = 'appliance_schedule';

    protected $fillable = [
        'appliance_id',
        'schedule_id',
        'start_time',
        'end_time',
        'estimated_cost',
        'duration',
    ];
    

    public function appliance()
    {
        return $this->belongsTo(Appliances::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}

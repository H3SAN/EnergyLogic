<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplianceSchedule extends Model
{
    protected $table = 'appliance_schedule';

    protected $fillable = [
        'appliance_id',
        'schedule_id',
        'timeslot_id',
        'estimated_cost',
        'duration',
    ];
    

    public function appliance()
    {
        return $this->belongsTo(Appliances::class);
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}

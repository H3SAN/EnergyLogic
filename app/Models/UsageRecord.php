<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageRecord extends Model
{
    use HasFactory;

    protected $table = 'usage_records'; // Ensure this matches the actual table name

    protected $fillable = [
        'appliance_id',
        'user_id',
        'schedule_id',
        'time_used',
        'power_consumed',
        'cost'
    ];

    public function appliance() {
        return $this->belongsTo(Appliances::class, 'appliance_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {
    protected $fillable = [
        'user_id',
        'name', 
        'description', 
        'is_active',
    ];

    public function appliances() {
        return $this->belongsToMany(Appliances::class, 'appliance_schedule','schedule_id', 'appliance_id');
    }
    
}


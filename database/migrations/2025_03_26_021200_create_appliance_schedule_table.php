<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplianceScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('appliance_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('appliance_id');
            $table->time('start_time'); // new start time column
            $table->time('end_time');   // new end time column
            $table->integer('duration_minutes');
            $table->float('estimated_cost');
            $table->float('cost_saved');
            $table->float('power_consumed');
            $table->timestamps();
    
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('appliance_id')->references('id')->on('appliances')->onDelete('cascade');
        });
    }
    


    public function down()
    {
        Schema::dropIfExists('appliance_schedule');
    }
}

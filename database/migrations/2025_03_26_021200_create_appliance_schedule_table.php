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
        $table->string('timeslot');
        $table->integer('duration_minutes');
        $table->float('estimated_cost');
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

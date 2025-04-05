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
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('appliance_id')->constrained()->onDelete('cascade');
            $table->integer('timeslot_id');
            $table->decimal('estimated_cost', 8, 2)->nullable();
            $table->float('duration')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appliance_schedule');
    }
}

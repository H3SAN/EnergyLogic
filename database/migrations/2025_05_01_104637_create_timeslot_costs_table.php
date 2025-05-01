<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeslotCostsTable extends Migration
{
    public function up()
    {
        Schema::create('timeslot_costs', function (Blueprint $table) {
            $table->id();
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('cost_per_kwh', 5, 2);
            $table->string('label')->nullable(); // e.g., peak, off-peak
            $table->unsignedTinyInteger('day_of_week')->nullable(); // 0=Sunday, 6=Saturday
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('timeslot_costs');
    }
}

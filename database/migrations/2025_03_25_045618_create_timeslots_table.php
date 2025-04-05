<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->decimal('rate_per_kwh', 10, 4); // Cost per kWh
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('timeslots');
    }
};
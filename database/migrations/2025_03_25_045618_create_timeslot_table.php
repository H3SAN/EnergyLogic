<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('timeslot', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('rate_per_kwh', 10, 4); // Cost per kWh
        });
    }

    public function down() {
        Schema::dropIfExists('timeslot');
    }
};
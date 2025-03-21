<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('usage_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appliance_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration_minutes'); // Auto-calculated in controller
            $table->decimal('power_consumed_kwh', 10, 3); // kWh
            $table->decimal('cost', 10, 2); // Auto-calculated
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('usage_records');
    }
};


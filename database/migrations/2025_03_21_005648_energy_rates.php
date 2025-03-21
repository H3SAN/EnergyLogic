<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('energy_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate_per_kwh', 10, 4); // Cost per kWh
            $table->date('effective_from');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('energy_rates');
    }
};
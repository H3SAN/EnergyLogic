<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('power_rating_watts', 10, 2);
            $table->enum('status', ['on', 'off', 'standby'])->default('on');
            $table->time('schedule_time')->nullable();
            $table->decimal('daily_usage_hours', 4, 2)->default(0.00);
            $table->enum('energy_efficiency_rating', ['A++', 'A+', 'A', 'B', 'C', 'D', 'E'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appliances');
    }
};

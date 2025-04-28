<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('usage_records', function (Blueprint $table) {
            $table->id();
            $table->integer('appliance_id');
            $table->integer('user_id');
            $table->integer('schedule_id');
            $table->integer('time_used');
            $table->decimal('power_consumed', 10, 3);
            $table->decimal('cost', 10, 3);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('usage_records');
    }
};

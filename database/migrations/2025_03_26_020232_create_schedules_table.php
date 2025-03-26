<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('schedules');
    }
};

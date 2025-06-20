<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sensor_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('device_id');
            $table->string('device_name');
            $table->unsignedInteger('sub');
            $table->unsignedInteger('session_number');
            $table->float('value_1')->nullable();
            $table->string('unit_1')->nullable();
            $table->float('value_2')->nullable();
            $table->string('unit_2')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_sessions');
    }
};

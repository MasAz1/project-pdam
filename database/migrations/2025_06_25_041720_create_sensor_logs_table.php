<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->float('value1')->nullable();
            $table->float('value2')->nullable();
            $table->float('volume')->nullable();
            $table->float('kelembapan')->nullable();
            $table->float('suhu')->nullable();
            $table->string('recorded_at')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
}

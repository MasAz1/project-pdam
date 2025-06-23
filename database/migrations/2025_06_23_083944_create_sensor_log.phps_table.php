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
            $table->string('sensor_name')->nullable(); // Optional: kalau tidak selalu ada
            $table->float('debitair')->nullable();
            $table->float('tekanan')->nullable();
            $table->float('kelembaban')->nullable();
            $table->float('suhu')->nullable();
            $table->float('baterai')->nullable();
            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
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

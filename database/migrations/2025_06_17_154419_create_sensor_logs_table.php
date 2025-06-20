<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorLogsTable extends Migration
{
    public function up()
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('cascade'); // Relasi ke tabel devices
            $table->float('debit');
            $table->float('baterai');
            $table->float('kekeruhan');
            $table->float('ph');
            $table->float('suhu');
            $table->timestamp('recorded_at')->nullable(); // Waktu pencatatan data sensor
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_logs');
    }
}

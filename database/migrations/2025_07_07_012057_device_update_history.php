<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_update_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices');
            $table->foreignId('firmware_id')->constrained('firmwares');
            $table->string('status'); // success, failed, pending
            $table->text('log')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

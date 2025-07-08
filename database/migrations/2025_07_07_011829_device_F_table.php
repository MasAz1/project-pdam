<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique(); // DEV-001245
            $table->string('name');
            $table->string('model'); // Model A, Model B, dll
            $table->string('current_firmware_version')->nullable();
            $table->string('target_firmware_version')->nullable();
            $table->enum('status', ['online', 'offline', 'updating'])->default('offline');
            $table->string('group')->nullable(); // Office, Warehouse, Retail
            $table->timestamp('last_online_at')->nullable();
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

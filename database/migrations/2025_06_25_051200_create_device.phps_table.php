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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->integer('project');
            $table->string('name');
            $table->string('location')->nullable();
            $table->integer('battery')->nullable();
            $table->string('sdcard')->nullable();
            $table->string('firmware')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->string('last_debug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};

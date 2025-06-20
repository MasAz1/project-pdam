<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->string('sdcard_status')->nullable();
            $table->integer('sdcard_used')->nullable();
            $table->integer('sdcard_total')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['sdcard_status', 'sdcard_used', 'sdcard_total']);
        });
    }
};

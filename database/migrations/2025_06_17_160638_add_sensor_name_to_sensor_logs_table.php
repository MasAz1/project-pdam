<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sensor_logs', function (Blueprint $table) {
            $table->string('sensor_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sensor_logs', function (Blueprint $table) {
            $table->dropColumn('sensor_name');
        });
    }
};

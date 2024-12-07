<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSensorTypeIdToSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sensors', function (Blueprint $table) {
            $table->foreignId('sensor_type_id')->nullable()->constrained('sensor_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sensors', function (Blueprint $table) {
            $table->dropForeign(['sensor_type_id']);
            $table->dropColumn('sensor_type_id');
        });
    }
}

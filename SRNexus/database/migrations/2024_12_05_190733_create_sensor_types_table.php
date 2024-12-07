<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('description')->nullable(); // Descripción opcional
            $table->timestamps();
        });

        // Poblamos con datos iniciales
        DB::table('sensor_types')->insert([
            ['type' => 'Type 1', 'description' => ''],
            ['type' => 'Type 2', 'description' => ''],
            ['type' => 'Type 3', 'description' => ''],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_types');
    }
}

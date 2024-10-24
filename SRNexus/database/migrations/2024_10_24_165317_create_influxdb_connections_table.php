<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluxdbConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influxdb_connections', function (Blueprint $table) {
            $table->id(); // Clave primaria 'id'
            $table->unsignedBigInteger('client_id'); // Campo de clave foránea hacia 'clients'

            $table->string('name'); // Nombre de la conexión
            $table->string('url');
            $table->text('token');
            $table->string('bucket');
            $table->string('organization');

            $table->timestamps(); // Campos 'created_at' y 'updated_at'

            // Definición de la clave foránea
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influxdb_connections');
    }
}

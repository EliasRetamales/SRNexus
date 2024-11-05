<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInfluxdbConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('influxdb_connections', function (Blueprint $table) {
            // Eliminar la relación existente con Client
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');

            // Agregar la relación con Project
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('influxdb_connections', function (Blueprint $table) {
            // Eliminar la relación con Project
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');

            // Reagregar la relación con Client
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('id');

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('set null')
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
        Schema::table('users', function (Blueprint $table) {
            // Primero eliminamos la clave foránea
            $table->dropForeign(['client_id']);
            // Luego eliminamos la columna
            $table->dropColumn('client_id');
        });
    }
}

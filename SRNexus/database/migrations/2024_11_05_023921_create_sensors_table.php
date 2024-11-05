<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Relación con Project
            $table->foreignId('safe_limit_id')->nullable()->constrained('safe_limits')->onDelete('set null'); // Relación opcional con SafeLimite
            $table->string('name');
            $table->boolean('enable')->default(true);
            $table->float('range_max');
            $table->float('range_min');
            $table->float('error');
            $table->string('sensitivity')->nullable(); // Campo opcional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
}

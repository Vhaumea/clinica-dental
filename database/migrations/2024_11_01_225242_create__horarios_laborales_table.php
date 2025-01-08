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
        Schema::create('horarios_laborales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->dateTime('start_datetime')->nullable(); 
            $table->dateTime('end_datetime')->nullable();   
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo'); 
            $table->text('notes')->nullable(); 
            $table->enum('schedule_type', ['Normal', 'Extra'])->default('Normal'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_horarios_laborales');
    }
};

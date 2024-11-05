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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con el usuario
            $table->dateTime('start_datetime')->nullable(); // Combina fecha y hora de inicio
            $table->dateTime('end_datetime')->nullable();   // Combina fecha y hora de fin
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo'); // Estado del horario
            $table->text('notes')->nullable(); // Notas adicionales
            $table->enum('schedule_type', ['Normal', 'Extra', 'Vacaciones'])->default('Normal'); // Tipo de horario
            $table->timestamps(); // Timestamps para created_at y updated_at
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

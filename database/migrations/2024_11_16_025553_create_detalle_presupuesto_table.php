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
        Schema::create('detalle_presupuesto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained('presupuesto')->onDelete('cascade'); // Clave foránea con 'presupuesto'
            $table->foreignId('pieza_dental_id')->nullable()->constrained('pieza_dental')->onDelete('set null'); // Clave foránea opcional
            $table->string('tratamiento', 500); // Tratamiento como string de longitud máxima 500
            $table->enum('tratamiento_estado', ['pendiente', 'en proceso', 'completado'])->default('pendiente'); // Estado del tratamiento
            $table->decimal('precio'); // Valoración como decimal
            $table->string('observaciones', 255)->nullable(); // Observaciones opcionales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_presupuesto');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notas_evolucion', function (Blueprint $table) {
            $table->id(); // Crea un campo 'id' autoincremental
            $table->foreignId('cita_id')->constrained()->onDelete('cascade'); // Relación con citas
            $table->text('descripcion'); // Campo para la descripción de la nota           
            $table->dateTime('fecha_nota')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('observaciones_evolucion')->nullable(); // Campo opcional para observaciones adicionales
            $table->enum('estado_nota', ['Activo', 'Inactivo'])->default('Activo'); // Campo para el estado
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_evolucion');
    }
};

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
        Schema::create('citas', function (Blueprint $table) {
            $table->id(); // Columna 'id' de tipo INT AUTO_INCREMENT
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade'); // Clave foránea con la tabla 'pacientes'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clave foránea con la tabla 'users'
            $table->foreignId('presupuesto_id')->nullable()->constrained('presupuesto')->onDelete('set null'); // Clave foránea con la tabla 'presupuestos', opcional
            $table->date('fecha'); // Columna para la fecha
            $table->time('hora'); // Columna para la hora
            $table->string('motivo', 255)->nullable(); // Columna 'motivo' de tipo VARCHAR(255), puede ser NULL
            $table->enum('origen', ['Urgencia', 'Presupuesto', 'Consulta']); // Enum para 'origen'
            $table->enum('estado', ['Pendiente', 'Confirmada', 'Cancelada', 'Completada'])->default('Pendiente'); // Enum para 'estado', valor por defecto 'Pendiente'
            $table->string('observaciones', 255)->nullable(); // Columna 'observaciones' de tipo VARCHAR(255), puede ser NULL
            $table->timestamps(0); // Laravel maneja automáticamente created_at y updated_at como DATETIME

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

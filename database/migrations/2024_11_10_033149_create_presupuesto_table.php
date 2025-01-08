<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('presupuesto', function (Blueprint $table) {
            $table->id(); // ID auto incremental y clave primaria
            $table->foreignId('paciente_id')->constrained('pacientes'); // Clave foránea referenciando a pacientes
            $table->integer('subtotal'); // Subtotal como entero
            $table->integer('descuento'); // Descuento como entero
            $table->integer('total_final'); // Total final como entero
            $table->decimal('saldo_pendiente');
            $table->date('fecha'); // Campo de fecha
            $table->enum('estado', ['Pendiente', 'En proceso', 'Rechazado','Completado'])->default('Pendiente'); // Estado del presupuesto
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuesto');
    }
};
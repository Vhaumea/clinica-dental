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
        Schema::create('presupuesto', function (Blueprint $table) {
            $table->id(); // ID auto incremental y clave primaria
            $table->foreignId('paciente_id')->constrained('pacientes'); // Clave foránea referenciando a pacientes
            $table->integer('subtotal'); // Subtotal como entero
            $table->integer('descuento'); // Descuento como entero
            $table->integer('total_final'); // Total final como entero
            $table->decimal('saldo_pendiente', 10, 2); // 
            $table->enum('estado', ['pendiente', 'en proceso', 'rechazado'])->default('pendiente'); // Estado del presupuesto
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
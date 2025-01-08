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
            $table->foreignId('presupuesto_id')->constrained('presupuesto')->onDelete('cascade'); 
            $table->string('pieza', 10); 
            $table->string('tratamiento', 500); 
            $table->enum('tratamiento_estado', ['Pendiente', 'En proceso', 'Completado'])->default('Pendiente'); 
            $table->decimal('precio'); 
            $table->string('observaciones', 255)->nullable(); 
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

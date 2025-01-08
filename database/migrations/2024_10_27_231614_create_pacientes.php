<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->unique();
            $table->string('nombre');
            $table->string('apellido_p', 200);
            $table->string('apellido_m', 200);
            $table->enum('sexo', ['Masculino', 'Femenino']);
            $table->date('birth');
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->string('region');
            $table->string('comuna');
            $table->string('direccion');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};

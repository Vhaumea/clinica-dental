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
        Schema::create('fichas_clinicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->string('medicamentos')->nullable();
            $table->string('alergias')->nullable();
            $table->boolean('embarazo')->default(false);
            $table->integer('tiempo_gestacion')->nullable();
            $table->boolean('enfermedades_sistemicas')->default(false);
            $table->boolean('hipertension')->default(false);
            $table->boolean('diabetes')->default(false);
            $table->string('otros')->nullable();
            $table->string('reaccion_alergica_medicamento')->nullable();
            $table->string('reaccion_alergica_anestesia')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
    
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_clinicas');
    }
};

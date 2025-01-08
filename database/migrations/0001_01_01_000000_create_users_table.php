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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['Recepcionista', 'Dentista', 'Admin'])->default('Recepcionista');
            $table->string('rut')->unique();
            $table->string('name', 100);
            $table->string('apellido_p', 200);
            $table->string('apellido_m', 200);
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['Masculino', 'Femenino']);
            $table->string('email')->unique();
            $table->string('phone', 15);
            $table->string('region');
            $table->string('comuna');
            $table->string('direccion');
            $table->string('password');
            $table->string('image')->nullable(); 
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->rememberToken();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
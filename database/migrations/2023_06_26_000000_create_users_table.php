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
            $table->unsignedBigInteger('DNI')->primary();
            $table->text('Nombres')->nullable();
            $table->text('Apellidos')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('Tipo',['Estudiante','Empresa','Administrador']);
            $table->unsignedBigInteger('Carrera')->nullable();
            $table->string('Empresa_nombre');
            $table->unsignedBigInteger('Telefono');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('Carrera')->references('Cod_carreras')
                ->on('Carreras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

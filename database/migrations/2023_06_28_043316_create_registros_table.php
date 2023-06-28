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
        Schema::create('registros', function (Blueprint $table) {
            $table->unsignedBigInteger('Cod_registros')->primary();
            $table->date('Fecha');
            $table->string('Titulo');
            $table->string('Descripcion');
            $table->string('Categoria');
            $table->string('Tiempo');
            $table->string('Experiencia');
            $table->string('Estilo');
            $table->unsignedBigInteger('Carrera_Profesional');
            $table->timestamps();

            $table->foreign('Carrera_Profesional')->references('Cod_carreras')
                ->on('carreras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};

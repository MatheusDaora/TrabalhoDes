<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id('id_equipamento');
            $table->unsignedBigInteger('id_cliente');
            $table->string('numero_serie', 100);
            $table->string('modelo', 100);
            $table->string('marca', 50);
            $table->string('imagem', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};

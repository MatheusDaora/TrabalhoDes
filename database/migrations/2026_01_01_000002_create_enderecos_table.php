<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id('id_endereco');
            $table->unsignedBigInteger('id_cliente');
            $table->string('tipo_endereco', 50)->default('Residencial');
            $table->string('rua', 150);
            $table->string('numero', 20);
            $table->string('bairro', 100);
            $table->string('cep', 15);
            $table->string('cidade', 100);
            $table->string('estado', 2);
            $table->boolean('principal')->default(false);
            $table->timestamps();

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};

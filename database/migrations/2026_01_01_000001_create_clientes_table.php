<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nome_razao_social', 150);
            $table->string('cpf_cnpj', 20)->unique();
            $table->string('email', 100);
            $table->string('telefone', 20);
            $table->date('data_nascimento')->nullable();
            $table->date('data_cadastro');
            $table->string('status', 20)->default('Ativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

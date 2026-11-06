<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id('id_os');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_funcionario');
            $table->unsignedBigInteger('id_equipamento');
            $table->date('data_abertura');
            $table->text('diagnostico');
            $table->decimal('orcamento', 10, 2)->default(0.00);
            $table->string('status', 50)->default('Em Análise');
            $table->date('data_conclusao')->nullable();
            $table->timestamps();

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->onDelete('cascade');

            $table->foreign('id_funcionario')
                  ->references('id_funcionario')
                  ->on('funcionarios')
                  ->onDelete('cascade');

            $table->foreign('id_equipamento')
                  ->references('id_equipamento')
                  ->on('equipamentos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordens_servico');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->unsignedBigInteger('id_cliente');
            $table->date('data_pedido');
            $table->string('status', 50)->default('Pendente');
            $table->decimal('valor_total', 10, 2)->default(0.00);
            $table->boolean('requer_entrega')->default(false);
            $table->unsignedBigInteger('id_endereco_entrega')->nullable();
            $table->timestamps();

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->onDelete('cascade');

            $table->foreign('id_endereco_entrega')
                  ->references('id_endereco')
                  ->on('enderecos')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};

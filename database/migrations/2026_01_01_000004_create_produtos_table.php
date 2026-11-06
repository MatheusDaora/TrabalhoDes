<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id('id_produto');
            $table->string('nome', 150);
            $table->string('categoria', 50);
            $table->decimal('preco_unitario', 10, 2);
            $table->integer('quantidade_estoque')->default(0);
            $table->string('marca', 50);
            $table->string('tipo_produto', 50);
            $table->string('imagem', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};

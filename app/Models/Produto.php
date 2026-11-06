<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    protected $primaryKey = 'id_produto';

    protected $fillable = [
        'nome',
        'categoria',
        'preco_unitario',
        'quantidade_estoque',
        'marca',
        'tipo_produto',
        'imagem',
    ];

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class, 'id_produto', 'id_produto');
    }
}

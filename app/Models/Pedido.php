<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_cliente',
        'data_pedido',
        'status',
        'valor_total',
        'requer_entrega',
        'id_endereco_entrega',
    ];

    protected $casts = [
        'requer_entrega' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function enderecoEntrega()
    {
        return $this->belongsTo(Endereco::class, 'id_endereco_entrega', 'id_endereco');
    }

    public function itens()
    {
        return $this->hasMany(ItemPedido::class, 'id_pedido', 'id_pedido');
    }
}

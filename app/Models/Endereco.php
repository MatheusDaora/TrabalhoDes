<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';
    protected $primaryKey = 'id_endereco';

    protected $fillable = [
        'id_cliente',
        'tipo_endereco',
        'rua',
        'numero',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'principal',
    ];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_endereco_entrega', 'id_endereco');
    }

    public function getEnderecoFormatadoAttribute()
    {
        return "{$this->rua}, {$this->numero} - {$this->bairro}, {$this->cidade}/{$this->estado}";
    }
}

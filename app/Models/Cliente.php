<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'nome_razao_social',
        'cpf_cnpj',
        'email',
        'telefone',
        'data_nascimento',
        'data_cadastro',
        'status',
    ];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'id_cliente', 'id_cliente');
    }

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class, 'id_cliente', 'id_cliente');
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class, 'id_cliente', 'id_cliente');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente', 'id_cliente');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    use HasFactory;

    protected $table = 'ordens_servico';
    protected $primaryKey = 'id_os';

    protected $fillable = [
        'id_cliente',
        'id_funcionario',
        'id_equipamento',
        'data_abertura',
        'diagnostico',
        'orcamento',
        'status',
        'data_conclusao',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario', 'id_funcionario');
    }

    // Relacionamento 1:1 com Equipamento
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class, 'id_equipamento', 'id_equipamento');
    }
}

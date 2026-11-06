<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';
    protected $primaryKey = 'id_equipamento';

    protected $fillable = [
        'id_cliente',
        'numero_serie',
        'modelo',
        'marca',
        'imagem',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    // Relacionamento 1:1 com Ordem de Serviço
    public function ordemServico()
    {
        return $this->hasOne(OrdemServico::class, 'id_equipamento', 'id_equipamento');
    }
}

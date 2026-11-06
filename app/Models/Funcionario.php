<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';
    protected $primaryKey = 'id_funcionario';

    protected $fillable = [
        'nome',
        'email',
        'perfil',
        'data_admissao',
    ];

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class, 'id_funcionario', 'id_funcionario');
    }
}

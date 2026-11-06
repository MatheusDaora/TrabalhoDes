<?php

namespace App\Http\Controllers;

use App\Models\OrdemServico;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class GraficoController extends Controller
{
    /**
     * Painel com os dois gráficos analíticos gerados com dados reais do banco de dados.
     */
    public function index()
    {
        // Gráfico 1: Ordens de Serviço por Status (Formato: Pizza / Rosca - Doughnut)
        $osPorStatus = OrdemServico::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderBy('total', 'desc')
            ->get();

        $labelsOS = $osPorStatus->pluck('status')->toArray();
        $valoresOS = $osPorStatus->pluck('total')->toArray();

        // Gráfico 2: Quantidade de Estoque por Categoria de Produto (Formato: Barras - Bar)
        $estoquePorCategoria = Produto::select('categoria', DB::raw('sum(quantidade_estoque) as total_estoque'))
            ->groupBy('categoria')
            ->orderBy('total_estoque', 'desc')
            ->get();

        $labelsCategoria = $estoquePorCategoria->pluck('categoria')->toArray();
        $valoresCategoria = $estoquePorCategoria->pluck('total_estoque')->toArray();

        return view('grafico.index', compact(
            'labelsOS',
            'valoresOS',
            'labelsCategoria',
            'valoresCategoria'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\OrdemServico;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClientes = Cliente::count();
        $totalEquipamentos = Equipamento::count();
        $totalOS = OrdemServico::count();
        $totalOSConcluidas = OrdemServico::where('status', 'Concluído')->count();
        $totalOSEmAndamento = OrdemServico::whereIn('status', ['Em Análise', 'Em Reparo', 'Aprovado', 'Aguardando Peça'])->count();
        $totalProdutos = Produto::count();
        $totalEstoque = Produto::sum('quantidade_estoque');
        $faturamentoPedidos = Pedido::where('status', '!=', 'Cancelado')->sum('valor_total');

        $ultimasOS = OrdemServico::with(['cliente', 'funcionario', 'equipamento'])
            ->latest('data_abertura')
            ->take(5)
            ->get();

        $produtosEstoqueBaixo = Produto::orderBy('quantidade_estoque', 'asc')
            ->take(5)
            ->get();

        // Dados para Gráfico 1: Status das Ordens de Serviço (Pizza / Doughnut)
        $osStatusData = OrdemServico::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Dados para Gráfico 2: Produtos e Estoque por Categoria (Barras)
        $produtosPorCategoria = Produto::select('categoria', DB::raw('sum(quantidade_estoque) as total_estoque'))
            ->groupBy('categoria')
            ->pluck('total_estoque', 'categoria')
            ->toArray();

        return view('dashboard', compact(
            'totalClientes',
            'totalEquipamentos',
            'totalOS',
            'totalOSConcluidas',
            'totalOSEmAndamento',
            'totalProdutos',
            'totalEstoque',
            'faturamentoPedidos',
            'ultimasOS',
            'produtosEstoqueBaixo',
            'osStatusData',
            'produtosPorCategoria'
        ));
    }
}

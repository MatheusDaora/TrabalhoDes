<?php

namespace App\Http\Controllers;

use App\Models\OrdemServico;
use App\Models\Produto;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    /**
     * Tela inicial com a lista de relatórios disponíveis.
     */
    public function index()
    {
        return view('relatorio.index');
    }

    /**
     * Relatório 1 em PDF / Impressão: Listagem de Ordens de Serviço.
     */
    public function ordensServico(Request $request)
    {
        $status = $request->input('status');

        $query = OrdemServico::with(['cliente', 'funcionario', 'equipamento']);

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $ordens = $query->orderBy('data_abertura', 'desc')->get();

        $totalOrdens = $ordens->count();
        $valorTotalOrcado = $ordens->sum('orcamento');
        $totalConcluidas = $ordens->where('status', 'Concluído')->count();
        $totalEmAndamento = $ordens->whereIn('status', ['Em Análise', 'Em Reparo', 'Aprovado', 'Aguardando Peça'])->count();

        return view('relatorio.ordens_servico', compact(
            'ordens',
            'totalOrdens',
            'valorTotalOrcado',
            'totalConcluidas',
            'totalEmAndamento',
            'status'
        ));
    }

    /**
     * Relatório 2 em PDF / Impressão: Listagem de Produtos e Saldo de Estoque.
     */
    public function produtos(Request $request)
    {
        $categoria = $request->input('categoria');

        $query = Produto::query();

        if (!empty($categoria)) {
            $query->where('categoria', $categoria);
        }

        $produtos = $query->orderBy('categoria')->orderBy('nome')->get();

        $totalItens = $produtos->count();
        $totalUnidades = $produtos->sum('quantidade_estoque');
        $valorEstoque = $produtos->sum(function ($p) {
            return $p->preco_unitario * $p->quantidade_estoque;
        });

        $categorias = Produto::distinct()->pluck('categoria');

        return view('relatorio.produtos', compact(
            'produtos',
            'totalItens',
            'totalUnidades',
            'valorEstoque',
            'categorias',
            'categoria'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\OrdemServico;
use Illuminate\Http\Request;

class OrdemServicoController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');
        $statusFiltro = $request->input('status');

        $query = OrdemServico::query()->with(['cliente', 'funcionario', 'equipamento']);

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('diagnostico', 'like', "%{$busca}%")
                  ->orWhere('status', 'like', "%{$busca}%")
                  ->orWhereHas('cliente', function ($cq) use ($busca) {
                      $cq->where('nome_razao_social', 'like', "%{$busca}%");
                  })
                  ->orWhereHas('funcionario', function ($fq) use ($busca) {
                      $fq->where('nome', 'like', "%{$busca}%");
                  })
                  ->orWhereHas('equipamento', function ($eq) use ($busca) {
                      $eq->where('modelo', 'like', "%{$busca}%")
                         ->orWhere('numero_serie', 'like', "%{$busca}%");
                  });
            });
        }

        if (!empty($statusFiltro)) {
            $query->where('status', $statusFiltro);
        }

        $ordens = $query->orderBy('data_abertura', 'desc')->paginate(10)->withQueryString();

        return view('ordem_servico.index', compact('ordens', 'busca', 'statusFiltro'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome_razao_social')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();
        $equipamentos = Equipamento::with('cliente')->orderBy('modelo')->get();

        return view('ordem_servico.create', compact('clientes', 'funcionarios', 'equipamentos'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_funcionario' => 'required|exists:funcionarios,id_funcionario',
            'id_equipamento' => 'required|exists:equipamentos,id_equipamento',
            'data_abertura' => 'required|date',
            'diagnostico' => 'required|string',
            'orcamento' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'data_conclusao' => 'nullable|date',
        ], [
            'id_cliente.required' => 'Selecione o cliente solicitante.',
            'id_funcionario.required' => 'Selecione o técnico responsável.',
            'id_equipamento.required' => 'Selecione o equipamento a ser reparado.',
            'data_abertura.required' => 'A data de abertura é obrigatória.',
            'diagnostico.required' => 'O diagnóstico ou descrição do problema é obrigatório.',
            'orcamento.required' => 'O valor do orçamento é obrigatório.',
            'status.required' => 'O status da ordem de serviço é obrigatório.',
        ]);

        $os = OrdemServico::create($dados);

        return redirect()->route('ordem_servico.show', $os->id_os)->with('sucesso', 'Ordem de Serviço aberta com sucesso!');
    }

    public function show($id)
    {
        $os = OrdemServico::with(['cliente.enderecos', 'funcionario', 'equipamento'])->findOrFail($id);
        return view('ordem_servico.show', compact('os'));
    }

    public function edit($id)
    {
        $os = OrdemServico::findOrFail($id);
        $clientes = Cliente::orderBy('nome_razao_social')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();
        $equipamentos = Equipamento::with('cliente')->orderBy('modelo')->get();

        return view('ordem_servico.edit', compact('os', 'clientes', 'funcionarios', 'equipamentos'));
    }

    public function update(Request $request, $id)
    {
        $os = OrdemServico::findOrFail($id);

        $dados = $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_funcionario' => 'required|exists:funcionarios,id_funcionario',
            'id_equipamento' => 'required|exists:equipamentos,id_equipamento',
            'data_abertura' => 'required|date',
            'diagnostico' => 'required|string',
            'orcamento' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'data_conclusao' => 'nullable|date',
        ], [
            'id_cliente.required' => 'Selecione o cliente solicitante.',
            'id_funcionario.required' => 'Selecione o técnico responsável.',
            'id_equipamento.required' => 'Selecione o equipamento.',
            'data_abertura.required' => 'A data de abertura é obrigatória.',
            'diagnostico.required' => 'O diagnóstico é obrigatório.',
            'orcamento.required' => 'O valor do orçamento é obrigatório.',
            'status.required' => 'O status é obrigatório.',
        ]);

        $os->update($dados);

        return redirect()->route('ordem_servico.index')->with('sucesso', "Ordem de Serviço #{$os->id_os} atualizada com sucesso!");
    }

    public function destroy($id)
    {
        $os = OrdemServico::findOrFail($id);
        $numero = $os->id_os;
        $os->delete();

        return redirect()->route('ordem_servico.index')->with('sucesso', "Ordem de Serviço #{$numero} excluída com sucesso!");
    }
}

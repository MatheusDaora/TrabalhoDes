<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $query = Cliente::query()->withCount(['equipamentos', 'ordensServico', 'pedidos']);

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('nome_razao_social', 'like', "%{$busca}%")
                  ->orWhere('cpf_cnpj', 'like', "%{$busca}%")
                  ->orWhere('email', 'like', "%{$busca}%")
                  ->orWhere('telefone', 'like', "%{$busca}%");
            });
        }

        $clientes = $query->orderBy('nome_razao_social')->paginate(10)->withQueryString();

        return view('cliente.index', compact('clientes', 'busca'));
    }

    public function create()
    {
        return view('cliente.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_razao_social' => 'required|string|max:150',
            'cpf_cnpj' => 'required|string|max:20|unique:clientes,cpf_cnpj',
            'email' => 'required|email|max:100',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'nullable|date',
            'data_cadastro' => 'required|date',
            'status' => 'required|string|max:20',
            // Campos opcionais do endereço principal
            'rua' => 'nullable|string|max:150',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:100',
            'cep' => 'nullable|string|max:15',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|size:2',
            'tipo_endereco' => 'nullable|string|max:50',
        ], [
            'nome_razao_social.required' => 'O nome ou razão social é obrigatório.',
            'cpf_cnpj.required' => 'O CPF ou CNPJ é obrigatório.',
            'cpf_cnpj.unique' => 'Este CPF ou CNPJ já está cadastrado no sistema.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'telefone.required' => 'O telefone de contato é obrigatório.',
            'data_cadastro.required' => 'A data de cadastro é obrigatória.',
            'status.required' => 'O status é obrigatório.',
        ]);

        $cliente = Cliente::create([
            'nome_razao_social' => $dados['nome_razao_social'],
            'cpf_cnpj' => $dados['cpf_cnpj'],
            'email' => $dados['email'],
            'telefone' => $dados['telefone'],
            'data_nascimento' => $dados['data_nascimento'] ?? null,
            'data_cadastro' => $dados['data_cadastro'],
            'status' => $dados['status'],
        ]);

        // Se preencheu os campos de endereço, salva o endereço principal
        if (!empty($dados['rua']) && !empty($dados['cidade'])) {
            Endereco::create([
                'id_cliente' => $cliente->id_cliente,
                'tipo_endereco' => $dados['tipo_endereco'] ?? 'Residencial',
                'rua' => $dados['rua'],
                'numero' => $dados['numero'] ?? 'S/N',
                'bairro' => $dados['bairro'] ?? 'Centro',
                'cep' => $dados['cep'] ?? '',
                'cidade' => $dados['cidade'],
                'estado' => strtoupper($dados['estado'] ?? 'SC'),
                'principal' => true,
            ]);
        }

        return redirect()->route('cliente.index')->with('sucesso', 'Cliente cadastrado com sucesso!');
    }

    public function show($id)
    {
        $cliente = Cliente::with(['enderecos', 'equipamentos', 'ordensServico.funcionario', 'pedidos'])
            ->findOrFail($id);

        return view('cliente.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $dados = $request->validate([
            'nome_razao_social' => 'required|string|max:150',
            'cpf_cnpj' => 'required|string|max:20|unique:clientes,cpf_cnpj,' . $id . ',id_cliente',
            'email' => 'required|email|max:100',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'nullable|date',
            'data_cadastro' => 'required|date',
            'status' => 'required|string|max:20',
        ], [
            'nome_razao_social.required' => 'O nome ou razão social é obrigatório.',
            'cpf_cnpj.required' => 'O CPF ou CNPJ é obrigatório.',
            'cpf_cnpj.unique' => 'Este CPF ou CNPJ já está cadastrado para outro cliente.',
            'email.required' => 'O e-mail é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'data_cadastro.required' => 'A data de cadastro é obrigatória.',
        ]);

        $cliente->update($dados);

        return redirect()->route('cliente.index')->with('sucesso', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $nome = $cliente->nome_razao_social;
        $cliente->delete();

        return redirect()->route('cliente.index')->with('sucesso', "Cliente \"{$nome}\" excluído com sucesso!");
    }
}

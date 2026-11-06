<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'tipo_endereco' => 'required|string|max:50',
            'rua' => 'required|string|max:150',
            'numero' => 'required|string|max:20',
            'bairro' => 'required|string|max:100',
            'cep' => 'required|string|max:15',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'principal' => 'nullable|boolean',
        ], [
            'rua.required' => 'O logradouro/rua é obrigatório.',
            'numero.required' => 'O número é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'cep.required' => 'O CEP é obrigatório.',
            'cidade.required' => 'A cidade é obrigatória.',
            'estado.required' => 'O estado (UF) é obrigatório.',
        ]);

        $dados['estado'] = strtoupper($dados['estado']);
        $dados['principal'] = $request->boolean('principal');

        if ($dados['principal']) {
            Endereco::where('id_cliente', $dados['id_cliente'])->update(['principal' => false]);
        }

        Endereco::create($dados);

        return back()->with('sucesso', 'Endereço cadastrado com sucesso!');
    }

    public function destroy($id)
    {
        $endereco = Endereco::findOrFail($id);
        $idCliente = $endereco->id_cliente;
        $endereco->delete();

        return back()->with('sucesso', 'Endereço excluído com sucesso!');
    }
}

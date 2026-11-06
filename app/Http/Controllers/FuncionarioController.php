<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $query = Funcionario::query()->withCount('ordensServico');

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('email', 'like', "%{$busca}%")
                  ->orWhere('perfil', 'like', "%{$busca}%");
            });
        }

        $funcionarios = $query->orderBy('nome')->paginate(10)->withQueryString();

        return view('funcionario.index', compact('funcionarios', 'busca'));
    }

    public function create()
    {
        return view('funcionario.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:funcionarios,email',
            'perfil' => 'required|string|max:50',
            'data_admissao' => 'required|date',
        ], [
            'nome.required' => 'O nome do funcionário é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já pertence a outro funcionário.',
            'perfil.required' => 'O cargo ou perfil é obrigatório.',
            'data_admissao.required' => 'A data de admissão é obrigatória.',
        ]);

        Funcionario::create($dados);

        return redirect()->route('funcionario.index')->with('sucesso', 'Funcionário cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('funcionario.edit', compact('funcionario'));
    }

    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $dados = $request->validate([
            'nome' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:funcionarios,email,' . $id . ',id_funcionario',
            'perfil' => 'required|string|max:50',
            'data_admissao' => 'required|date',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'perfil.required' => 'O perfil é obrigatório.',
            'data_admissao.required' => 'A data de admissão é obrigatória.',
        ]);

        $funcionario->update($dados);

        return redirect()->route('funcionario.index')->with('sucesso', 'Funcionário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $nome = $funcionario->nome;
        $funcionario->delete();

        return redirect()->route('funcionario.index')->with('sucesso', "Funcionário \"{$nome}\" excluído com sucesso!");
    }
}

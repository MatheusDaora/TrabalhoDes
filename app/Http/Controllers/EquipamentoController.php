<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipamentoController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $query = Equipamento::query()->with('cliente');

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('numero_serie', 'like', "%{$busca}%")
                  ->orWhere('modelo', 'like', "%{$busca}%")
                  ->orWhere('marca', 'like', "%{$busca}%")
                  ->orWhereHas('cliente', function ($cq) use ($busca) {
                      $cq->where('nome_razao_social', 'like', "%{$busca}%");
                  });
            });
        }

        $equipamentos = $query->orderBy('modelo')->paginate(10)->withQueryString();

        return view('equipamento.index', compact('equipamentos', 'busca'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome_razao_social')->get();
        return view('equipamento.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'numero_serie' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'marca' => 'required|string|max:50',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'id_cliente.required' => 'Selecione o cliente proprietário do equipamento.',
            'id_cliente.exists' => 'O cliente selecionado é inválido.',
            'numero_serie.required' => 'O número de série é obrigatório.',
            'modelo.required' => 'O modelo do equipamento é obrigatório.',
            'marca.required' => 'A marca é obrigatória.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.max' => 'A imagem não pode ultrapassar 2MB.',
        ]);

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('equipamentos', 'public');
        }

        Equipamento::create($dados);

        return redirect()->route('equipamento.index')->with('sucesso', 'Equipamento cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $equipamento = Equipamento::findOrFail($id);
        $clientes = Cliente::orderBy('nome_razao_social')->get();

        return view('equipamento.edit', compact('equipamento', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $equipamento = Equipamento::findOrFail($id);

        $dados = $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'numero_serie' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'marca' => 'required|string|max:50',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'id_cliente.required' => 'Selecione o cliente proprietário.',
            'numero_serie.required' => 'O número de série é obrigatório.',
            'modelo.required' => 'O modelo é obrigatório.',
            'marca.required' => 'A marca é obrigatória.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.max' => 'A imagem não pode ultrapassar 2MB.',
        ]);

        if ($request->hasFile('imagem')) {
            if ($equipamento->imagem && Storage::disk('public')->exists($equipamento->imagem)) {
                Storage::disk('public')->delete($equipamento->imagem);
            }
            $dados['imagem'] = $request->file('imagem')->store('equipamentos', 'public');
        }

        $equipamento->update($dados);

        return redirect()->route('equipamento.index')->with('sucesso', 'Equipamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $equipamento = Equipamento::findOrFail($id);
        $modelo = $equipamento->modelo;

        if ($equipamento->imagem && Storage::disk('public')->exists($equipamento->imagem)) {
            Storage::disk('public')->delete($equipamento->imagem);
        }

        $equipamento->delete();

        return redirect()->route('equipamento.index')->with('sucesso', "Equipamento \"{$modelo}\" excluído com sucesso!");
    }
}

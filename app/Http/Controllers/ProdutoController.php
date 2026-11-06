<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $query = Produto::query();

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('categoria', 'like', "%{$busca}%")
                  ->orWhere('marca', 'like', "%{$busca}%")
                  ->orWhere('tipo_produto', 'like', "%{$busca}%");
            });
        }

        $produtos = $query->orderBy('nome')->paginate(10)->withQueryString();

        return view('produto.index', compact('produtos', 'busca'));
    }

    public function create()
    {
        return view('produto.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:150',
            'categoria' => 'required|string|max:50',
            'preco_unitario' => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'marca' => 'required|string|max:50',
            'tipo_produto' => 'required|string|max:50',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nome.required' => 'O nome do produto é obrigatório.',
            'categoria.required' => 'A categoria é obrigatória.',
            'preco_unitario.required' => 'O preço unitário é obrigatório.',
            'preco_unitario.numeric' => 'O preço deve ser um valor numérico válido.',
            'quantidade_estoque.required' => 'A quantidade em estoque é obrigatória.',
            'marca.required' => 'A marca é obrigatória.',
            'tipo_produto.required' => 'O tipo do produto é obrigatório.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.max' => 'A imagem não pode ultrapassar 2MB.',
        ]);

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('produtos', 'public');
        }

        Produto::create($dados);

        return redirect()->route('produto.index')->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produto.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $dados = $request->validate([
            'nome' => 'required|string|max:150',
            'categoria' => 'required|string|max:50',
            'preco_unitario' => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'marca' => 'required|string|max:50',
            'tipo_produto' => 'required|string|max:50',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nome.required' => 'O nome do produto é obrigatório.',
            'categoria.required' => 'A categoria é obrigatória.',
            'preco_unitario.required' => 'O preço unitário é obrigatório.',
            'quantidade_estoque.required' => 'A quantidade em estoque é obrigatória.',
            'marca.required' => 'A marca é obrigatória.',
            'tipo_produto.required' => 'O tipo do produto é obrigatório.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.max' => 'A imagem não pode ultrapassar 2MB.',
        ]);

        if ($request->hasFile('imagem')) {
            // Exclui a imagem anterior se existir
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }
            $dados['imagem'] = $request->file('imagem')->store('produtos', 'public');
        }

        $produto->update($dados);

        return redirect()->route('produto.index')->with('sucesso', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $nome = $produto->nome;

        // Exclui a imagem associada do storage
        if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
            Storage::disk('public')->delete($produto->imagem);
        }

        $produto->delete();

        return redirect()->route('produto.index')->with('sucesso', "Produto \"{$nome}\" excluído com sucesso!");
    }
}

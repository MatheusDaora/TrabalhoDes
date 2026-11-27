@extends('layouts.app')

@section('titulo', 'Editar Produto - TechForge')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Editar Produto</h1>
            <p class="text-sm text-slate-500">Atualize as informações de estoque e imagem de {{ $produto->nome }}.</p>
        </div>
        <a href="{{ route('produto.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('produto.update', $produto->id_produto) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="nome">
                    Descrição / Nome do Produto <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nome" id="nome" value="{{ old('nome', $produto->nome) }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="categoria">
                    Categoria <span class="text-rose-500">*</span>
                </label>
                <select name="categoria" id="categoria" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                    <option value="Armazenamento" {{ old('categoria', $produto->categoria) == 'Armazenamento' ? 'selected' : '' }}>Armazenamento</option>
                    <option value="Memória RAM" {{ old('categoria', $produto->categoria) == 'Memória RAM' ? 'selected' : '' }}>Memória RAM</option>
                    <option value="Fonte de Alimentação" {{ old('categoria', $produto->categoria) == 'Fonte de Alimentação' ? 'selected' : '' }}>Fonte de Alimentação</option>
                    <option value="Placa de Vídeo" {{ old('categoria', $produto->categoria) == 'Placa de Vídeo' ? 'selected' : '' }}>Placa de Vídeo</option>
                    <option value="Periféricos" {{ old('categoria', $produto->categoria) == 'Periféricos' ? 'selected' : '' }}>Periféricos</option>
                    <option value="Refrigeração" {{ old('categoria', $produto->categoria) == 'Refrigeração' ? 'selected' : '' }}>Refrigeração</option>
                    <option value="Consumível" {{ old('categoria', $produto->categoria) == 'Consumível' ? 'selected' : '' }}>Consumível</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="marca">
                    Marca / Fabricante <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="marca" id="marca" value="{{ old('marca', $produto->marca) }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="preco_unitario">
                    Preço Unitário de Venda (R$) <span class="text-rose-500">*</span>
                </label>
                <input type="number" step="0.01" name="preco_unitario" id="preco_unitario" value="{{ old('preco_unitario', $produto->preco_unitario) }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="quantidade_estoque">
                    Quantidade em Estoque <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="quantidade_estoque" id="quantidade_estoque" value="{{ old('quantidade_estoque', $produto->quantidade_estoque) }}" min="0" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="tipo_produto">
                    Tipo do Produto <span class="text-rose-500">*</span>
                </label>
                <select name="tipo_produto" id="tipo_produto" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                    <option value="Peça Nova" {{ old('tipo_produto', $produto->tipo_produto) == 'Peça Nova' ? 'selected' : '' }}>Peça Nova (Garantia de Fábrica)</option>
                    <option value="Peça Usada / Testada" {{ old('tipo_produto', $produto->tipo_produto) == 'Peça Usada / Testada' ? 'selected' : '' }}>Peça Usada / Testada (Seminova)</option>
                    <option value="Acessório" {{ old('tipo_produto', $produto->tipo_produto) == 'Acessório' ? 'selected' : '' }}>Acessório</option>
                    <option value="Consumível" {{ old('tipo_produto', $produto->tipo_produto) == 'Consumível' ? 'selected' : '' }}>Consumível</option>
                </select>
            </div>

            <!-- Imagem Atual & Upload Novo -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Imagem do Produto 
                </label>
                
                @if($produto->imagem)
                    <div class="mb-3 flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200 w-fit">
                        <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="w-16 h-16 object-cover rounded-lg border border-slate-200 shadow-xs">
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">Imagem atual cadastrada</span>
                            <span class="text-[10px] text-slate-400">Selecione um novo arquivo abaixo caso deseje substituí-la.</span>
                        </div>
                    </div>
                @endif

                <input type="file" name="imagem" id="imagem" accept="image/*"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('produto.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Atualizar Produto
            </button>
        </div>
    </form>
</div>
@endsection

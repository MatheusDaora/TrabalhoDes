@extends('layouts.app')

@section('titulo', 'Relatório de Estoque - TechForge')

@section('content')
<div class="space-y-6">
    <!-- Barra Superior de Controle -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Relatório de Produtos e Estoque</h1>
            <p class="text-sm text-slate-500">Inventário de componentes, saldo físico e valor patrimonial formatado para PDF.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-600/30 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Imprimir / Salvar em PDF
            </button>
            <a href="{{ route('relatorio.index') }}" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                &larr; Voltar
            </a>
        </div>
    </div>

    <!-- Filtro de Categoria -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs no-print">
        <form method="GET" action="{{ route('relatorio.produtos') }}" class="flex items-center gap-3">
            <label class="text-xs font-bold text-slate-700 shrink-0">Filtrar por Categoria:</label>
            <select name="categoria" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none transition bg-white">
                <option value="">Todas as Categorias</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat }}" {{ $categoria == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @if(!empty($categoria))
                <a href="{{ route('relatorio.produtos') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                    Limpar filtro
                </a>
            @endif
        </form>
    </div>

    <!-- Folha do Relatório Formatada para PDF / Impressão -->
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-6 print:border-none print:shadow-none print:p-0">
        <!-- Cabeçalho Institucional -->
        <div class="flex items-start justify-between border-b-2 border-slate-900 pb-4">
            <div>
                <h2 class="text-xl font-black text-slate-900">TechForge - Assistência Técnica Especializada</h2>
                <p class="text-xs font-bold text-slate-700">Inventário Físico e Financeiro de Produtos em Estoque</p>
                <p class="text-[11px] text-slate-400">Emissão: {{ date('d/m/Y H:i:s') }} &bull; Sistema Acadêmico Integrado IFSC</p>
            </div>
            <div class="text-right text-xs">
                <span class="font-bold text-slate-700 block">Filtro de Categoria:</span>
                <span class="text-emerald-700 font-semibold">{{ $categoria ? $categoria : 'Todas as categorias' }}</span>
            </div>
        </div>

        <!-- Indicadores de Estoque -->
        <div class="grid grid-cols-3 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs">
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Variedade de Itens</span>
                <span class="text-lg font-black text-slate-900">{{ $totalItens }} produtos</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Saldo Físico Total</span>
                <span class="text-lg font-black text-emerald-700">{{ $totalUnidades }} unidades</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Valor Total do Estoque</span>
                <span class="text-lg font-black text-slate-900">R$ {{ number_format($valorEstoque, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Tabela Formatada -->
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-y border-slate-300 text-slate-600 uppercase tracking-wider text-[10px] font-bold bg-slate-50">
                    <th class="py-2.5 px-2">Código</th>
                    <th class="py-2.5 px-2">Descrição do Produto</th>
                    <th class="py-2.5 px-2">Categoria</th>
                    <th class="py-2.5 px-2">Marca / Tipo</th>
                    <th class="py-2.5 px-2 text-right">Preço Unitário</th>
                    <th class="py-2.5 px-2 text-center">Qtd Estoque</th>
                    <th class="py-2.5 px-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($produtos as $prod)
                    <tr>
                        <td class="py-2 px-2 font-mono text-slate-500 font-bold">#{{ str_pad($prod->id_produto, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-2 px-2 font-bold text-slate-900">{{ $prod->nome }}</td>
                        <td class="py-2 px-2 text-slate-700">{{ $prod->categoria }}</td>
                        <td class="py-2 px-2 text-slate-600">{{ $prod->marca }} ({{ $prod->tipo_produto }})</td>
                        <td class="py-2 px-2 text-right font-medium text-slate-700">R$ {{ number_format($prod->preco_unitario, 2, ',', '.') }}</td>
                        <td class="py-2 px-2 text-center font-bold {{ $prod->quantidade_estoque <= 5 ? 'text-rose-700' : 'text-slate-800' }}">
                            {{ $prod->quantidade_estoque }} un
                        </td>
                        <td class="py-2 px-2 text-right font-bold text-slate-900">
                            R$ {{ number_format($prod->preco_unitario * $prod->quantidade_estoque, 2, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-slate-400">Nenhum produto cadastrado nesta categoria.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-slate-800 font-bold">
                    <td colspan="6" class="py-3 px-2 text-right uppercase text-slate-700 text-xs">Valor Total Patrimonial em Estoque:</td>
                    <td class="py-3 px-2 text-right font-black text-emerald-800 text-sm">R$ {{ number_format($valorEstoque, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Rodapé do Relatório -->
        <div class="pt-6 border-t border-slate-200 text-center text-[10px] text-slate-400">
            TechForge &bull; Documento gerado eletronicamente para fins acadêmicos e comprobatórios &bull; IFSC Câmpus Chapecó
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('titulo', 'Pedido #' . $pedido->id_pedido . ' - TechForge')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between no-print">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pedido #{{ $pedido->id_pedido }}</h1>
            <p class="text-sm text-slate-500">Comprovante de venda e lista de itens faturados.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Imprimir Pedido
            </button>
            <a href="{{ route('pedido.edit', $pedido->id_pedido) }}" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-xl text-xs font-bold transition">
                Editar
            </a>
            <a href="{{ route('pedido.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                &larr; Voltar
            </a>
        </div>
    </div>

    <!-- Comprovante do Pedido -->
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-6 print:border-none print:shadow-none print:p-0">
        <div class="flex items-start justify-between border-b-2 border-blue-600 pb-5">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-8 h-8 rounded-lg bg-blue-600 text-white font-black flex items-center justify-center text-sm">TA</span>
                    <span class="text-xl font-black text-slate-900">TechForge Informática</span>
                </div>
                <p class="text-xs text-slate-500">Comprovante de Compra / Pedido de Peças</p>
                <p class="text-xs text-slate-400">Chapecó - SC &bull; Venda Direta</p>
            </div>
            <div class="text-right">
                <span class="text-xs uppercase font-bold text-slate-400 block tracking-wider">Pedido</span>
                <span class="text-3xl font-black text-blue-600 font-mono">#{{ str_pad($pedido->id_pedido, 5, '0', STR_PAD_LEFT) }}</span>
                <span class="text-xs text-slate-500 block mt-1">Data: {{ date('d/m/Y', strtotime($pedido->data_pedido)) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-[10px] uppercase font-bold text-blue-600 block mb-2 tracking-wider">Cliente</span>
                <p class="text-sm font-bold text-slate-900">{{ $pedido->cliente->nome_razao_social ?? 'Não informado' }}</p>
                <p class="text-slate-600 mt-1">CPF/CNPJ: <span class="font-mono font-medium">{{ $pedido->cliente->cpf_cnpj ?? '-' }}</span></p>
                <p class="text-slate-600">Telefone: {{ $pedido->cliente->telefone ?? '-' }}</p>
                <p class="text-slate-600">E-mail: {{ $pedido->cliente->email ?? '-' }}</p>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-[10px] uppercase font-bold text-blue-600 block mb-2 tracking-wider">Status & Entrega</span>
                <p class="text-sm font-bold text-slate-900">Status: {{ $pedido->status }}</p>
                @if($pedido->requer_entrega && $pedido->enderecoEntrega)
                    <p class="text-slate-600 mt-1">Modalidade: <span class="font-bold text-blue-700">Entrega no Endereço</span></p>
                    <p class="text-slate-600">{{ $pedido->enderecoEntrega->rua }}, {{ $pedido->enderecoEntrega->numero }}</p>
                    <p class="text-slate-400">{{ $pedido->enderecoEntrega->bairro }} - {{ $pedido->enderecoEntrega->cidade }}/{{ $pedido->enderecoEntrega->estado }}</p>
                @else
                    <p class="text-slate-600 mt-1">Modalidade: Retirada no balcão</p>
                @endif
            </div>
        </div>

        <!-- Tabela de Itens Faturados -->
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Itens do Pedido (Relacionamento 1:N)</h2>
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-y border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                        <th class="py-2.5 px-3">Item / Produto</th>
                        <th class="py-2.5 px-3 text-center">Quantidade</th>
                        <th class="py-2.5 px-3 text-right">Preço Unitário</th>
                        <th class="py-2.5 px-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($pedido->itens as $item)
                        <tr>
                            <td class="py-3 px-3">
                                <span class="font-bold text-slate-900 block">{{ $item->produto->nome ?? 'Produto #' . $item->id_produto }}</span>
                                <span class="text-[10px] text-slate-400">{{ $item->produto->categoria ?? '' }} &bull; {{ $item->produto->marca ?? '' }}</span>
                            </td>
                            <td class="py-3 px-3 text-center font-bold text-slate-700">{{ $item->quantidade }}</td>
                            <td class="py-3 px-3 text-right text-slate-700">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                            <td class="py-3 px-3 text-right font-bold text-slate-900">
                                R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-slate-300 font-black text-sm">
                        <td colspan="3" class="py-3 px-3 text-right uppercase text-slate-700">Valor Total do Pedido:</td>
                        <td class="py-3 px-3 text-right text-blue-600 text-base">
                            R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

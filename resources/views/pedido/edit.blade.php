@extends('layouts.app')

@section('titulo', 'Editar Pedido #' . $pedido->id_pedido . ' - TechAssist')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Editar Pedido #{{ $pedido->id_pedido }}</h1>
            <p class="text-sm text-slate-500">Atualize o status de entrega e pagamento do pedido.</p>
        </div>
        <a href="{{ route('pedido.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('pedido.update', $pedido->id_pedido) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
            <div>
                <span class="font-bold text-slate-900 block">{{ $pedido->cliente->nome_razao_social ?? 'Cliente' }}</span>
                <span class="text-slate-400">Data: {{ date('d/m/Y', strtotime($pedido->data_pedido)) }} &bull; Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</span>
            </div>
            <span class="px-3 py-1 rounded-full font-bold bg-blue-50 text-blue-700 text-xs">
                {{ $pedido->itens->count() }} item(ns)
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="status">
                    Status do Pedido <span class="text-rose-500">*</span>
                </label>
                <select name="status" id="status" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                    <option value="Pendente" {{ old('status', $pedido->status) == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="Pago" {{ old('status', $pedido->status) == 'Pago' ? 'selected' : '' }}>Pago</option>
                    <option value="Em Separação" {{ old('status', $pedido->status) == 'Em Separação' ? 'selected' : '' }}>Em Separação</option>
                    <option value="Entregue" {{ old('status', $pedido->status) == 'Entregue' ? 'selected' : '' }}>Entregue</option>
                    <option value="Cancelado" {{ old('status', $pedido->status) == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Opção de Entrega
                </label>
                <label class="flex items-center gap-2 p-2 border border-slate-200 rounded-xl cursor-pointer bg-slate-50">
                    <input type="checkbox" name="requer_entrega" id="requer_entrega" value="1" {{ old('requer_entrega', $pedido->requer_entrega) ? 'checked' : '' }}
                           onchange="document.getElementById('divEnderecoEdit').classList.toggle('hidden', !this.checked)"
                           class="rounded text-blue-600">
                    <span class="text-xs font-bold text-slate-700">Requer Envio / Entrega</span>
                </label>
            </div>

            <div id="divEnderecoEdit" class="sm:col-span-2 {{ old('requer_entrega', $pedido->requer_entrega) ? '' : 'hidden' }}">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_endereco_entrega">
                    Endereço de Entrega
                </label>
                <select name="id_endereco_entrega" id="id_endereco_entrega" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                    <option value="">Selecione o endereço...</option>
                    @foreach($enderecos as $end)
                        <option value="{{ $end->id_endereco }}" {{ old('id_endereco_entrega', $pedido->id_endereco_entrega) == $end->id_endereco ? 'selected' : '' }}>
                            {{ $end->tipo_endereco }}: {{ $end->rua }}, {{ $end->numero }} - {{ $end->bairro }} ({{ $end->cidade }}/{{ $end->estado }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('pedido.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Atualizar Pedido
            </button>
        </div>
    </form>
</div>
@endsection

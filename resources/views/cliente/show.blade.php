@extends('layouts.app')

@section('titulo', 'Detalhes do Cliente - TechAssist')

@section('content')
<div class="space-y-6">
    <!-- Topo -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white font-black text-xl flex items-center justify-center shadow-md shadow-blue-500/20">
                {{ strtoupper(substr($cliente->nome_razao_social, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $cliente->nome_razao_social }}</h1>
                <p class="text-xs text-slate-500">Cliente #{{ $cliente->id_cliente }} &bull; Cadastrado em {{ date('d/m/Y', strtotime($cliente->data_cadastro)) }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('cliente.edit', $cliente->id_cliente) }}" class="px-4 py-2 text-xs font-bold text-amber-700 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-100 transition">
                Editar Cadastro
            </a>
            <a href="{{ route('cliente.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                &larr; Voltar
            </a>
        </div>
    </div>

    <!-- Informações de Contato -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">CPF / CNPJ</span>
            <span class="text-sm font-bold font-mono text-slate-800">{{ $cliente->cpf_cnpj }}</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Telefone / WhatsApp</span>
            <span class="text-sm font-bold text-slate-800">{{ $cliente->telefone }}</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">E-mail</span>
            <span class="text-sm font-bold text-slate-800 truncate block">{{ $cliente->email }}</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Status do Cadastro</span>
            <span class="inline-block mt-0.5 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $cliente->status == 'Ativo' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-700' }}">
                {{ $cliente->status }}
            </span>
        </div>
    </div>

    <!-- Seção 1: Endereços do Cliente (1:N) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-900">Endereços Registrados</h2>
                <p class="text-xs text-slate-400">Relacionamento 1:N &bull; Um cliente pode possuir múltiplos endereços cadastrados.</p>
            </div>
            <button onclick="document.getElementById('formNovoEndereco').classList.toggle('hidden')" 
                    class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-bold transition">
                + Adicionar Endereço
            </button>
        </div>

        <!-- Formulário Ocultável para Novo Endereço -->
        <div id="formNovoEndereco" class="hidden p-4 rounded-xl bg-slate-50 border border-slate-200">
            <form action="{{ route('endereco.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="id_cliente" value="{{ $cliente->id_cliente }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Logradouro / Rua</label>
                        <input type="text" name="rua" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Número</label>
                        <input type="text" name="numero" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Bairro</label>
                        <input type="text" name="bairro" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">CEP</label>
                        <input type="text" name="cep" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Cidade</label>
                        <input type="text" name="cidade" value="Chapecó" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">UF</label>
                        <input type="text" name="estado" value="SC" maxlength="2" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white uppercase">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tipo</label>
                        <select name="tipo_endereco" class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white">
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Cobrança">Cobrança</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-700">
                        <input type="checkbox" name="principal" value="1" class="rounded text-blue-600">
                        Marcar como endereço principal
                    </label>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-xs">
                        Salvar Endereço
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @forelse($cliente->enderecos as $end)
                <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/60 flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-slate-900">{{ $end->tipo_endereco }}</span>
                            @if($end->principal)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700">Principal</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-600">{{ $end->rua }}, {{ $end->numero }} - {{ $end->bairro }}</p>
                        <p class="text-[11px] text-slate-400">{{ $end->cidade }}/{{ $end->estado }} &bull; CEP {{ $end->cep }}</p>
                    </div>
                    <form action="{{ route('endereco.destroy', $end->id_endereco) }}" method="POST" onsubmit="return confirm('Excluir este endereço?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-slate-400 hover:text-rose-600 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-xs text-slate-400 col-span-2">Nenhum endereço cadastrado para este cliente.</p>
            @endforelse
        </div>
    </div>

    <!-- Seção 2: Equipamentos e Ordens de Serviço (Relacionamentos) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Equipamentos -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Equipamentos Registrados</h2>
                    <p class="text-xs text-slate-400">Computadores / notebooks pertencentes ao cliente</p>
                </div>
                <a href="{{ route('equipamento.create') }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-bold transition">
                    + Novo Equipamento
                </a>
            </div>
            <div class="space-y-3">
                @forelse($cliente->equipamentos as $eq)
                    <div class="p-3 rounded-xl border border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">{{ $eq->modelo }}</span>
                            <span class="text-[11px] text-slate-400">Marca: {{ $eq->marca }} &bull; S/N: <code class="font-mono">{{ $eq->numero_serie }}</code></span>
                        </div>
                        <a href="{{ route('equipamento.edit', $eq->id_equipamento) }}" class="text-xs font-bold text-blue-600 hover:underline">
                            Editar
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-3">Nenhum equipamento vinculado a este cliente.</p>
                @endforelse
            </div>
        </div>

        <!-- Histórico de Ordens de Serviço -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Histórico de O.S.</h2>
                    <p class="text-xs text-slate-400">Manutenções abertas para este cliente</p>
                </div>
                <a href="{{ route('ordem_servico.create') }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-bold transition">
                    + Abrir O.S.
                </a>
            </div>
            <div class="space-y-3">
                @forelse($cliente->ordensServico as $os)
                    <div class="p-3 rounded-xl border border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-blue-600">#{{ $os->id_os }}</span>
                                <span class="text-xs font-bold text-slate-800">R$ {{ number_format($os->orcamento, 2, ',', '.') }}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-slate-200 text-slate-700">{{ $os->status }}</span>
                            </div>
                            <p class="text-[11px] text-slate-400 truncate max-w-xs mt-0.5">{{ $os->diagnostico }}</p>
                        </div>
                        <a href="{{ route('ordem_servico.show', $os->id_os) }}" class="text-xs font-bold text-blue-600 hover:underline">
                            Ver O.S.
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-3">Nenhuma ordem de serviço registrada.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

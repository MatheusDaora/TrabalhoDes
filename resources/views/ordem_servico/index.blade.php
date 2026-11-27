@extends('layouts.app')

@section('titulo', 'Ordens de Serviço - TechForge')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Ordens de Serviço (O.S.)</h1>
            <p class="text-sm text-slate-500">Gestão das manutenções, diagnósticos técnicos e orçamentos de equipamentos.</p>
        </div>
        <a href="{{ route('ordem_servico.create') }}" 
           class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-600/30 transition flex items-center gap-2 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Abrir Nova O.S.
        </a>
    </div>

    <!-- Filtros e Busca Funcional -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('ordem_servico.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2 relative">
                <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar por diagnóstico, cliente, técnico ou equipamento..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                    <option value="">Todos os Status</option>
                    <option value="Em Análise" {{ $statusFiltro == 'Em Análise' ? 'selected' : '' }}>Em Análise</option>
                    <option value="Aguardando Peça" {{ $statusFiltro == 'Aguardando Peça' ? 'selected' : '' }}>Aguardando Peça</option>
                    <option value="Aprovado" {{ $statusFiltro == 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
                    <option value="Em Reparo" {{ $statusFiltro == 'Em Reparo' ? 'selected' : '' }}>Em Reparo</option>
                    <option value="Concluído" {{ $statusFiltro == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                    <option value="Cancelado" {{ $statusFiltro == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold text-xs shadow-xs transition">
                    Filtrar
                </button>
                @if(!empty($busca) || !empty($statusFiltro))
                    <a href="{{ route('ordem_servico.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs transition">
                        Limpar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabela de O.S. -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 uppercase tracking-wider font-bold">
                        <th class="py-3 px-4">O.S.</th>
                        <th class="py-3 px-4">Cliente </th>
                        <th class="py-3 px-4">Equipamento</th>
                        <th class="py-3 px-4">Técnico Resp.</th>
                        <th class="py-3 px-4">Abertura</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Orçamento</th>
                        <th class="py-3 px-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($ordens as $os)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-black text-blue-600">
                                <a href="{{ route('ordem_servico.show', $os->id_os) }}" class="hover:underline">
                                    #{{ $os->id_os }}
                                </a>
                            </td>
                            <!-- Exibição do Nome do Cliente em vez de ID -->
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ $os->cliente->nome_razao_social ?? 'Cliente #' . $os->id_cliente }}
                            </td>
                            <!-- Exibição do Nome/Modelo do Equipamento -->
                            <td class="py-3.5 px-4 text-slate-600">
                                <span class="font-semibold block text-slate-800">{{ $os->equipamento->modelo ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">S/N: {{ $os->equipamento->numero_serie ?? '-' }}</span>
                            </td>
                            <!-- Exibição do Nome do Funcionário em vez de ID -->
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $os->funcionario->nome ?? 'Técnico #' . $os->id_funcionario }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ date('d/m/Y', strtotime($os->data_abertura)) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @php
                                    $badgeClass = match($os->status) {
                                        'Concluído' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'Em Reparo' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Aprovado' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'Aguardando Peça' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'Cancelado' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeClass }}">
                                    {{ $os->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-black text-slate-900 text-sm">
                                R$ {{ number_format($os->orcamento, 2, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('ordem_servico.show', $os->id_os) }}" title="Visualizar Ordem / Imprimir Comprovante"
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('ordem_servico.edit', $os->id_os) }}" title="Editar"
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('ordem_servico.destroy', $os->id_os) }}" method="POST" 
                                          onsubmit="return confirm('Deseja realmente excluir esta ordem de serviço?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Excluir" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">
                                Nenhuma ordem de serviço encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ordens->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $ordens->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

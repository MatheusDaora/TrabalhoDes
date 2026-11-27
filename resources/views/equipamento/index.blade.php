@extends('layouts.app')

@section('titulo', 'Equipamentos de Clientes - TechForge')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Equipamentos em Manutenção</h1>
            <p class="text-sm text-slate-500">Computadores, notebooks e periféricos recebidos dos clientes.</p>
        </div>
        <a href="{{ route('equipamento.create') }}" 
           class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-600/30 transition flex items-center gap-2 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Novo Equipamento
        </a>
    </div>

    <!-- Busca Funcional -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('equipamento.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar por modelo, marca, número de série ou cliente..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold text-xs shadow-xs transition">
                    Buscar
                </button>
                @if(!empty($busca))
                    <a href="{{ route('equipamento.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs transition">
                        Limpar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabela com Miniatura de Imagem e Nome do Cliente em vez de ID  -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 uppercase tracking-wider font-bold">
                        <th class="py-3 px-4 w-16 text-center">Foto</th>
                        <th class="py-3 px-4">Modelo do Equipamento</th>
                        <th class="py-3 px-4">Marca</th>
                        <th class="py-3 px-4">Número de Série</th>
                        <th class="py-3 px-4">Proprietário (Cliente)</th>
                        <th class="py-3 px-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($equipamentos as $eq)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 text-center">
                                @if($eq->imagem)
                                    <img src="{{ asset('storage/' . $eq->imagem) }}" alt="{{ $eq->modelo }}" 
                                         class="w-11 h-11 object-cover rounded-xl border border-slate-200 shadow-xs mx-auto">
                                @else
                                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $eq->modelo }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700">
                                    {{ $eq->marca }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-600">
                                {{ $eq->numero_serie }}
                            </td>
                            <!-- Exibição do Nome do Cliente em vez de ID -->
                            <td class="py-3.5 px-4">
                                @if($eq->cliente)
                                    <a href="{{ route('cliente.show', $eq->cliente->id_cliente) }}" class="font-bold text-blue-600 hover:underline">
                                        {{ $eq->cliente->nome_razao_social }}
                                    </a>
                                @else
                                    <span class="text-slate-400">Cliente não identificado</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('equipamento.edit', $eq->id_equipamento) }}" title="Editar"
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('equipamento.destroy', $eq->id_equipamento) }}" method="POST" 
                                          onsubmit="return confirm('Deseja realmente excluir este equipamento e sua imagem?');" class="inline">
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
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Nenhum equipamento registrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($equipamentos->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $equipamentos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

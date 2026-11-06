@extends('layouts.app')

@section('titulo', 'Clientes - TechAssist')

@section('content')
<div class="space-y-6">
    <!-- Topo da Listagem -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Clientes Cadastrados</h1>
            <p class="text-sm text-slate-500">Gerenciamento de pessoas físicas e jurídicas atendidas pela assistência.</p>
        </div>
        <a href="{{ route('cliente.create') }}" 
           class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-600/30 transition flex items-center gap-2 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Novo Cliente
        </a>
    </div>

    <!-- Barra de Busca Funcional (Critério 5) -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('cliente.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar cliente por nome, CPF/CNPJ, e-mail ou telefone..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold text-xs shadow-xs transition">
                    Buscar
                </button>
                @if(!empty($busca))
                    <a href="{{ route('cliente.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs transition">
                        Limpar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabela de Listagem -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 uppercase tracking-wider font-bold">
                        <th class="py-3 px-4">Nome / Razão Social</th>
                        <th class="py-3 px-4">CPF / CNPJ</th>
                        <th class="py-3 px-4">Contato</th>
                        <th class="py-3 px-4">Cadastro</th>
                        <th class="py-3 px-4 text-center">Registros Relacionados</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($clientes as $cliente)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                <a href="{{ route('cliente.show', $cliente->id_cliente) }}" class="hover:text-blue-600 flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-xs shrink-0">
                                        {{ strtoupper(substr($cliente->nome_razao_social, 0, 1)) }}
                                    </span>
                                    <span>{{ $cliente->nome_razao_social }}</span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-600">{{ $cliente->cpf_cnpj }}</td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <span class="block text-slate-800">{{ $cliente->telefone }}</span>
                                <span class="block text-[11px] text-slate-400">{{ $cliente->email }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ date('d/m/Y', strtotime($cliente->data_cadastro)) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 text-[11px] text-slate-500">
                                    <span class="px-1.5 py-0.5 rounded bg-slate-100 font-bold" title="Equipamentos">{{ $cliente->equipamentos_count }} eq</span>
                                    <span class="px-1.5 py-0.5 rounded bg-blue-50 text-blue-700 font-bold" title="Ordens de Serviço">{{ $cliente->ordens_servico_count }} OS</span>
                                    <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-700 font-bold" title="Pedidos">{{ $cliente->pedidos_count }} ped</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $cliente->status == 'Ativo' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $cliente->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('cliente.show', $cliente->id_cliente) }}" title="Visualizar Detalhes"
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('cliente.edit', $cliente->id_cliente) }}" title="Editar"
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('cliente.destroy', $cliente->id_cliente) }}" method="POST" 
                                          onsubmit="return confirm('Deseja realmente excluir este cliente e seus dados vinculados?');" class="inline">
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
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                Nenhum cliente encontrado para os critérios informados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clientes->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $clientes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('titulo', 'Funcionários e Técnicos - TechForge')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Equipe Técnica & Atendentes</h1>
            <p class="text-sm text-slate-500">Cadastro de colaboradores responsáveis pelas manutenções e atendimentos.</p>
        </div>
        <a href="{{ route('funcionario.create') }}" 
           class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-600/30 transition flex items-center gap-2 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Novo Funcionário
        </a>
    </div>

    <!-- Busca Funcional -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('funcionario.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar por nome, e-mail ou perfil técnico..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold text-xs shadow-xs transition">
                    Buscar
                </button>
                @if(!empty($busca))
                    <a href="{{ route('funcionario.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs transition">
                        Limpar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabela -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 uppercase tracking-wider font-bold">
                        <th class="py-3 px-4">Nome do Funcionário</th>
                        <th class="py-3 px-4">E-mail</th>
                        <th class="py-3 px-4">Cargo / Perfil</th>
                        <th class="py-3 px-4">Data de Admissão</th>
                        <th class="py-3 px-4 text-center">O.S. Vinculadas</th>
                        <th class="py-3 px-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($funcionarios as $func)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900 flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($func->nome, 0, 1)) }}
                                </span>
                                <span>{{ $func->nome }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $func->email }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $func->perfil }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ date('d/m/Y', strtotime($func->data_admissao)) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full font-bold bg-slate-100 text-slate-700 text-[11px]">
                                    {{ $func->ordens_servico_count }} O.S.
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('funcionario.edit', $func->id_funcionario) }}" title="Editar"
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('funcionario.destroy', $func->id_funcionario) }}" method="POST" 
                                          onsubmit="return confirm('Deseja realmente excluir este funcionário?');" class="inline">
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
                                Nenhum funcionário cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($funcionarios->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $funcionarios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

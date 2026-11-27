@extends('layouts.app')

@section('titulo', 'Relatórios do Sistema - TechForge')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Relatórios em PDF / Impressão</h1>
        <p class="text-sm text-slate-500">Geração de relatórios consolidados em formato pronto para impressão e exportação em PDF.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Relatório 1: Ordens de Serviço -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Relatório de Ordens de Serviço</h2>
                    <p class="text-xs text-slate-500 mt-1">Listagem completa das manutenções executadas, prazos, orçamentos e situação técnica de cada equipamento atendido.</p>
                </div>
                <div class="text-[11px] text-slate-400 space-y-1 pt-2">
                    <p>&bull; Totais consolidados de orçamentos</p>
                    <p>&bull; Filtro por status de atendimento</p>
                    <p>&bull; Formatação A4 com folha de estilo para impressão</p>
                </div>
            </div>
            <div class="pt-6">
                <a href="{{ route('relatorio.ordens_servico') }}" 
                   class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-600/30 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Visualizar e Gerar PDF
                </a>
            </div>
        </div>

        <!-- Relatório 2: Produtos e Saldo em Estoque -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Relatório de Produtos & Estoque</h2>
                    <p class="text-xs text-slate-500 mt-1">Inventário dos produtos cadastrados, quantidade física disponível, preços unitários e valor total de estoque imobilizado.</p>
                </div>
                <div class="text-[11px] text-slate-400 space-y-1 pt-2">
                    <p>&bull; Valor total patrimonial em estoque</p>
                    <p>&bull; Filtro por categoria de produto</p>
                    <p>&bull; Formatação A4 para impressão</p>
                </div>
            </div>
            <div class="pt-6">
                <a href="{{ route('relatorio.produtos') }}" 
                   class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-md shadow-emerald-600/30 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Visualizar e Gerar PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

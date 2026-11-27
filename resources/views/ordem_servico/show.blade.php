@extends('layouts.app')

@section('titulo', 'Ordem de Serviço #' . $os->id_os . ' - TechForge')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Barra Superior de Ações -->
    <div class="flex items-center justify-between no-print">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Ordem de Serviço #{{ $os->id_os }}</h1>
            <p class="text-sm text-slate-500">Visualização e impressão do comprovante de manutenção.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Imprimir Comprovante
            </button>
            <a href="{{ route('ordem_servico.edit', $os->id_os) }}" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-xl text-xs font-bold transition">
                Editar
            </a>
            <a href="{{ route('ordem_servico.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                &larr; Voltar
            </a>
        </div>
    </div>

    <!-- Comprovante / Ficha Técnica -->
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-6 print:border-none print:shadow-none print:p-0">
        <!-- Cabeçalho do Documento -->
        <div class="flex items-start justify-between border-b-2 border-blue-600 pb-5">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-8 h-8 rounded-lg bg-blue-600 text-white font-black flex items-center justify-center text-sm">TA</span>
                    <span class="text-xl font-black text-slate-900">TechForge Informática</span>
                </div>
                <p class="text-xs text-slate-500">Laboratório Especializado de Assistência Técnica</p>
                <p class="text-xs text-slate-400">Chapecó - Santa Catarina &bull; Telefone: (49) 3322-1000</p>
            </div>
            <div class="text-right">
                <span class="text-xs uppercase font-bold text-slate-400 block tracking-wider">Número da O.S.</span>
                <span class="text-3xl font-black text-blue-600 font-mono">#{{ str_pad($os->id_os, 5, '0', STR_PAD_LEFT) }}</span>
                <span class="text-xs text-slate-500 block mt-1">Abertura: {{ date('d/m/Y', strtotime($os->data_abertura)) }}</span>
            </div>
        </div>

        <!-- Dados do Cliente e Equipamento -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-[10px] uppercase font-bold text-blue-600 block mb-2 tracking-wider">Dados do Cliente</span>
                <p class="text-sm font-bold text-slate-900">{{ $os->cliente->nome_razao_social ?? 'Cliente não informado' }}</p>
                <p class="text-slate-600 mt-1">CPF/CNPJ: <span class="font-mono font-medium">{{ $os->cliente->cpf_cnpj ?? '-' }}</span></p>
                <p class="text-slate-600">Telefone: {{ $os->cliente->telefone ?? '-' }}</p>
                <p class="text-slate-600">E-mail: {{ $os->cliente->email ?? '-' }}</p>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-[10px] uppercase font-bold text-blue-600 block mb-2 tracking-wider">Equipamento em Reparo</span>
                <p class="text-sm font-bold text-slate-900">{{ $os->equipamento->modelo ?? '-' }}</p>
                <p class="text-slate-600 mt-1">Marca: <span class="font-medium">{{ $os->equipamento->marca ?? '-' }}</span></p>
                <p class="text-slate-600">Número de Série: <span class="font-mono font-semibold">{{ $os->equipamento->numero_serie ?? '-' }}</span></p>
                <p class="text-slate-600">Técnico Responsável: <span class="font-semibold">{{ $os->funcionario->nome ?? 'Não atribuído' }}</span></p>
            </div>
        </div>

        <!-- Diagnóstico e Parecer Técnico -->
        <div class="p-5 rounded-xl border border-slate-100 bg-slate-50/50">
            <span class="text-xs uppercase font-bold text-slate-700 block mb-2 tracking-wider">Diagnóstico Técnico / Defeito Reclamado</span>
            <p class="text-xs leading-relaxed text-slate-700 whitespace-pre-line">{{ $os->diagnostico }}</p>
        </div>

        <!-- Status e Valores -->
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 rounded-xl bg-slate-100 border border-slate-200">
            <div>
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Status do Atendimento</span>
                <span class="text-sm font-black text-slate-900">{{ $os->status }}</span>
                @if($os->data_conclusao)
                    <span class="text-xs text-slate-500 block">Concluído em: {{ date('d/m/Y', strtotime($os->data_conclusao)) }}</span>
                @endif
            </div>
            <div class="text-right mt-3 sm:mt-0">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Valor Total Orçado</span>
                <span class="text-2xl font-black text-slate-900">R$ {{ number_format($os->orcamento, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Termo de Assinatura -->
        <div class="pt-8 mt-6 border-t border-slate-200 grid grid-cols-2 gap-8 text-center text-xs text-slate-500">
            <div>
                <div class="border-b border-slate-300 w-3/4 mx-auto mb-2"></div>
                <span>Assinatura do Cliente</span>
            </div>
            <div>
                <div class="border-b border-slate-300 w-3/4 mx-auto mb-2"></div>
                <span>Assinatura do Técnico Responsável</span>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('titulo', 'Relatório de Ordens de Serviço - TechAssist')

@section('content')
<div class="space-y-6">
    <!-- Barra Superior de Controle (Oculta na impressão) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Relatório de Ordens de Serviço</h1>
            <p class="text-sm text-slate-500">Visualização de impressão formatada em A4 para exportação em PDF.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Imprimir / Salvar em PDF
            </button>
            <a href="{{ route('relatorio.index') }}" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                &larr; Voltar
            </a>
        </div>
    </div>

    <!-- Filtro de Status (Oculto na impressão) -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs no-print">
        <form method="GET" action="{{ route('relatorio.ordens_servico') }}" class="flex items-center gap-3">
            <label class="text-xs font-bold text-slate-700 shrink-0">Filtrar por Status:</label>
            <select name="status" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                <option value="">Todos os Atendimentos</option>
                <option value="Em Análise" {{ $status == 'Em Análise' ? 'selected' : '' }}>Em Análise</option>
                <option value="Aguardando Peça" {{ $status == 'Aguardando Peça' ? 'selected' : '' }}>Aguardando Peça</option>
                <option value="Aprovado" {{ $status == 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
                <option value="Em Reparo" {{ $status == 'Em Reparo' ? 'selected' : '' }}>Em Reparo</option>
                <option value="Concluído" {{ $status == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                <option value="Cancelado" {{ $status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            @if(!empty($status))
                <a href="{{ route('relatorio.ordens_servico') }}" class="text-xs font-bold text-blue-600 hover:underline">
                    Limpar filtro
                </a>
            @endif
        </form>
    </div>

    <!-- Folha do Relatório Formatada para PDF / Impressão -->
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-6 print:border-none print:shadow-none print:p-0">
        <!-- Cabeçalho Acadêmico / Institucional -->
        <div class="flex items-start justify-between border-b-2 border-slate-900 pb-4">
            <div>
                <h2 class="text-xl font-black text-slate-900">TechAssist - Assistência Técnica Especializada</h2>
                <p class="text-xs font-bold text-slate-700">Relatório Geral de Ordens de Serviço Emitidas</p>
                <p class="text-[11px] text-slate-400">Emissão: {{ date('d/m/Y H:i:s') }} &bull; Sistema Acadêmico Integrado IFSC</p>
            </div>
            <div class="text-right text-xs">
                <span class="font-bold text-slate-700 block">Filtro Aplicado:</span>
                <span class="text-blue-600 font-semibold">{{ $status ? $status : 'Todos os registros' }}</span>
            </div>
        </div>

        <!-- Indicadores do Relatório -->
        <div class="grid grid-cols-4 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs">
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Total de O.S.</span>
                <span class="text-lg font-black text-slate-900">{{ $totalOrdens }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Concluídas</span>
                <span class="text-lg font-black text-emerald-700">{{ $totalConcluidas }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Em Andamento</span>
                <span class="text-lg font-black text-blue-700">{{ $totalEmAndamento }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Valor Total Orçado</span>
                <span class="text-lg font-black text-slate-900">R$ {{ number_format($valorTotalOrcado, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Tabela Formatada -->
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-y border-slate-300 text-slate-600 uppercase tracking-wider text-[10px] font-bold bg-slate-50">
                    <th class="py-2.5 px-2">O.S.</th>
                    <th class="py-2.5 px-2">Cliente</th>
                    <th class="py-2.5 px-2">Equipamento</th>
                    <th class="py-2.5 px-2">Técnico</th>
                    <th class="py-2.5 px-2">Abertura</th>
                    <th class="py-2.5 px-2">Status</th>
                    <th class="py-2.5 px-2 text-right">Orçamento</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($ordens as $os)
                    <tr>
                        <td class="py-2 px-2 font-bold font-mono text-blue-700">#{{ str_pad($os->id_os, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-2 px-2 font-semibold text-slate-800">{{ $os->cliente->nome_razao_social ?? '-' }}</td>
                        <td class="py-2 px-2 text-slate-700">{{ $os->equipamento->modelo ?? '-' }}</td>
                        <td class="py-2 px-2 text-slate-600">{{ $os->funcionario->nome ?? '-' }}</td>
                        <td class="py-2 px-2 text-slate-500">{{ date('d/m/Y', strtotime($os->data_abertura)) }}</td>
                        <td class="py-2 px-2">
                            <span class="font-bold text-[11px] {{ $os->status == 'Concluído' ? 'text-emerald-700' : 'text-slate-700' }}">
                                {{ $os->status }}
                            </span>
                        </td>
                        <td class="py-2 px-2 text-right font-bold text-slate-900">R$ {{ number_format($os->orcamento, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-slate-400">Nenhum registro encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-slate-800 font-bold">
                    <td colspan="6" class="py-3 px-2 text-right uppercase text-slate-700 text-xs">Total Geral Orçado:</td>
                    <td class="py-3 px-2 text-right font-black text-slate-900 text-sm">R$ {{ number_format($valorTotalOrcado, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Rodapé do Relatório -->
        <div class="pt-6 border-t border-slate-200 text-center text-[10px] text-slate-400">
            TechAssist &bull; Documento gerado eletronicamente para fins acadêmicos e comprobatórios &bull; IFSC Câmpus Chapecó
        </div>
    </div>
</div>
@endsection

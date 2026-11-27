@extends('layouts.app')

@section('titulo', 'Dashboard - TechForge')

@section('content')
<div class="space-y-6">
    <!-- Header do Painel -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Painel de Controle</h1>
            <p class="text-sm text-slate-500">Visão geral das ordens de serviço, clientes e estoque da assistência técnica.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('ordem_servico.create') }}" 
               class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-600/30 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nova Ordem de Serviço
            </a>
            <a href="{{ route('pedido.create') }}" 
               class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold text-xs shadow transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Novo Pedido
            </a>
        </div>
    </div>

    <!-- Cards de Métricas Principais -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total OS -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Total de O.S.</span>
                <span class="text-2xl font-black text-slate-800">{{ $totalOS }}</span>
                <span class="text-[11px] text-blue-600 font-semibold block">{{ $totalOSEmAndamento }} em andamento</span>
            </div>
        </div>

        <!-- OS Concluídas -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">O.S. Concluídas</span>
                <span class="text-2xl font-black text-slate-800">{{ $totalOSConcluidas }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold block">Serviços finalizados</span>
            </div>
        </div>

        <!-- Clientes & Equipamentos -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center font-bold shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Clientes Ativos</span>
                <span class="text-2xl font-black text-slate-800">{{ $totalClientes }}</span>
                <span class="text-[11px] text-violet-600 font-semibold block">{{ $totalEquipamentos }} equipamentos</span>
            </div>
        </div>

        <!-- Faturamento em Pedidos -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Vendas de Peças</span>
                <span class="text-2xl font-black text-slate-800">R$ {{ number_format($faturamentoPedidos, 2, ',', '.') }}</span>
                <span class="text-[11px] text-amber-600 font-semibold block">{{ $totalEstoque }} itens em estoque</span>
            </div>
        </div>
    </div>

    <!-- Gráficos Analíticos com Chart.js -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico 1: Status das O.S. (Doughnut) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Ordens de Serviço por Status</h2>
                    <p class="text-xs text-slate-400">Distribuição proporcional das etapas de manutenção</p>
                </div>
                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Formato Rosca</span>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="chartOSStatus"></canvas>
            </div>
        </div>

        <!-- Gráfico 2: Estoque por Categoria (Barras) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Saldo de Estoque por Categoria</h2>
                    <p class="text-xs text-slate-400">Unidades disponíveis por segmento de peças</p>
                </div>
                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Formato Barras</span>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="chartEstoqueCategoria"></canvas>
            </div>
        </div>
    </div>

    <!-- Seção Inferior: Últimas Ordens e Alerta de Estoque Baixo -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Tabela das Últimas O.S. -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Últimas Ordens de Serviço</h2>
                <a href="{{ route('ordem_servico.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Ver todas &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-2.5">O.S.</th>
                            <th class="py-2.5">Cliente</th>
                            <th class="py-2.5">Equipamento</th>
                            <th class="py-2.5">Técnico</th>
                            <th class="py-2.5">Status</th>
                            <th class="py-2.5 text-right">Orçamento</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($ultimasOS as $os)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 font-bold text-blue-600">
                                    <a href="{{ route('ordem_servico.show', $os->id_os) }}">#{{ $os->id_os }}</a>
                                </td>
                                <td class="py-3 text-slate-800 font-semibold">{{ $os->cliente->nome_razao_social ?? 'Não informado' }}</td>
                                <td class="py-3 text-slate-600">{{ $os->equipamento->modelo ?? '-' }}</td>
                                <td class="py-3 text-slate-500">{{ $os->funcionario->nome ?? 'Técnico' }}</td>
                                <td class="py-3">
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
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeClass }}">
                                        {{ $os->status }}
                                    </span>
                                </td>
                                <td class="py-3 text-right font-bold text-slate-800">R$ {{ number_format($os->orcamento, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-slate-400">Nenhuma ordem de serviço cadastrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Produtos em Estoque Baixo (1 coluna) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Alerta de Estoque</h2>
                <a href="{{ route('produto.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Estoque &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($produtosEstoqueBaixo as $prod)
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div class="min-w-0 pr-2">
                            <span class="text-xs font-bold text-slate-800 truncate block">{{ $prod->nome }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">{{ $prod->categoria }} &bull; R$ {{ number_format($prod->preco_unitario, 2, ',', '.') }}</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-black {{ $prod->quantidade_estoque <= 5 ? 'bg-rose-100 text-rose-700' : 'bg-slate-200 text-slate-700' }} shrink-0">
                            {{ $prod->quantidade_estoque }} un
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">Estoque zerado ou sem produtos.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Inicialização do Chart.js -->
<script>
    // Gráfico 1: Status das O.S. (Rosca / Doughnut)
    const ctxOS = document.getElementById('chartOSStatus').getContext('2d');
    const osData = @json($osStatusData);
    new Chart(ctxOS, {
        type: 'doughnut',
        data: {
            labels: Object.keys(osData),
            datasets: [{
                data: Object.values(osData),
                backgroundColor: [
                    '#10b981', // Concluído (Verde)
                    '#3b82f6', // Em Reparo (Azul)
                    '#8b5cf6', // Aprovado (Roxo)
                    '#f59e0b', // Aguardando Peça (Laranja)
                    '#64748b', // Em Análise (Slate)
                    '#ef4444', // Cancelado (Vermelho)
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 12,
                        font: { size: 11, family: 'sans-serif' }
                    }
                }
            }
        }
    });

    // Gráfico 2: Estoque por Categoria (Barras / Bar)
    const ctxCat = document.getElementById('chartEstoqueCategoria').getContext('2d');
    const catData = @json($produtosPorCategoria);
    new Chart(ctxCat, {
        type: 'bar',
        data: {
            labels: Object.keys(catData),
            datasets: [{
                label: 'Unidades em Estoque',
                data: Object.values(catData),
                backgroundColor: '#2563eb',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endsection

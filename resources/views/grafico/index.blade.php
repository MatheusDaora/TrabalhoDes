@extends('layouts.app')

@section('titulo', 'Gráficos Analíticos - TechAssist')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Gráficos Analíticos do Sistema</h1>
            <p class="text-sm text-slate-500">Indicadores gerados dinamicamente a partir dos registros reais do banco de dados.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200">
                2 Formatos Diferentes (Rosca &amp; Barras)
            </span>
        </div>
    </div>

    <!-- Grid dos 2 Gráficos Obrigatórios -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico 1: Rosca / Doughnut (Ordens de Serviço por Status) -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-start justify-between pb-3 border-b border-slate-100">
                <div>
                    <span class="text-[10px] uppercase font-bold text-blue-600 tracking-wider block">Gráfico 1 &bull; Formato Rosca (Doughnut)</span>
                    <h2 class="text-lg font-black text-slate-900">Ordens de Serviço por Status</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Tabela: <code class="font-mono text-slate-600 bg-slate-100 px-1 rounded">ordens_servico</code> &bull; Agrupamento por status</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                    01
                </div>
            </div>

            <div class="h-80 flex items-center justify-center p-2">
                <canvas id="graficoStatusOS"></canvas>
            </div>

            <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Total de O.S. Analisadas: <strong>{{ array_sum($valoresOS) }}</strong></span>
                <span class="text-blue-600 font-bold">Atualizado em tempo real</span>
            </div>
        </div>

        <!-- Gráfico 2: Barras / Bar (Saldo em Estoque por Categoria) -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-start justify-between pb-3 border-b border-slate-100">
                <div>
                    <span class="text-[10px] uppercase font-bold text-emerald-600 tracking-wider block">Gráfico 2 &bull; Formato Barras Verticais (Bar)</span>
                    <h2 class="text-lg font-black text-slate-900">Saldo em Estoque por Categoria</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Tabela: <code class="font-mono text-slate-600 bg-slate-100 px-1 rounded">produtos</code> &bull; Soma de quantidades físicas</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                    02
                </div>
            </div>

            <div class="h-80 flex items-center justify-center p-2">
                <canvas id="graficoEstoqueCat"></canvas>
            </div>

            <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Total de Peças em Estoque: <strong>{{ array_sum($valoresCategoria) }} unidades</strong></span>
                <span class="text-emerald-600 font-bold">Atualizado em tempo real</span>
            </div>
        </div>
    </div>
</div>

<script>
    // Gráfico 1: Rosca (Ordens de Serviço por Status)
    const ctxOS = document.getElementById('graficoStatusOS').getContext('2d');
    new Chart(ctxOS, {
        type: 'doughnut',
        data: {
            labels: @json($labelsOS),
            datasets: [{
                data: @json($valoresOS),
                backgroundColor: [
                    '#10b981', // Concluído
                    '#3b82f6', // Em Reparo
                    '#8b5cf6', // Aprovado
                    '#f59e0b', // Aguardando Peça
                    '#64748b', // Em Análise
                    '#ef4444', // Cancelado
                ],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 14,
                        padding: 14,
                        font: { size: 12, family: 'sans-serif', weight: 'bold' }
                    }
                }
            }
        }
    });

    // Gráfico 2: Barras (Saldo em Estoque por Categoria)
    const ctxCat = document.getElementById('graficoEstoqueCat').getContext('2d');
    new Chart(ctxCat, {
        type: 'bar',
        data: {
            labels: @json($labelsCategoria),
            datasets: [{
                label: 'Unidades em Estoque',
                data: @json($valoresCategoria),
                backgroundColor: '#10b981',
                borderRadius: 8,
                maxBarThickness: 45
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
                    ticks: { precision: 0, font: { size: 11 } },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { font: { size: 11, weight: 'bold' } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection

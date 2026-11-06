@extends('layouts.app')

@section('titulo', 'Abrir Nova O.S. - TechAssist')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Abertura de Ordem de Serviço</h1>
            <p class="text-sm text-slate-500">Registre o chamado de assistência técnica vinculando cliente, equipamento e técnico.</p>
        </div>
        <a href="{{ route('ordem_servico.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('ordem_servico.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        <!-- Vínculos / Relacionamentos (Critério 7) -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Vínculos do Atendimento (Critério 7: Relacionamentos 1:1 e 1:N com Selects)
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Select Cliente (1:N) -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_cliente">
                        Cliente Solicitante (1:N) <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_cliente" id="id_cliente" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="">Selecione o cliente...</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}>
                                {{ $cliente->nome_razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Equipamento (1:1 com O.S.) -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_equipamento">
                        Equipamento do Cliente (1:1) <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_equipamento" id="id_equipamento" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="">Selecione o equipamento...</option>
                        @foreach($equipamentos as $eq)
                            <option value="{{ $eq->id_equipamento }}" {{ old('id_equipamento') == $eq->id_equipamento ? 'selected' : '' }}>
                                {{ $eq->modelo }} (S/N: {{ $eq->numero_serie }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Funcionário / Técnico (1:N) -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_funcionario">
                        Técnico Responsável (1:N) <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_funcionario" id="id_funcionario" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="">Selecione o técnico...</option>
                        @foreach($funcionarios as $func)
                            <option value="{{ $func->id_funcionario }}" {{ old('id_funcionario') == $func->id_funcionario ? 'selected' : '' }}>
                                {{ $func->nome }} ({{ $func->perfil }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Dados do Atendimento -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Diagnóstico, Prazos e Orçamento
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="diagnostico">
                        Diagnóstico Técnico / Relato do Defeito <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="diagnostico" id="diagnostico" rows="4" required placeholder="Descreva os sintomas apresentados pelo computador e o laudo preliminar..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">{{ old('diagnostico') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="data_abertura">
                        Data de Abertura <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="data_abertura" id="data_abertura" value="{{ old('data_abertura', date('Y-m-d')) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="orcamento">
                        Orçamento Estimado (R$) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="orcamento" id="orcamento" value="{{ old('orcamento', '0.00') }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="status">
                        Status Inicial da O.S. <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="Em Análise" {{ old('status') == 'Em Análise' ? 'selected' : '' }}>Em Análise</option>
                        <option value="Aguardando Peça" {{ old('status') == 'Aguardando Peça' ? 'selected' : '' }}>Aguardando Peça</option>
                        <option value="Aprovado" {{ old('status') == 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
                        <option value="Em Reparo" {{ old('status') == 'Em Reparo' ? 'selected' : '' }}>Em Reparo</option>
                        <option value="Concluído" {{ old('status') == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                        <option value="Cancelado" {{ old('status') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="data_conclusao">
                        Data de Conclusão (Opcional)
                    </label>
                    <input type="date" name="data_conclusao" id="data_conclusao" value="{{ old('data_conclusao') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('ordem_servico.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Abrir Ordem de Serviço
            </button>
        </div>
    </form>
</div>
@endsection

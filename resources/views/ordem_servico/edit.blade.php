@extends('layouts.app')

@section('titulo', 'Editar O.S. #' . $os->id_os . ' - TechForge')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Editar Ordem de Serviço #{{ $os->id_os }}</h1>
            <p class="text-sm text-slate-500">Atualize o status, laudo técnico e orçamento da manutenção.</p>
        </div>
        <a href="{{ route('ordem_servico.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('ordem_servico.update', $os->id_os) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <!-- Vínculos / Relacionamentos -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Vínculos do Atendimento
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_cliente">
                        Cliente Solicitante <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_cliente" id="id_cliente" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente', $os->id_cliente) == $cliente->id_cliente ? 'selected' : '' }}>
                                {{ $cliente->nome_razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_equipamento">
                        Equipamento <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_equipamento" id="id_equipamento" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        @foreach($equipamentos as $eq)
                            <option value="{{ $eq->id_equipamento }}" {{ old('id_equipamento', $os->id_equipamento) == $eq->id_equipamento ? 'selected' : '' }}>
                                {{ $eq->modelo }} (S/N: {{ $eq->numero_serie }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_funcionario">
                        Técnico Responsável <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_funcionario" id="id_funcionario" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        @foreach($funcionarios as $func)
                            <option value="{{ $func->id_funcionario }}" {{ old('id_funcionario', $os->id_funcionario) == $func->id_funcionario ? 'selected' : '' }}>
                                {{ $func->nome }} ({{ $func->perfil }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Detalhes do Serviço -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Diagnóstico e Atualização de Status
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="diagnostico">
                        Diagnóstico Técnico / Relato do Defeito <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="diagnostico" id="diagnostico" rows="4" required
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">{{ old('diagnostico', $os->diagnostico) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="data_abertura">
                        Data de Abertura <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="data_abertura" id="data_abertura" value="{{ old('data_abertura', $os->data_abertura) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="orcamento">
                        Orçamento (R$) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="orcamento" id="orcamento" value="{{ old('orcamento', $os->orcamento) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="status">
                        Status da O.S. <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="Em Análise" {{ old('status', $os->status) == 'Em Análise' ? 'selected' : '' }}>Em Análise</option>
                        <option value="Aguardando Peça" {{ old('status', $os->status) == 'Aguardando Peça' ? 'selected' : '' }}>Aguardando Peça</option>
                        <option value="Aprovado" {{ old('status', $os->status) == 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
                        <option value="Em Reparo" {{ old('status', $os->status) == 'Em Reparo' ? 'selected' : '' }}>Em Reparo</option>
                        <option value="Concluído" {{ old('status', $os->status) == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                        <option value="Cancelado" {{ old('status', $os->status) == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="data_conclusao">
                        Data de Conclusão
                    </label>
                    <input type="date" name="data_conclusao" id="data_conclusao" value="{{ old('data_conclusao', $os->data_conclusao) }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('ordem_servico.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Atualizar O.S.
            </button>
        </div>
    </form>
</div>
@endsection

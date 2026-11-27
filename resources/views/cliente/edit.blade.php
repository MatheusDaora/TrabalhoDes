@extends('layouts.app')

@section('titulo', 'Editar Cliente - TechForge')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Editar Cliente</h1>
            <p class="text-sm text-slate-500">Atualize as informações cadastrais de {{ $cliente->nome_razao_social }}.</p>
        </div>
        <a href="{{ route('cliente.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('cliente.update', $cliente->id_cliente) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Dados Cadastrais
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="nome_razao_social">
                        Nome Completo / Razão Social <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nome_razao_social" id="nome_razao_social" value="{{ old('nome_razao_social', $cliente->nome_razao_social) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="cpf_cnpj">
                        CPF ou CNPJ <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" value="{{ old('cpf_cnpj', $cliente->cpf_cnpj) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="email">
                        E-mail de Contato <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $cliente->email) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="telefone">
                        Telefone / WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $cliente->telefone) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="data_nascimento">
                        Data de Nascimento
                    </label>
                    <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento', $cliente->data_nascimento) }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="data_cadastro">
                        Data de Cadastro <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="data_cadastro" id="data_cadastro" value="{{ old('data_cadastro', $cliente->data_cadastro) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="status">
                        Status <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="Ativo" {{ old('status', $cliente->status) == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="Inativo" {{ old('status', $cliente->status) == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                        <option value="Bloqueado" {{ old('status', $cliente->status) == 'Bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('cliente.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Atualizar Cadastro
            </button>
        </div>
    </form>
</div>
@endsection

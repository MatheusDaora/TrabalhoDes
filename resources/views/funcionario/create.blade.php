@extends('layouts.app')

@section('titulo', 'Novo Funcionário - TechAssist')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Novo Funcionário / Técnico</h1>
            <p class="text-sm text-slate-500">Cadastre um novo colaborador para atuação na assistência.</p>
        </div>
        <a href="{{ route('funcionario.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('funcionario.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="nome">
                    Nome Completo <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="email">
                    E-mail Corporativo <span class="text-rose-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="perfil">
                    Cargo / Perfil de Atuação <span class="text-rose-500">*</span>
                </label>
                <select name="perfil" id="perfil" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                    <option value="Técnico de Manutenção" {{ old('perfil') == 'Técnico de Manutenção' ? 'selected' : '' }}>Técnico de Manutenção</option>
                    <option value="Técnica de Hardware" {{ old('perfil') == 'Técnica de Hardware' ? 'selected' : '' }}>Técnica de Hardware</option>
                    <option value="Atendente Técnico" {{ old('perfil') == 'Atendente Técnico' ? 'selected' : '' }}>Atendente Técnico</option>
                    <option value="Gerente de Laboratório" {{ old('perfil') == 'Gerente de Laboratório' ? 'selected' : '' }}>Gerente de Laboratório</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="data_admissao">
                    Data de Admissão <span class="text-rose-500">*</span>
                </label>
                <input type="date" name="data_admissao" id="data_admissao" value="{{ old('data_admissao', date('Y-m-d')) }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('funcionario.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Cadastrar Funcionário
            </button>
        </div>
    </form>
</div>
@endsection

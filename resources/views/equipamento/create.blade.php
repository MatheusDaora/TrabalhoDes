@extends('layouts.app')

@section('titulo', 'Novo Equipamento - TechAssist')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Cadastrar Equipamento</h1>
            <p class="text-sm text-slate-500">Cadastre a máquina entregue pelo cliente com foto e número de série.</p>
        </div>
        <a href="{{ route('equipamento.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('equipamento.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Select do Cliente (Critério 7: Relacionamento 1:N com exibição de nome) -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_cliente">
                    Proprietário do Equipamento (Cliente) <span class="text-rose-500">*</span>
                </label>
                <select name="id_cliente" id="id_cliente" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                    <option value="">Selecione o cliente proprietário...</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}>
                            {{ $cliente->nome_razao_social }} (CPF/CNPJ: {{ $cliente->cpf_cnpj }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Diagrama: 1 Cliente possui N Equipamentos cadastrados.</p>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="modelo">
                    Modelo do Equipamento <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="modelo" id="modelo" value="{{ old('modelo') }}" placeholder="Ex.: Notebook Dell Inspiron 15 3520 i5" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="marca">
                    Marca / Fabricante <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="marca" id="marca" value="{{ old('marca') }}" placeholder="Ex.: Dell, Lenovo, Apple, HP, Asus" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="numero_serie">
                    Número de Série / Service Tag <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="numero_serie" id="numero_serie" value="{{ old('numero_serie') }}" placeholder="Ex.: DELL-INSP-98214" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition font-mono">
            </div>

            <!-- Upload de Foto do Equipamento (Critério 4 - 2º Formulário com Upload) -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="imagem">
                    Foto do Equipamento (Critério 4 - Upload de Imagem de Entrada)
                </label>
                <input type="file" name="imagem" id="imagem" accept="image/*"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-[11px] text-slate-400 mt-1">Registre o estado visual da máquina na entrega. Formatos: JPG, PNG, WEBP até 2MB.</p>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('equipamento.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Cadastrar Equipamento
            </button>
        </div>
    </form>
</div>
@endsection

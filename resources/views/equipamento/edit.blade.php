@extends('layouts.app')

@section('titulo', 'Editar Equipamento - TechAssist')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Editar Equipamento</h1>
            <p class="text-sm text-slate-500">Atualize os dados e foto de {{ $equipamento->modelo }}.</p>
        </div>
        <a href="{{ route('equipamento.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('equipamento.update', $equipamento->id_equipamento) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Select do Cliente (Critério 7) -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_cliente">
                    Proprietário do Equipamento (Cliente) <span class="text-rose-500">*</span>
                </label>
                <select name="id_cliente" id="id_cliente" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente', $equipamento->id_cliente) == $cliente->id_cliente ? 'selected' : '' }}>
                            {{ $cliente->nome_razao_social }} (CPF/CNPJ: {{ $cliente->cpf_cnpj }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="modelo">
                    Modelo do Equipamento <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $equipamento->modelo) }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="marca">
                    Marca / Fabricante <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="marca" id="marca" value="{{ old('marca', $equipamento->marca) }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="numero_serie">
                    Número de Série / Service Tag <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="numero_serie" id="numero_serie" value="{{ old('numero_serie', $equipamento->numero_serie) }}" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition font-mono">
            </div>

            <!-- Imagem Atual & Upload Novo (Critério 4) -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Foto do Equipamento (Critério 4 - Visualização na Edição)
                </label>

                @if($equipamento->imagem)
                    <div class="mb-3 flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200 w-fit">
                        <img src="{{ asset('storage/' . $equipamento->imagem) }}" alt="{{ $equipamento->modelo }}" class="w-16 h-16 object-cover rounded-lg border border-slate-200 shadow-xs">
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">Foto atual registrada</span>
                            <span class="text-[10px] text-slate-400">Envie um novo arquivo abaixo para substituir a foto existente.</span>
                        </div>
                    </div>
                @endif

                <input type="file" name="imagem" id="imagem" accept="image/*"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('equipamento.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Atualizar Equipamento
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('titulo', 'Novo Pedido de Peças - TechForge')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Registrar Pedido de Peças</h1>
            <p class="text-sm text-slate-500">Selecione o cliente, endereço de entrega e os produtos solicitados.</p>
        </div>
        <a href="{{ route('pedido.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('pedido.store') }}" method="POST" id="formPedido" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        <!-- Dados do Pedido -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Dados Gerais do Pedido
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_cliente">
                        Cliente Comprador <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_cliente" id="id_cliente" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="">Selecione o cliente...</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}>
                                {{ $cliente->nome_razao_social }} (CPF/CNPJ: {{ $cliente->cpf_cnpj }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="data_pedido">
                        Data do Pedido <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="data_pedido" id="data_pedido" value="{{ old('data_pedido', date('Y-m-d')) }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="status">
                        Status do Pedido <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="Pendente" {{ old('status') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="Pago" {{ old('status') == 'Pago' ? 'selected' : '' }}>Pago</option>
                        <option value="Em Separação" {{ old('status') == 'Em Separação' ? 'selected' : '' }}>Em Separação</option>
                        <option value="Entregue" {{ old('status') == 'Entregue' ? 'selected' : '' }}>Entregue</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Opção de Entrega
                    </label>
                    <label class="flex items-center gap-2 p-2 border border-slate-200 rounded-xl cursor-pointer bg-slate-50">
                        <input type="checkbox" name="requer_entrega" id="requer_entrega" value="1" {{ old('requer_entrega') ? 'checked' : '' }}
                               onchange="document.getElementById('divEndereco').classList.toggle('hidden', !this.checked)"
                               class="rounded text-blue-600">
                        <span class="text-xs font-bold text-slate-700">Requer Envio / Entrega</span>
                    </label>
                </div>

                <div id="divEndereco" class="{{ old('requer_entrega') ? '' : 'hidden' }}">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1" for="id_endereco_entrega">
                        Endereço de Entrega (1:N)
                    </label>
                    <select name="id_endereco_entrega" id="id_endereco_entrega" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none transition bg-white">
                        <option value="">Selecione o endereço de entrega...</option>
                        @foreach($enderecos as $end)
                            <option value="{{ $end->id_endereco }}" {{ old('id_endereco_entrega') == $end->id_endereco ? 'selected' : '' }}>
                                {{ $end->cliente->nome_razao_social ?? 'Cliente' }} &bull; {{ $end->rua }}, {{ $end->numero }} ({{ $end->cidade }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Itens do Pedido -->
        <div>
            <div class="flex items-center justify-between pb-2 border-b border-slate-100 mb-4">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Itens do Pedido
                </h2>
                <button type="button" onclick="adicionarLinhaItem()" class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold hover:bg-blue-100 transition">
                    + Adicionar Outro Produto
                </button>
            </div>

            <div id="containerItens" class="space-y-3">
                <div class="linha-item grid grid-cols-1 sm:grid-cols-12 gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200/80 items-center">
                    <div class="sm:col-span-7">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Produto / Peça</label>
                        <select name="produtos[0][id_produto]" required onchange="atualizarPreco(this)" class="select-produto w-full px-3 py-2 rounded-lg border border-slate-200 text-xs bg-white">
                            <option value="" data-preco="0">Selecione o produto...</option>
                            @foreach($produtos as $prod)
                                <option value="{{ $prod->id_produto }}" data-preco="{{ $prod->preco_unitario }}">
                                    {{ $prod->nome }} &bull; Estoque: {{ $prod->quantidade_estoque }} un (R$ {{ number_format($prod->preco_unitario, 2, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Qtd</label>
                        <input type="number" name="produtos[0][quantidade]" value="1" min="1" required oninput="calcularTotalGeral()"
                               class="input-qtd w-full px-3 py-2 rounded-lg border border-slate-200 text-xs bg-white">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Subtotal</label>
                        <span class="subtotal-item text-xs font-black text-slate-800 block pt-1.5">R$ 0,00</span>
                    </div>
                    <div class="sm:col-span-1 text-right pt-4 sm:pt-0">
                        <button type="button" onclick="removerLinha(this)" class="text-slate-400 hover:text-rose-600 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Totalizador Dinâmico -->
            <div class="p-4 bg-slate-900 text-white rounded-xl flex items-center justify-between mt-4">
                <span class="text-xs uppercase font-bold tracking-wider text-slate-300">Valor Total do Pedido:</span>
                <span id="valorTotalTexto" class="text-xl font-black text-white">R$ 0,00</span>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('pedido.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/30 transition">
                Finalizar e Salvar Pedido
            </button>
        </div>
    </form>
</div>

<script>
    let indiceLinha = 1;

    function atualizarPreco(select) {
        calcularTotalGeral();
    }

    function calcularTotalGeral() {
        let total = 0;
        const linhas = document.querySelectorAll('.linha-item');
        linhas.forEach(linha => {
            const select = linha.querySelector('.select-produto');
            const inputQtd = linha.querySelector('.input-qtd');
            const spanSub = linha.querySelector('.subtotal-item');

            const option = select.options[select.selectedIndex];
            const preco = parseFloat(option ? option.getAttribute('data-preco') : 0) || 0;
            const qtd = parseInt(inputQtd.value) || 0;
            const subtotal = preco * qtd;

            spanSub.textContent = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
            total += subtotal;
        });

        document.getElementById('valorTotalTexto').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    }

    function adicionarLinhaItem() {
        const container = document.getElementById('containerItens');
        const novaLinha = document.createElement('div');
        novaLinha.className = 'linha-item grid grid-cols-1 sm:grid-cols-12 gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200/80 items-center';
        
        novaLinha.innerHTML = `
            <div class="sm:col-span-7">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Produto / Peça</label>
                <select name="produtos[${indiceLinha}][id_produto]" required onchange="atualizarPreco(this)" class="select-produto w-full px-3 py-2 rounded-lg border border-slate-200 text-xs bg-white">
                    <option value="" data-preco="0">Selecione o produto...</option>
                    @foreach($produtos as $prod)
                        <option value="{{ $prod->id_produto }}" data-preco="{{ $prod->preco_unitario }}">
                            {{ $prod->nome }} &bull; Estoque: {{ $prod->quantidade_estoque }} un (R$ {{ number_format($prod->preco_unitario, 2, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Qtd</label>
                <input type="number" name="produtos[${indiceLinha}][quantidade]" value="1" min="1" required oninput="calcularTotalGeral()"
                       class="input-qtd w-full px-3 py-2 rounded-lg border border-slate-200 text-xs bg-white">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Subtotal</label>
                <span class="subtotal-item text-xs font-black text-slate-800 block pt-1.5">R$ 0,00</span>
            </div>
            <div class="sm:col-span-1 text-right pt-4 sm:pt-0">
                <button type="button" onclick="removerLinha(this)" class="text-slate-400 hover:text-rose-600 p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        `;
        container.appendChild(novaLinha);
        indiceLinha++;
    }

    function removerLinha(btn) {
        const container = document.getElementById('containerItens');
        if (container.querySelectorAll('.linha-item').length > 1) {
            btn.closest('.linha-item').remove();
            calcularTotalGeral();
        } else {
            alert('O pedido deve possuir pelo menos 1 item.');
        }
    }
</script>
@endsection

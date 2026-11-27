<aside class="w-64 bg-slate-900 text-white min-h-screen flex flex-col justify-between shrink-0 shadow-xl">
    <div>
        <!-- Logo / Marca -->
        <div class="p-6 border-b border-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-black text-lg text-white shadow-md shadow-blue-500/30">
                TA
            </div>
            <div>
                <h2 class="text-lg font-black tracking-tight text-white leading-tight">TechForge</h2>
                <span class="text-[10px] uppercase font-bold tracking-wider text-blue-400 block">Assistência Técnica</span>
            </div>
        </div>

        <!-- Links de Navegação -->
        <nav class="p-4 space-y-1 text-sm">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>

            <div class="pt-3 pb-1 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                Ordens & Atendimento
            </div>

            <a href="{{ route('ordem_servico.index') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('ordem_servico.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Ordens de Serviço
            </a>

            <a href="{{ route('equipamento.index') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('equipamento.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Equipamentos
            </a>

            <a href="{{ route('cliente.index') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('cliente.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Clientes
            </a>

            <div class="pt-3 pb-1 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                Peças & Vendas
            </div>

            <a href="{{ route('produto.index') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('produto.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Produtos & Peças
            </a>

            <a href="{{ route('pedido.index') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('pedido.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Pedidos de Peças
            </a>

            <a href="{{ route('funcionario.index') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('funcionario.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Funcionários / Técnicos
            </a>

            <div class="pt-3 pb-1 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                Relatórios & Análise
            </div>

            <a href="{{ route('relatorio.index') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('relatorio.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Relatórios em PDF
            </a>

            <a href="{{ route('grafico.index') }}" 
               class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition font-medium {{ request()->routeIs('grafico.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                Gráficos Analíticos
            </a>
        </nav>
    </div>

    <!-- Usuário Logado & Logout -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/60">
        @if(auth()->check())
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-blue-600/20 text-blue-400 font-bold flex items-center justify-center text-xs shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="truncate">
                        <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" title="Sair do Sistema" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-rose-950/40 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        @endif
    </div>
</aside>

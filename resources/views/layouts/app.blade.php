<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'TechAssist - Gestão de Assistência Técnica')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af', // Blue 800
                        secondary: '#0f172a', // Slate 900
                    }
                }
            }
        }
    </script>
    <!-- Chart.js para os gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="h-full flex flex-col md:flex-row text-slate-800 antialiased font-sans">
    <!-- Topbar Mobile -->
    <header class="md:hidden bg-slate-900 text-white p-4 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center font-bold text-sm text-white shadow">
                TA
            </div>
            <div>
                <span class="font-bold text-base block leading-none">TechAssist</span>
                <span class="text-[10px] text-blue-300 uppercase tracking-wider font-medium">Assistência Técnica</span>
            </div>
        </div>
        <button id="mobileMenuBtn" class="p-2 rounded-lg bg-slate-800 text-slate-200 hover:text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </header>

    <!-- Sidebar Wrapper -->
    <div id="sidebarContainer" class="hidden md:flex shrink-0">
        @include('layouts.sidebar')
    </div>

    <!-- Conteúdo Principal -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Alerta de Sucesso -->
            @if(session('sucesso'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-5 py-4 rounded-xl shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-semibold">{{ session('sucesso') }}</span>
                    </div>
                </div>
            @endif

            <!-- Alerta de Erro -->
            @if(session('erro'))
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-5 py-4 rounded-xl shadow-xs flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-semibold">{{ session('erro') }}</span>
                </div>
            @endif

            <!-- Erros de Validação -->
            @if($errors->any())
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-5 rounded-xl shadow-xs">
                    <div class="flex items-center gap-2 mb-2 font-bold text-sm text-rose-900">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Por favor, corrija os erros abaixo:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        // Menu Mobile Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebarContainer = document.getElementById('sidebarContainer');
        if (mobileMenuBtn && sidebarContainer) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebarContainer.classList.toggle('hidden');
            });
        }
    </script>
</body>
</html>

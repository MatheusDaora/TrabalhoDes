<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechForge</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center p-4 bg-slate-900 text-slate-800">
    <div class="max-w-md w-full">
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-blue-600 items-center justify-center font-black text-2xl text-white shadow-lg shadow-blue-500/30 mb-3">
                TA
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">TechForge</h1>
            <p class="text-xs uppercase tracking-widest font-bold text-blue-400 mt-0.5">Sistema de Assistência de Computadores</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-slate-200">
            <h2 class="text-xl font-bold text-slate-900 mb-1">Acessar o Painel</h2>
            <p class="text-xs text-slate-500 mb-6">Entre com suas credenciais cadastradas para continuar.</p>

            @if(session('sucesso'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs px-4 py-3 rounded-xl font-medium">
                    {{ session('sucesso') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs px-4 py-3 rounded-xl font-medium">
                    @foreach($errors->all() as $erro)
                        <p>{{ $erro }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email', 'admin@TechForge.com') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" for="password">Senha</label>
                    <input type="password" name="password" id="password" value="admin123" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        Lembrar de mim
                    </label>
                </div>

                <button type="submit" 
                        class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-600/30 transition flex items-center justify-center gap-2 mt-2">
                    <span>Entrar no Sistema</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <!-- Card de Credencial Padrão para Avaliação -->
            <div class="mt-6 p-3.5 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-900 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <span class="font-bold">Acesso para Avaliação:</span>
                    <p class="text-[11px] text-blue-800 mt-0.5">E-mail: <code class="bg-blue-100 px-1 py-0.5 rounded font-mono font-bold">admin@TechForge.com</code></p>
                    <p class="text-[11px] text-blue-800">Senha: <code class="bg-blue-100 px-1 py-0.5 rounded font-mono font-bold">admin123</code></p>
                </div>
            </div>

            <div class="mt-6 text-center text-xs text-slate-500">
                Não possui conta? 
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Cadastre-se</a>
            </div>
        </div>
    </div>
</body>
</html>

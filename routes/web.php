<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\GraficoController;

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação / Sessão (Login, Registro e Logout)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas por Autenticação (Session Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard Principal com Indicadores e Gráficos
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // CRUDs Completos
    Route::resource('cliente', ClienteController::class);
    Route::resource('funcionario', FuncionarioController::class);
    Route::resource('produto', ProdutoController::class);
    Route::resource('equipamento', EquipamentoController::class);
    Route::resource('ordem_servico', OrdemServicoController::class);
    Route::resource('pedido', PedidoController::class);

    // Endereços (armazenamento e exclusão)
    Route::post('/endereco', [EnderecoController::class, 'store'])->name('endereco.store');
    Route::delete('/endereco/{id}', [EnderecoController::class, 'destroy'])->name('endereco.destroy');

    // Relatórios para Impressão / PDF
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorio.index');
    Route::get('/relatorios/ordens-servico', [RelatorioController::class, 'ordensServico'])->name('relatorio.ordens_servico');
    Route::get('/relatorios/produtos', [RelatorioController::class, 'produtos'])->name('relatorio.produtos');

    // Gráficos Analíticos
    Route::get('/graficos', [GraficoController::class, 'index'])->name('grafico.index');
});

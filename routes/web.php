<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ColaboradorController;

use App\Models\Cliente;
use App\Models\Produto;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin
    Route::middleware('is_admin')->group(function () {
        Route::resources([
            'clientes' => ClienteController::class,
            'produtos' => ProdutoController::class,
            'colaboradores' => ColaboradorController::class,
        ]);
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    });

    // Vendedor
    Route::middleware('is_vendedor')->group(function () {
        Route::resource('vendas', VendaController::class);
    });

    // APIs
    Route::prefix('api')->group(function () {
        Route::get('/clientes', function () {
            return Cliente::select('id', 'nome')
                ->where('nome', 'like', '%' . request('term') . '%')
                ->limit(10)
                ->get();
        })->name('api.clientes');

        Route::get('/produtos', function () {
            return Produto::select('id', 'nome', 'preco', 'estoque', 'imagem')
                ->where('nome', 'like', '%' . request('term') . '%')
                ->limit(10)
                ->get()
                ->map(function ($produto) {
                    $produto->imagem = $produto->imagem ? asset($produto->imagem) : null;
                    return $produto;
                });
        })->name('api.produtos');
    });
});

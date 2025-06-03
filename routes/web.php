<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroPontoController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UsuarioController;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Dashboard principal
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Autenticação do perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Formulário de registro de ponto
Route::middleware(['auth'])->group(function () {
    Route::get('/ponto', function () {
        return view('ponto.form');
    })->name('ponto.form');

    Route::post('/registrar-ponto', [RegistroPontoController::class, 'registrar'])->name('registrar.ponto');
});

// Dashboard do administrador
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/funcionario/{id}/registros', [AdminDashboardController::class, 'registros'])->name('admin.registros');
    Route::get('/admin/funcionario/{id}/relatorio-pdf', [AdminDashboardController::class, 'gerarPdf'])->name('admin.registros.pdf');
});

// Gestão de usuários (funcionários)
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{user}', [UsuarioController::class, 'show'])->name('usuarios.show');

    // Geração de relatórios
    Route::get('/usuarios/{user}/relatorio', [UsuarioController::class, 'formRelatorio'])->name('usuarios.formRelatorio');
    Route::post('/usuarios/{user}/relatorio', [UsuarioController::class, 'gerarRelatorio'])->name('usuarios.gerarRelatorio');
});
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
require __DIR__ . '/auth.php';

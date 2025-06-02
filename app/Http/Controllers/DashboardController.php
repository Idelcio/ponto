<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\RegistroPonto;

class DashboardController extends Controller
{
    /**
     * Mostra a dashboard para admin ou funcionário.
     */
    public function index()
    {
        $user = Auth::user();

        // Se for admin, carrega os registros e funcionários
        if ($user->is_admin) {
            $registros = RegistroPonto::with('user')->latest()->take(10)->get();
            $funcionarios = User::where('is_admin', false)->get();

            return view('dashboard', compact('registros', 'funcionarios'));
        }

        // Se for funcionário, apenas renderiza a dashboard simples
        return view('dashboard');
    }
}

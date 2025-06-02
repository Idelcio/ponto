<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RegistroPonto;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Acesso não autorizado.');
        }

        $funcionarios = User::where('is_admin', false)->get();
        $registros = RegistroPonto::with('user')->orderByDesc('registrado_em')->limit(50)->get();

        return view('admin.dashboard', compact('funcionarios', 'registros'));
    }

    public function registros($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Acesso não autorizado.');
        }

        $funcionario = User::findOrFail($id);

        $registros = RegistroPonto::where('user_id', $id)
            ->orderByDesc('registrado_em')
            ->paginate(10);

        return view('admin.registros', compact('funcionario', 'registros'));
    }
}

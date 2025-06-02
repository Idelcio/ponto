<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class UsuarioController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->is_admin) abort(403);

        $usuarios = User::where('is_admin', false)->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function show(User $user)
    {
        if (!Auth::check() || !Auth::user()->is_admin) abort(403);
        if ($user->is_admin) abort(403);

        $registros = $user->registros()
            ->orderBy('registrado_em')
            ->get()
            ->groupBy(function ($registro) {
                return $registro->registrado_em->format('Y-m'); // Agrupado por mês
            })
            ->map(function ($registrosMes) {
                return $registrosMes->groupBy(function ($registro) {
                    return $registro->registrado_em->format('d/m/Y'); // Agrupado por dia dentro do mês
                });
            });

        return view('usuarios.show', compact('user', 'registros'));
    }


    public function formRelatorio(User $user)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        return view('usuarios.relatorio-form', compact('user'));
    }

    public function gerarRelatorio(Request $request, User $user)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }


        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2000|max:2100',
        ]);

        $mes = $request->mes;
        $ano = $request->ano;

        $registros = $user->registros()
            ->whereYear('registrado_em', $ano)
            ->whereMonth('registrado_em', $mes)
            ->orderBy('registrado_em')
            ->get()
            ->groupBy(function ($registro) {
                return Carbon::parse($registro->registrado_em)->format('d/m/Y');
            });

        $pdf = Pdf::loadView('usuarios.relatorio-pdf', [
            'user' => $user,
            'registros' => $registros,
            'mes' => $mes,
            'ano' => $ano,
            'gerado_em' => now()->format('d/m/Y H:i'),
        ]);

        return $pdf->download("relatorio-ponto-{$user->id}-{$mes}-{$ano}.pdf");
    }
}

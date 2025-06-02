<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use App\Models\RegistroPonto;
use App\Mail\RegistroPontoEmail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\View\View|RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Se for funcionário e enviou foto
        if (!$user->is_admin && $request->filled('foto')) {
            $base64 = str_replace('data:image/jpeg;base64,', '', $request->input('foto'));
            $imageData = base64_decode($base64);
            $fileName = 'ponto_' . time() . '.jpg';
            $filePath = 'pontos/' . $fileName;
            Storage::disk('public')->put($filePath, $imageData);

            $registro = RegistroPonto::create([
                'user_id' => $user->id,
                'foto' => $filePath,
                'registrado_em' => now()
            ]);

            Mail::to($user->email)->send(new RegistroPontoEmail($registro));

            // Logout imediato após o registro do ponto
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return view('ponto.registrado', [
                'mensagem' => 'Ponto registrado com sucesso! Você já foi desconectado.'
            ]);
        }

        // Agora, todos (admin ou não) vão para a mesma dashboard
        return redirect()->intended(RouteServiceProvider::HOME);
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

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
     * Exibe o formulário de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Processa o login.
     */
    public function store(LoginRequest $request): View|RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        /** @var \App\Models\User $user */
        $user = Auth::user();


        if ($request->filled('latitude') && $request->filled('longitude')) {
            $user->update([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);
        }


        // Se for funcionário e enviou a foto, registra o ponto
        if (!$user->is_admin && $request->filled('foto')) {
            $base64 = str_replace('data:image/jpeg;base64,', '', $request->input('foto'));
            $imageData = base64_decode($base64);
            $fileName = 'ponto_' . time() . '.jpg';
            $filePath = 'pontos/' . $fileName;

            Storage::disk('public')->put($filePath, $imageData);

            $registro = RegistroPonto::create([
                'user_id' => $user->id,
                'foto' => $filePath,
                'registrado_em' => now(),
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
            ]);

            Mail::to($user->email)->send(new RegistroPontoEmail($registro));

            // Logout após registro do ponto
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return view('ponto.registrado', [
                'mensagem' => 'Ponto registrado com sucesso! Você já foi desconectado.'
            ]);
        }

        // Se for admin ou login normal, redireciona para a dashboard
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

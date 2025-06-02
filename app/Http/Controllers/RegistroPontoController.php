<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistroPonto;
use Illuminate\Support\Facades\Storage;
use App\Mail\RegistroPontoEmail;
use Illuminate\Support\Facades\Mail;

class RegistroPontoController extends Controller
{
    public function registrar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto' => 'required|string',
        ]);

        // Decodifica a imagem base64
        $base64 = $request->input('foto');
        $base64 = str_replace('data:image/jpeg;base64,', '', $base64);
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

        return view('ponto.registrado', [
            'mensagem' => 'Ponto registrado com sucesso!'
        ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\RegistroPonto;

class RegistroPontoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $registro;

    public function __construct(RegistroPonto $registro)
    {
        $this->registro = $registro;
    }

    public function build()
    {
        return $this->subject('Registro de Ponto - ' . $this->registro->user->name)
            ->markdown('emails.registro_ponto');
    }
}

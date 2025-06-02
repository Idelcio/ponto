<x-mail::message>
    # Registro de Ponto Realizado

    **Funcionário:** {{ $registro->user->name }}
    **Horário do Registro:** {{ $registro->data_formatada }}

    <x-mail::panel>
        <p><strong>Foto registrada no momento do ponto:</strong></p>
        <img src="{{ asset('storage/' . $registro->foto) }}" alt="Foto do ponto"
            style="max-width: 100%; border-radius: 8px;">
    </x-mail::panel>

    <x-mail::button :url="asset('storage/' . $registro->foto)">
        Ver Foto em Tamanho Real
    </x-mail::button>

    Obrigado,<br>
    {{ config('app.name') }}
</x-mail::message>

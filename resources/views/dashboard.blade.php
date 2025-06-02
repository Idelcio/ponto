<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Mensagem geral --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <p class="text-gray-600">Bem-vindo, {{ Auth::user()->name }}!</p>
        </div>

        {{-- Se for admin, mostra registros de ponto e lista de funcionários --}}
        @if (Auth::user()->is_admin)
            @isset($funcionarios)
                <div class="bg-white p-6 rounded shadow mb-6">
                    <h3 class="text-lg font-semibold mb-4">Funcionários</h3>
                    <a href="{{ route('register') }}" class="text-blue-600 underline mb-3 inline-block">
                        + Registrar Novo Funcionário
                    </a>
                    <ul class="list-disc list-inside">
                        @foreach ($funcionarios as $funcionario)
                            <li>
                                <a href="{{ route('admin.ponto.funcionario', $funcionario->id) }}"
                                    class="text-indigo-600 hover:underline">
                                    {{ $funcionario->name }} ({{ $funcionario->email }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endisset
            @if (Auth::user()->is_admin)
                <div class="mt-4">
                    <a href="{{ route('usuarios.index') }}" class="text-indigo-600 hover:underline">
                        📋 Ver todos os funcionários
                    </a>
                </div>
            @endif


            @isset($registros)
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-lg font-semibold mb-4">Últimos Registros de Ponto</h3>
                    <table class="w-full table-auto text-sm text-left">
                        <thead>
                            <tr class="border-b">
                                <th>Funcionário</th>
                                <th>Horário</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registros as $registro)
                                <tr class="border-b">
                                    <td class="py-2">{{ $registro->user->name ?? '---' }}</td>
                                    <td>{{ $registro->data_formatada }}</td>
                                    <td>
                                        <a href="{{ url('storage/' . $registro->foto) }}" target="_blank">
                                            <img src="{{ url('storage/' . $registro->foto) }}" alt="foto"
                                                class="w-16 h-16 object-cover rounded">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endisset
        @else
            {{-- Se for funcionário (não admin), apenas mensagem simples --}}
            <div class="bg-white p-6 rounded shadow">
                <p class="text-green-700 font-semibold">Seu ponto foi registrado com sucesso!</p>
            </div>
        @endif
    </div>
</x-app-layout>

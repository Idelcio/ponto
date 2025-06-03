<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 space-y-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-600 text-sm sm:text-base">Bem-vindo, {{ Auth::user()->name }}!</p>
        </div>

        @if (Auth::user()->is_admin)

            {{-- Formulário dropdown --}}
            <div x-data="{ aberto: false }" class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center flex-wrap gap-2">
                    <h3 class="text-lg font-semibold">+ Registrar Novo Funcionário</h3>
                    <button @click="aberto = !aberto"
                        class="text-sm bg-indigo-600 text-white px-4 py-1.5 rounded hover:bg-indigo-700">
                        <span x-show="!aberto">Abrir</span>
                        <span x-show="aberto">Fechar</span>
                    </button>
                </div>

                <div x-show="aberto" x-transition class="mt-4">
                    <form method="POST" action="{{ route('usuarios.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input id="name" name="name" type="text" required
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" name="email" type="email" required
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                            <input id="password" name="password" type="password" required
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                                Senha</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                                Cadastrar Funcionário
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Botão "ver todos" estilizado --}}
            <div class="flex justify-center sm:justify-end">
                <a href="{{ route('usuarios.index') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition text-sm w-full sm:w-auto text-center">
                    📋 Ver todos os Funcionários
                </a>
            </div>

            {{-- Lista de funcionários --}}
            @isset($funcionarios)
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-3">👥 Funcionários</h3>
                    <ul class="space-y-2">
                        @foreach ($funcionarios as $funcionario)
                            <li class="text-sm sm:text-base break-words">
                                <a href="{{ route('admin.ponto.funcionario', $funcionario->id) }}"
                                    class="text-indigo-600 hover:underline">
                                    {{ $funcionario->name }} ({{ $funcionario->email }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endisset

            {{-- Últimos registros --}}
            @isset($registros)
                <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
                    <h3 class="text-lg font-semibold mb-4">🕒 Últimos Registros de Ponto</h3>
                    <table class="min-w-full text-sm border border-gray-200">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-2 border">Funcionário</th>
                                <th class="p-2 border">Horário</th>
                                <th class="p-2 border">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registros as $registro)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-2">{{ $registro->user->name ?? '---' }}</td>
                                    <td class="p-2">{{ $registro->data_formatada }}</td>
                                    <td class="p-2">
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
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-green-700 font-semibold text-sm sm:text-base">Seu ponto foi registrado com sucesso!</p>
            </div>
        @endif
    </div>
</x-app-layout>

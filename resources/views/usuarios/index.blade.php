<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Usuários</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Lista de Funcionários</h3>
            <ul class="divide-y divide-gray-200">
                @foreach ($usuarios as $usuario)
                    <li class="py-3">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <a href="{{ route('usuarios.show', $usuario->id) }}" class="text-blue-600 hover:underline">
                                {{ $usuario->name }} ({{ $usuario->email }})
                            </a>
                            <a href="{{ route('usuarios.formRelatorio', $usuario->id) }}"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded shadow w-max">
                                📄 Gerar Relatório
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>

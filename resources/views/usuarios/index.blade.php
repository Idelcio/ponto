<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Usuários</h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Lista de Funcionários</h3>

            <ul class="divide-y divide-gray-200">
                @forelse ($usuarios as $usuario)
                    <li class="py-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="text-sm sm:text-base text-gray-800 break-words">
                                <a href="{{ route('usuarios.show', $usuario->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $usuario->name }} <span
                                        class="block sm:inline text-gray-500">({{ $usuario->email }})</span>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('usuarios.formRelatorio', $usuario->id) }}"
                                    class="inline-block bg-indigo-600 text-white text-xs sm:text-sm px-4 py-2 rounded shadow hover:bg-indigo-700 transition">
                                    📄 Gerar Relatório
                                </a>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="py-4 text-gray-500 text-sm">Nenhum funcionário cadastrado ainda.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>

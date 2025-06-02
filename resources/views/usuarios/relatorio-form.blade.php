<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Gerar Relatório de Ponto – {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('usuarios.gerarRelatorio', $user->id) }}" method="POST">

                @csrf

                <div class="mb-4">
                    <label for="mes" class="block font-medium text-sm text-gray-700">Mês</label>
                    <select name="mes" id="mes" class="mt-1 block w-full border-gray-300 rounded">
                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}">
                                {{ \Carbon\Carbon::create()->month($m)->locale('pt_BR')->translatedFormat('F') }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-4">
                    <label for="ano" class="block font-medium text-sm text-gray-700">Ano</label>
                    <input type="number" name="ano" id="ano" value="{{ now()->year }}"
                        class="mt-1 block w-full border-gray-300 rounded">
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Gerar
                    Relatório PDF</button>
            </form>
        </div>
    </div>
</x-app-layout>

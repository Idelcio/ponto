<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registros de Ponto: {{ $funcionario->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Registros</h3>

            <table class="w-full table-auto text-sm text-left mb-6">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Horário</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $registro)
                        <tr class="border-b">
                            <td class="py-2">{{ $registro->data_formatada }}</td>
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

            {{ $registros->links() }}

            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">← Voltar para o
                    painel</a>
            </div>
        </div>
    </div>
</x-app-layout>

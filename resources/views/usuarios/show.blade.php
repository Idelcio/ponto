<x-app-layout>
    @foreach ($registros as $mes => $dias)
        @php
            $mesFormatado = \Carbon\Carbon::createFromFormat('Y-m', $mes)->format('F/Y');
        @endphp

        <div x-data="{ open: false }" class="mb-12">
            <button @click="open = !open"
                class="w-full flex justify-between items-center px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 transition">
                <h2 class="text-xl font-bold text-gray-800">🗓️ {{ $mesFormatado }}</h2>
                <span x-text="open ? '▲' : '▼'" class="text-sm text-gray-600"></span>
            </button>

            <div x-show="open" x-transition>
                @foreach ($dias as $data => $registrosDoDia)
                    @php
                        $ordenados = $registrosDoDia->sortBy('registrado_em')->values();
                        $totalInterval = \Carbon\CarbonInterval::seconds(0);

                        foreach ($ordenados->chunk(2) as $par) {
                            $entrada = $par[0] ?? null;
                            $saida = $par[1] ?? null;

                            if ($entrada && $saida) {
                                $totalInterval = $totalInterval->add(
                                    $entrada->registrado_em->diffAsCarbonInterval($saida->registrado_em),
                                );
                            }
                        }

                        $totalHoras = $totalInterval->format('%H:%I:%S');
                    @endphp

                    <div class="mb-8 mt-4 bg-white rounded shadow p-6">
                        <h4 class="text-lg font-bold text-gray-700 mb-4">
                            📅 {{ $data }}
                            <span class="ml-4 text-sm text-blue-600 font-normal">🕒 Total trabalhado:
                                {{ $totalHoras }}</span>
                        </h4>

                        <div class="overflow-x-auto">
                            <table class="w-full table-auto text-sm text-left">
                                <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                                    <tr>
                                        <th class="py-2 px-4">Horário</th>
                                        <th class="py-2 px-4">Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ordenados as $registro)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-2 px-4">{{ $registro->data_formatada }}</td>
                                            <td class="py-2 px-4">
                                                <a href="{{ asset('storage/' . $registro->foto) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $registro->foto) }}" alt="Registro"
                                                        class="w-20 h-20 object-cover rounded border border-gray-300 shadow">
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</x-app-layout>

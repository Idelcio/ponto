<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-6 max-w-5xl mx-auto space-y-6">
        @foreach ($registros as $mes => $dias)
            @php
                $mesFormatado = \Carbon\Carbon::createFromFormat('Y-m', $mes)->translatedFormat('F/Y');
            @endphp

            <div x-data="{ open: false }" class="bg-white rounded-lg shadow">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 rounded-t hover:bg-gray-200 transition">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">🗓️ {{ ucfirst($mesFormatado) }}</h2>
                    <span x-text="open ? '▲' : '▼'" class="text-gray-600 text-sm sm:text-base"></span>
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

                        <div class="border-t p-4 sm:p-6">
                            <h4 class="text-base sm:text-lg font-bold text-gray-700 mb-4">
                                📅 {{ $data }}
                                <span class="ml-4 text-sm text-blue-600 font-normal">
                                    🕒 Total trabalhado: {{ $totalHoras }}
                                </span>
                            </h4>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left border border-gray-200">
                                    <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                                        <tr>
                                            <th class="py-2 px-4 border">Horário</th>
                                            <th class="py-2 px-4 border">Foto</th>
                                            <th class="py-2 px-4 border">Localização</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ordenados as $registro)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="py-2 px-4 border">{{ $registro->data_formatada }}</td>
                                                <td class="py-2 px-4 border">
                                                    <a href="{{ asset('storage/' . $registro->foto) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $registro->foto) }}"
                                                            alt="Registro"
                                                            class="w-20 h-20 object-cover rounded border border-gray-300 shadow-sm">
                                                    </a>
                                                </td>
                                                <td class="py-2 px-4 border text-sm">
                                                    @if ($registro->user && $registro->user->latitude && $registro->user->longitude)
                                                        <a href="https://www.google.com/maps?q={{ $registro->user->latitude }},{{ $registro->user->longitude }}"
                                                            target="_blank" class="text-blue-600 hover:underline">
                                                            📍 Ver no mapa
                                                        </a>
                                                        <div class="text-gray-500 text-xs">
                                                            {{ $registro->user->latitude }},
                                                            {{ $registro->user->longitude }}
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400 italic">Não informado</span>
                                                    @endif
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
    </div>
</x-app-layout>

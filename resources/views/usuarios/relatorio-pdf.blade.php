<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Ponto</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-dia {
            font-weight: bold;
            background-color: #e2e2e2;
        }
    </style>
</head>

<body>
    <h1>Relatório de Ponto</h1>

    <p><strong>Funcionário:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Período:</strong> {{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }}</p>
    <p><strong>Gerado em:</strong> {{ $gerado_em }}</p>

    @forelse ($registros as $data => $lista)
        @php
            $ordenados = $lista->sortBy('registrado_em')->values();
            $totalSegundos = 0;
        @endphp

        <h3 style="margin-top: 20px;">📅 {{ $data }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Horas Trabalhadas</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $ordenados->count(); $i += 2)
                    @php
                        $entrada = $ordenados[$i] ?? null;
                        $saida = $ordenados[$i + 1] ?? null;

                        $horas = '-';
                        if ($entrada && $saida) {
                            $intervalo = $entrada->registrado_em->diff($saida->registrado_em);
                            $totalSegundos += $entrada->registrado_em->diffInSeconds($saida->registrado_em);
                            $horas = $intervalo->format('%H:%I:%S');
                        }
                    @endphp
                    <tr>
                        <td>{{ $entrada ? $entrada->registrado_em->format('H:i:s') : '-' }}</td>
                        <td>{{ $saida ? $saida->registrado_em->format('H:i:s') : '-' }}</td>
                        <td>{{ $horas }}</td>
                    </tr>
                @endfor

                @php
                    $totalDia = \Carbon\CarbonInterval::seconds($totalSegundos)->cascade()->format('%H:%I:%S');
                @endphp
                <tr class="total-dia">
                    <td colspan="2">Total do dia</td>
                    <td>{{ $totalDia }}</td>
                </tr>
            </tbody>
        </table>
    @empty
        <p>Nenhum registro encontrado no período.</p>
    @endforelse
</body>

</html>

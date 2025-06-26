<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Grafik Sensor - {{ $device->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #111;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Grafik Sensor - {{ $device->name }}</h2>
    <p><strong>Tanggal:</strong> {{ $start ?? '-' }} s/d {{ $end ?? '-' }}</p>
    <p><strong>Data:</strong>
        {{ implode(', ', collect($types)->map(fn($t) => $sensorLabels[$t] ?? ucfirst($t))->toArray()) }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                @foreach ($types as $type)
                    <th>
                        {{ $sensorLabels[$type] ?? ucfirst($type) }}
                    </th>
                @endforeach
            </tr>
        </thead>        
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($log->recorded_at)->format('Y-m-d H:i:s') }}</td>
                    @foreach ($types as $type)
                        <td>{{ $log->$type }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
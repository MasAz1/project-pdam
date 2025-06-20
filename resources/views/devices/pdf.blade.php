<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PDF Sensor {{ $device->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Data Sensor - {{ $device->name }}</h2>
    <p>Lokasi: {{ $device->location }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Debit</th>
                <th>Baterai</th>
                <th>Kekeruhan</th>
                <th>pH</th>
                <th>Suhu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sensorLogs as $log)
                <tr>
                    <td>{{ $log->recorded_at }}</td>
                    <td>{{ $log->debit }}</td>
                    <td>{{ $log->baterai }}</td>
                    <td>{{ $log->kekeruhan }}</td>
                    <td>{{ $log->ph }}</td>
                    <td>{{ $log->suhu }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

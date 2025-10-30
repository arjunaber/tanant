<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Unit - {{ ucfirst($status) }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .summary {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
        }
        .summary table {
            width: 100%;
        }
        .summary td {
            padding: 5px;
        }
        .summary .label {
            font-weight: bold;
            width: 30%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .status {
            text-align: center;
            font-weight: bold;
        }
        .status.available { color: #28a745; }
        .status.occupied { color: #007bff; }
        .status.maintenance { color: #ffc107; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 50px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN UNIT - {{ strtoupper($status) }}</h1>
        <p>Sistem Manajemen Unit Rental</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td class="label">Status Unit:</td>
                <td>{{ ucfirst($status) }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Unit:</td>
                <td>{{ $units->count() }} unit</td>
            </tr>
        </table>
    </div>

    @if($units->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Nama Unit</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Status</th>
                    <th width="15%">Harga/Hari</th>
                    <th width="35%">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($units as $i => $unit)
                    <tr>
                        <td style="text-align: center;">{{ $i + 1 }}</td>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->categories->pluck('name')->join(', ') }}</td>
                        <td class="status {{ $unit->status }}">
                            {{ ucfirst($unit->status) }}
                        </td>
                        <td style="text-align: right;">Rp {{ number_format($unit->price_per_day, 0, ',', '.') }}</td>
                        <td>{{ $unit->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;">
            <strong>Ringkasan:</strong><br>
            Total Unit: {{ $units->count() }}<br>
            Total Nilai: Rp {{ number_format($units->sum('price_per_day'), 0, ',', '.') }} (harga per hari)
        </div>
    @else
        <div class="no-data">
            Tidak ada unit dengan status {{ $status }}.
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>

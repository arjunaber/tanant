<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - {{ $startDate }} sampai {{ $endDate }}</title>
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
        .status.paid { color: #28a745; }
        .status.pending { color: #ffc107; }
        .status.failed { color: #dc3545; }
        .total {
            text-align: right;
            font-weight: bold;
        }
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
        <h1>LAPORAN PENDAPATAN</h1>
        <p>Sistem Manajemen Unit Rental</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td class="label">Total Pendapatan:</td>
                <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Transaksi:</td>
                <td>{{ $rentals->count() }} transaksi</td>
            </tr>
        </table>
    </div>

    @if($rentals->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode Rental</th>
                    <th width="20%">User</th>
                    <th width="15%">Unit</th>
                    <th width="10%">Tgl Rental</th>
                    <th width="10%">Status Bayar</th>
                    <th width="10%">Denda</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rentals as $i => $rental)
                    <tr>
                        <td style="text-align: center;">{{ $i + 1 }}</td>
                        <td>{{ $rental->rental_code }}</td>
                        <td>{{ $rental->user->name }}</td>
                        <td>{{ $rental->unit->name }}</td>
                        <td>{{ $rental->created_at->format('d/m/Y') }}</td>
                        <td class="status {{ $rental->payment_status }}">
                            {{ ucfirst($rental->payment_status) }}
                        </td>
                        <td style="text-align: right;">{{ $rental->getFormattedLateFee() }}</td>
                        <td class="total">{{ $rental->getFormattedTotalAmount() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;">
            <strong>Ringkasan Total:</strong><br>
            Total Pendapatan: Rp {{ number_format($totalRevenue, 0, ',', '.') }}<br>
            Total Transaksi: {{ $rentals->count() }}
        </div>
    @else
        <div class="no-data">
            Tidak ada data peminjaman pada periode ini.
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>

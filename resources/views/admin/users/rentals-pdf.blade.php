<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - {{ $user->name }}</title>
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
        .user-info {
            margin-bottom: 20px;
        }
        .user-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-info td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .user-info .label {
            font-weight: bold;
            background-color: #f5f5f5;
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
        .status.active { color: #28a745; }
        .status.completed { color: #007bff; }
        .status.overdue { color: #dc3545; }
        .status.cancelled { color: #6c757d; }
        .status.pending { color: #ffc107; }
        .status.paid { color: #28a745; }
        .status.expired { color: #dc3545; }
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
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN RIWAYAT PEMINJAMAN</h1>
        <p>Sistem Manajemen Unit Rental</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>

    <div class="user-info">
        <table>
            <tr>
                <td class="label">Nama Anggota:</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td class="label">Role:</td>
                <td>{{ ucfirst($user->role) }}</td>
            </tr>
            <tr>
                <td class="label">Total Peminjaman:</td>
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
                    <th width="20%">Unit</th>
                    <th width="10%">Tgl Mulai</th>
                    <th width="10%">Tgl Selesai</th>
                    <th width="10%">Status</th>
                    <th width="10%">Pembayaran</th>
                    <th width="10%">Denda</th>
                    <th width="10%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rentals as $i => $rental)
                    <tr>
                        <td style="text-align: center;">{{ $i + 1 }}</td>
                        <td>{{ $rental->rental_code }}</td>
                        <td>{{ $rental->unit->name }}</td>
                        <td>{{ $rental->start_date->format('d/m/Y') }}</td>
                        <td>{{ $rental->end_date->format('d/m/Y') }}</td>
                        <td class="status {{ $rental->status }}">
                            {{ ucfirst($rental->status) }}
                        </td>
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
            <strong>Ringkasan:</strong><br>
            Total Transaksi: {{ $rentals->count() }}<br>
            Total Pemasukan: Rp {{ number_format($rentals->sum(function($rental) { return $rental->getTotalAmount(); }), 0, ',', '.') }}
        </div>
    @else
        <div class="no-data">
            Anggota ini belum memiliki riwayat peminjaman.
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>

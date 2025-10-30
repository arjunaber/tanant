<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Lengkap - {{ $startDate }} sampai {{ $endDate }}</title>
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
        .section {
            margin-bottom: 40px;
        }
        .section h2 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }
        .status {
            text-align: center;
            font-weight: bold;
        }
        .status.available { color: #28a745; }
        .status.occupied { color: #007bff; }
        .status.maintenance { color: #ffc107; }
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
            padding: 30px;
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
        <h1>LAPORAN LENGKAP SISTEM</h1>
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
                <td class="label">Total Unit:</td>
                <td>{{ $allUnits->count() }} (Tersedia: {{ $availableUnits->count() }}, Terisi: {{ $occupiedUnits->count() }}, Maintenance: {{ $maintenanceUnits->count() }})</td>
            </tr>
            <tr>
                <td class="label">Total User:</td>
                <td>{{ $users->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Revenue Section -->
    <div class="section">
        <h2>1. LAPORAN PENDAPATAN</h2>
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
            <div style="margin-top: 10px; padding: 8px; background-color: #f9f9f9; border: 1px solid #ddd;">
                <strong>Total Pendapatan: Rp {{ number_format($totalRevenue, 0, ',', '.') }} ({{ $rentals->count() }} transaksi)</strong>
            </div>
        @else
            <div class="no-data">
                Tidak ada data peminjaman pada periode ini.
            </div>
        @endif
    </div>

    <div class="page-break"></div>

    <!-- Units Section -->
    <div class="section">
        <h2>2. LAPORAN UNIT</h2>
        @if($allUnits->count() > 0)
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
                    @foreach ($allUnits as $i => $unit)
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
            <div style="margin-top: 10px; padding: 8px; background-color: #f9f9f9; border: 1px solid #ddd;">
                <strong>Ringkasan Unit:</strong><br>
                Total: {{ $allUnits->count() }} | Tersedia: {{ $availableUnits->count() }} | Terisi: {{ $occupiedUnits->count() }} | Maintenance: {{ $maintenanceUnits->count() }}
            </div>
        @else
            <div class="no-data">
                Tidak ada data unit.
            </div>
        @endif
    </div>

    <div class="page-break"></div>

    <!-- Users Section -->
    <div class="section">
        <h2>3. LAPORAN USER</h2>
        @if($users->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama</th>
                        <th width="25%">Email</th>
                        <th width="10%">Role</th>
                        <th width="15%">Total Rental</th>
                        <th width="25%">Rental Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $i => $user)
                        <tr>
                            <td style="text-align: center;">{{ $i + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td style="text-align: center;">{{ $user->rentals->count() }}</td>
                            <td>
                                @if($user->rentals->count() > 0)
                                    {{ $user->rentals->first()->created_at->format('d/m/Y') }}<br>
                                    <small>{{ $user->rentals->first()->unit->name }}</small>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 10px; padding: 8px; background-color: #f9f9f9; border: 1px solid #ddd;">
                <strong>Total User: {{ $users->count() }}</strong>
            </div>
        @else
            <div class="no-data">
                Tidak ada data user.
            </div>
        @endif
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>

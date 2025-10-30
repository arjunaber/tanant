@extends('layouts.admin')

@section('title', 'Riwayat Transaksi - ' . $user->name)

@section('content')
    <div class="table-container bg-white p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Riwayat Transaksi - {{ $user->name }}</h2>
            <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-all">
                ← Kembali ke Daftar User
            </a>
        </div>

        @if($rentals->count() > 0)
            <table class="min-w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Kode Rental</th>
                        <th class="p-3 text-left">Unit</th>
                        <th class="p-3 text-left">Tanggal Mulai</th>
                        <th class="p-3 text-left">Tanggal Selesai</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Status Pembayaran</th>
                        <th class="p-3 text-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentals as $i => $rental)
                        <tr class="border-t">
                            <td class="p-3">{{ $i + 1 }}</td>
                            <td class="p-3">{{ $rental->rental_code }}</td>
                            <td class="p-3">{{ $rental->unit->name }}</td>
                            <td class="p-3">{{ $rental->start_date->format('d/m/Y') }}</td>
                            <td class="p-3">{{ $rental->end_date->format('d/m/Y') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    @if($rental->status === 'active') bg-green-100 text-green-800
                                    @elseif($rental->status === 'completed') bg-blue-100 text-blue-800
                                    @elseif($rental->status === 'overdue') bg-red-100 text-red-800
                                    @elseif($rental->status === 'cancelled') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    @if($rental->payment_status === 'paid') bg-green-100 text-green-800
                                    @elseif($rental->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($rental->payment_status === 'expired') bg-red-100 text-red-800
                                    @elseif($rental->payment_status === 'failed') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($rental->payment_status) }}
                                </span>
                            </td>
                            <td class="p-3">{{ $rental->getFormattedTotalAmount() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $rentals->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">User ini belum memiliki riwayat transaksi.</p>
            </div>
        @endif
    </div>
@endsection

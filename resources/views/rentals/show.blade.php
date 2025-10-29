<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('rentals.my-rentals') }}" class="hover:text-blue-600">Peminjaman Saya</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="text-gray-900">{{ $rental->rental_code }}</li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Header -->
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div class="ml-3">
                                <h1 class="text-2xl font-medium text-gray-900">
                                    Detail Peminjaman
                                </h1>
                                <p class="text-gray-500">{{ $rental->rental_code }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($rental->status === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @elseif($rental->status === 'completed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Selesai
                                </span>
                            @elseif($rental->status === 'overdue')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Terlambat
                                </span>
                            @elseif($rental->status === 'cancelled')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Dibatalkan
                                </span>
                            @elseif($rental->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Pembayaran
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    <!-- Rental Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Informasi Peminjaman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <span class="text-sm text-gray-600">Kode Peminjaman:</span>
                                    <p class="font-medium">{{ $rental->rental_code }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Tanggal Dibuat:</span>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($rental->created_at)->format('d F Y, H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Tanggal Mulai:</span>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($rental->start_date)->format('d F Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Tanggal Selesai:</span>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($rental->end_date)->format('d F Y') }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-sm text-gray-600">Total Harga:</span>
                                    <p class="font-medium text-lg text-blue-600">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Status:</span>
                                    <p class="font-medium">
                                        @if($rental->status === 'active')
                                            <span class="text-green-600">Aktif</span>
                                        @elseif($rental->status === 'completed')
                                            <span class="text-blue-600">Selesai</span>
                                        @elseif($rental->status === 'overdue')
                                            <span class="text-red-600">Terlambat</span>
                                        @elseif($rental->status === 'cancelled')
                                            <span class="text-gray-600">Dibatalkan</span>
                                        @elseif($rental->status === 'pending')
                                            <span class="text-yellow-600">Menunggu Pembayaran</span>
                                        @endif
                                    </p>
                                </div>
                                @if($rental->payment_status)
                                <div>
                                    <span class="text-sm text-gray-600">Status Pembayaran:</span>
                                    <p class="font-medium">
                                        @if($rental->payment_status === 'paid')
                                            <span class="text-green-600">Lunas</span>
                                        @elseif($rental->payment_status === 'pending')
                                            <span class="text-yellow-600">Menunggu</span>
                                        @elseif($rental->payment_status === 'failed')
                                            <span class="text-red-600">Gagal</span>
                                        @elseif($rental->payment_status === 'expired')
                                            <span class="text-gray-600">Kadaluarsa</span>
                                        @endif
                                    </p>
                                </div>
                                @endif
                                @if($rental->status === 'overdue')
                                <div>
                                    <span class="text-sm text-gray-600">Denda Terlambat:</span>
                                    <p class="font-medium text-red-600">Rp {{ number_format($rental->late_fee ?? 0, 0, ',', '.') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Unit Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Informasi Ruangan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600">Nama Ruangan:</span>
                                    <p class="font-medium">{{ $rental->unit->name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Kode Ruangan:</span>
                                    <p class="font-medium">{{ $rental->unit->code }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Kapasitas:</span>
                                    <p class="font-medium">{{ $rental->unit->capacity }} orang</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Kategori:</span>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($rental->unit->categories as $category)
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if($rental->unit->description)
                            <div class="mt-4">
                                <span class="text-sm text-gray-600">Deskripsi:</span>
                                <p class="font-medium mt-1">{{ $rental->unit->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Tujuan Peminjaman</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $rental->purpose }}</p>
                        </div>
                    </div>

                    <!-- Payment Information (if pending payment) -->
                    @if($rental->status === 'pending' && $rental->payment_status === 'pending')
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Pembayaran</h3>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-yellow-800">Pembayaran Belum Selesai</p>
                                        <p class="text-sm text-yellow-600">Silakan selesaikan pembayaran untuk mengaktifkan peminjaman.</p>
                                    </div>
                                </div>
                                <a href="{{ route('rentals.payment', $rental->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Bayar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('rentals.my-rentals') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali ke Daftar
                        </a>

                        @if($rental->status === 'active')
                            <a href="{{ route('units.show', $rental->unit->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Lihat Ruangan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

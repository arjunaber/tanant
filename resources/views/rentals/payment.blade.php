<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ url('/units') }}" class="hover:text-blue-600">Ruangan</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </li>
                    <li><a href="{{ route('units.show', $rental->unit->id) }}"
                            class="hover:text-blue-600">{{ $rental->unit->name }}</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </li>
                    <li><a href="{{ route('rentals.create', $rental->unit->id) }}"
                            class="hover:text-blue-600">Peminjaman</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </li>
                    <li class="text-gray-900">Pembayaran</li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h1 class="ml-2 text-2xl font-medium text-gray-900">
                            Pembayaran Peminjaman
                        </h1>
                    </div>

                    <p class="mt-6 text-gray-500 leading-relaxed">
                        Peminjaman ruangan berhasil dibuat. Silakan selesaikan pembayaran untuk mengaktifkan peminjaman
                        Anda.
                    </p>
                </div>

                <div class="bg-white p-6 lg:p-8">
                    <!-- Rental Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Detail Peminjaman</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600">Kode Peminjaman:</span>
                                    <p class="font-medium">{{ $rental->rental_code }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Ruangan:</span>
                                    <p class="font-medium">{{ $rental->unit->name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Tanggal Mulai:</span>
                                    <p class="font-medium">{{ $rental->start_date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Tanggal Selesai:</span>
                                    <p class="font-medium">{{ $rental->end_date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Jumlah Hari:</span>
                                    <p class="font-medium">{{ $rental->getRentalDays() }} hari</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Total Harga:</span>
                                    <p class="font-bold text-lg text-blue-600">{{ $rental->getFormattedTotalPrice() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Status Pembayaran</h3>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-yellow-800">Menunggu Pembayaran</p>
                                    <p class="text-sm text-yellow-600">Silakan selesaikan pembayaran untuk mengaktifkan
                                        peminjaman.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <div class="text-center">
                        <button id="pay-button"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                            Bayar Sekarang
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('rentals.my-rentals') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Lihat Semua Peminjaman
                        </a>

                        <a href="{{ route('rentals.show', $rental->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Lihat Detail Peminjaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('pay-button');

            payButton.addEventListener('click', function() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        window.location.href =
                            '{{ route('payment.success') }}?order_id={{ $rental->transaction_id }}';
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        window.location.href =
                            '{{ route('payment.pending') }}?order_id={{ $rental->transaction_id }}';
                    },
                    onError: function(result) {
                        console.log('Payment error:', result);
                        window.location.href =
                            '{{ route('payment.failed') }}?order_id={{ $rental->transaction_id }}';
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                        // Optional: handle when user closes payment popup
                    }
                });
            });
        });
    </script>
</x-app-layout>

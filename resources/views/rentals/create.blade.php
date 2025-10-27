<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('units.index') }}" class="hover:text-blue-600">Ruangan</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li><a href="{{ route('units.show', $unit->id) }}" class="hover:text-blue-600">{{ $unit->name }}</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="text-gray-900">Peminjaman</li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-8 0h8"></path>
                        </svg>
                        <h1 class="ml-2 text-2xl font-medium text-gray-900">
                            Peminjaman Ruangan
                        </h1>
                    </div>

                    <p class="mt-6 text-gray-500 leading-relaxed">
                        Lengkapi formulir di bawah ini untuk meminjam ruangan <strong>{{ $unit->name }}</strong>.
                        Pastikan tanggal dan tujuan peminjaman sudah benar.
                    </p>
                </div>

                <form method="POST" action="{{ route('rentals.store', $unit->id) }}" class="bg-white p-6 lg:p-8">
                    @csrf

                    <!-- Unit Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Informasi Ruangan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600">Nama Ruangan:</span>
                                    <p class="font-medium">{{ $unit->name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Kode Ruangan:</span>
                                    <p class="font-medium">{{ $unit->code }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Kapasitas:</span>
                                    <p class="font-medium">{{ $unit->capacity }} orang</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Harga per Hari:</span>
                                    <p class="font-medium text-blue-600">Rp {{ number_format($unit->price_per_day, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rental Dates -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Tanggal Peminjaman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                                <x-text-input id="start_date" name="start_date" type="date"
                                              :value="old('start_date')"
                                              class="mt-1 block w-full"
                                              required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                                <x-text-input id="end_date" name="end_date" type="date"
                                              :value="old('end_date')"
                                              class="mt-1 block w-full"
                                              required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            <strong>Catatan:</strong> Maksimal peminjaman adalah 5 hari.
                        </p>
                    </div>

                    <!-- Purpose -->
                    <div class="mb-6">
                        <x-input-label for="purpose" :value="__('Tujuan Peminjaman')" />
                        <textarea id="purpose" name="purpose"
                                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                  rows="4"
                                  placeholder="Jelaskan tujuan peminjaman ruangan ini..."
                                  required>{{ old('purpose') }}</textarea>
                        <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                    </div>

                    <!-- Price Calculation -->
                    <div id="price-calculation" class="mb-6 hidden">
                        <h3 class="text-lg font-semibold mb-4">Perhitungan Harga</h3>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600">Jumlah Hari:</span>
                                    <p id="rental-days" class="font-medium text-blue-600">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Harga per Hari:</span>
                                    <p class="font-medium">Rp {{ number_format($unit->price_per_day, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Total Harga:</span>
                                    <p id="total-price" class="font-bold text-lg text-blue-600">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('units.show', $unit->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                            Batal
                        </a>

                        <x-primary-button>
                            {{ __('Ajukan Peminjaman') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const priceCalculation = document.getElementById('price-calculation');
            const rentalDaysEl = document.getElementById('rental-days');
            const totalPriceEl = document.getElementById('total-price');

            function calculatePrice() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                if (startDate && endDate) {
                    fetch(`{{ route('rentals.calculate-price', $unit->id) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            start_date: startDate,
                            end_date: endDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            priceCalculation.classList.remove('hidden');
                            rentalDaysEl.textContent = data.rental_days + ' hari';
                            totalPriceEl.textContent = data.formatted_total_price;
                        } else {
                            priceCalculation.classList.add('hidden');
                            if (data.errors) {
                                // Handle validation errors if needed
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        priceCalculation.classList.add('hidden');
                    });
                } else {
                    priceCalculation.classList.add('hidden');
                }
            }

            startDateInput.addEventListener('change', calculatePrice);
            endDateInput.addEventListener('change', calculatePrice);
        });
    </script>
</x-app-layout>

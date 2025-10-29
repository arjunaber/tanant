<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ url('/units') }}" class="hover:text-blue-600">Ruangan</a></li>
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
                                <div class="relative mt-1">
                                    <x-text-input id="start_date" name="start_date" type="text"
                                                  :value="old('start_date')"
                                                  class="block w-full date-picker-input font-bold text-gray-900"
                                                  placeholder="Pilih tanggal mulai"
                                                  readonly
                                                  required />
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-8 0h8"></path>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                                <div class="relative mt-1">
                                    <x-text-input id="end_date" name="end_date" type="text"
                                                  :value="old('end_date')"
                                                  class="block w-full date-picker-input font-bold text-gray-900"
                                                  placeholder="Pilih tanggal selesai"
                                                  readonly
                                                  required />
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
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
                                    <p id="rental-days" class="font-bold text-gray-900">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Harga per Hari:</span>
                                    <p class="font-bold text-gray-900">Rp {{ number_format($unit->price_per_day, 0, ',', '.') }}</p>
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

    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <style>
        .flatpickr-input:focus {
            border-color: #6366f1;
            ring-color: rgba(99, 102, 241, 0.2);
        }
        
        .date-picker-input {
            cursor: pointer;
            background-color: white;
        }
        
        .flatpickr-calendar {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .flatpickr-day.selected {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        
        .flatpickr-day:hover {
            background-color: #e5e7eb;
        }

        /* Styling untuk text yang ditampilkan di date picker */
        .flatpickr-input {
            font-weight: 700 !important;
            color: #1f2937 !important;
        }

        /* Display format untuk preview */
        .date-display {
            font-weight: 700;
            color: #1f2937;
        }
    </style>

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date pickers dengan format Y-m-d untuk backend
            const startDatePicker = flatpickr("#start_date", {
                locale: "id",
                dateFormat: "Y-m-d", // Format untuk backend (Carbon compatible)
                altFormat: "j F Y",  // Format untuk display
                altInput: true,      // Gunakan altInput untuk display yang lebih user-friendly
                altInputClass: "font-bold text-gray-900 flatpickr-input",
                minDate: "today",
                disableMobile: true,
                onChange: function(selectedDates, dateStr) {
                    updateEndDateMinDate();
                    calculatePrice();
                }
            });
            
            const endDatePicker = flatpickr("#end_date", {
                locale: "id",
                dateFormat: "Y-m-d", // Format untuk backend (Carbon compatible)
                altFormat: "j F Y",  // Format untuk display
                altInput: true,      // Gunakan altInput untuk display yang lebih user-friendly
                altInputClass: "font-bold text-gray-900 flatpickr-input",
                minDate: "today",
                disableMobile: true,
                onChange: function() {
                    calculatePrice();
                }
            });
            
            function updateEndDateMinDate() {
                const startDate = startDatePicker.selectedDates[0];
                if (startDate) {
                    endDatePicker.set('minDate', startDate);
                    
                    // If end date is before start date, clear it
                    const endDate = endDatePicker.selectedDates[0];
                    if (endDate && endDate < startDate) {
                        endDatePicker.clear();
                    }
                }
            }
            
            const priceCalculation = document.getElementById('price-calculation');
            const rentalDaysEl = document.getElementById('rental-days');
            const totalPriceEl = document.getElementById('total-price');
            
            function calculatePrice() {
                const startDate = startDatePicker.selectedDates[0];
                const endDate = endDatePicker.selectedDates[0];
                
                if (startDate && endDate) {
                    // Calculate days difference
                    const timeDiff = endDate - startDate;
                    const dayDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) + 1;
                    
                    // Validate max rental days (5 days)
                    if (dayDiff > 5) {
                        alert('Maksimal peminjaman adalah 5 hari. Silakan pilih tanggal yang sesuai.');
                        endDatePicker.clear();
                        priceCalculation.classList.add('hidden');
                        return;
                    }
                    
                    // Calculate total price
                    const pricePerDay = {{ $unit->price_per_day }};
                    const totalPrice = dayDiff * pricePerDay;
                    
                    // Format price for display
                    const formattedPrice = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(totalPrice);
                    
                    // Update display
                    priceCalculation.classList.remove('hidden');
                    rentalDaysEl.textContent = dayDiff + ' hari';
                    totalPriceEl.textContent = formattedPrice;
                    
                    // Send to server for validation
                    fetch(`{{ route('rentals.calculate-price', $unit->id) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            start_date: startDatePicker.input.value,
                            end_date: endDatePicker.input.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success && data.errors) {
                            // Handle server-side validation errors
                            if (data.errors.start_date) {
                                alert(data.errors.start_date[0]);
                            }
                            if (data.errors.end_date) {
                                alert(data.errors.end_date[0]);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                } else {
                    priceCalculation.classList.add('hidden');
                }
            }
            
            // Initialize if there are old values
            @if(old('start_date'))
                startDatePicker.setDate('{{ old('start_date') }}');
            @endif
            
            @if(old('end_date'))
                endDatePicker.setDate('{{ old('end_date') }}');
            @endif
            
            // Calculate price on page load if dates exist
            if (startDatePicker.selectedDates.length > 0 && endDatePicker.selectedDates.length > 0) {
                calculatePrice();
            }
        });
    </script>
</x-app-layout>
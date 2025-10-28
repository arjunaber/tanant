<div id="createUnitModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden animate-fade-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">Tambah Unit Baru</h3>
                <p class="text-blue-100 text-sm mt-1">Lengkapi informasi unit yang akan ditambahkan</p>
            </div>
            <button type="button" class="text-white hover:bg-white/20 rounded-lg p-2 transition-all duration-200"
                data-modal-hide="createUnitModal">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form Content -->
        <form action="{{ route('units.store') }}" method="POST" class="overflow-y-auto max-h-[calc(90vh-120px)]">
            @csrf

            <div class="p-6 space-y-5">
                <!-- Nama Unit -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Unit <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                        placeholder="Masukkan nama unit" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id[]" id="category_id" multiple
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none bg-white"
                        required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, old('category_id', [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none resize-none"
                        placeholder="Tambahkan deskripsi unit (opsional)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Harga & Kapasitas (Grid) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price_per_day" class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga per Hari <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="price_per_day" id="price_per_day"
                                value="{{ old('price_per_day') }}" step="0.01" min="0"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                                placeholder="0" required>
                        </div>
                        @error('price_per_day')
                            <p class="text-red-500 text-xs mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kapasitas <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}"
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                                placeholder="Jumlah orang" required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">orang</span>
                        </div>
                        @error('capacity')
                            <p class="text-red-500 text-xs mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Fasilitas -->
                <div>
                    <label for="facilities" class="block text-sm font-semibold text-gray-700 mb-2">
                        Fasilitas
                    </label>
                    <input type="text" name="facilities" id="facilities" value="{{ old('facilities') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                        placeholder="AC, Proyektor, WiFi (pisahkan dengan koma)">
                    <p class="text-gray-500 text-xs mt-2">Pisahkan setiap fasilitas dengan koma</p>
                    @error('facilities')
                        <p class="text-red-500 text-xs mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none bg-white"
                        required>
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia
                        </option>
                        <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Ditempati
                        </option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                            Perawatan</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                <button type="button" data-modal-hide="createUnitModal"
                    class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    💾 Simpan Unit
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Style untuk multiple select */
    select[multiple] {
        min-height: 120px;
        background-image: none;
        padding-right: 1rem;
    }

    select[multiple] option {
        padding: 0.5rem 0.75rem;
        margin: 0.125rem 0;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    select[multiple] option:hover {
        background-color: #f3f4f6;
    }

    select[multiple] option:checked {
        background-color: #3b82f6;
        color: white;
    }

    /* Menghilangkan default arrow pada multiple select */
    select[multiple]::-ms-expand {
        display: none;
    }

    /* Placeholder style untuk multiple select */
    .select-placeholder {
        color: #9ca3af;
    }

    .animate-fade-in {
        animation: fade-in 0.2s ease-out;
    }

    /* Custom scrollbar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openModalBtns = document.querySelectorAll('[data-modal-toggle="createUnitModal"]');
        const closeModalBtns = document.querySelectorAll('[data-modal-hide="createUnitModal"]');
        const modal = document.getElementById('createUnitModal');

        openModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scroll
            });
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scroll
            });
        });

        // Tutup modal jika klik di luar area modal
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
</script>

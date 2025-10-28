<!-- resources/views/admin/units/edit.blade.php -->
<div id="editUnitModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden animate-fade-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-white">Edit Unit</h2>
                <p class="text-emerald-100 text-sm mt-1">Perbarui informasi unit yang dipilih</p>
            </div>
            <button type="button" id="closeEditModal"
                class="text-white hover:bg-white/20 rounded-lg p-2 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form Content -->
        <form id="editUnitForm" method="POST" class="overflow-y-auto max-h-[calc(90vh-120px)]">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-5">
                <!-- Nama Unit -->
                <div>
                    <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Unit <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="edit_name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 outline-none"
                        placeholder="Masukkan nama unit" required>
                </div>

                <!-- Kategori -->
                <div>
                    <label for="edit_category" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="edit_category"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 outline-none bg-white"
                        required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="edit_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" id="edit_description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 outline-none resize-none"
                        placeholder="Tambahkan deskripsi unit (opsional)"></textarea>
                </div>

                <!-- Harga & Kapasitas (Grid) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_price_per_day" class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga per Hari <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="price_per_day" id="edit_price_per_day" step="0.01"
                                min="0"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 outline-none"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div>
                        <label for="edit_capacity" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kapasitas <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="capacity" id="edit_capacity" min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 outline-none"
                                placeholder="Jumlah orang" required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">orang</span>
                        </div>
                    </div>
                </div>

                <!-- Fasilitas -->
                <div>
                    <label for="edit_facilities" class="block text-sm font-semibold text-gray-700 mb-2">
                        Fasilitas
                    </label>
                    <input type="text" name="facilities" id="edit_facilities"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 outline-none"
                        placeholder="AC, Proyektor, WiFi (pisahkan dengan koma)">
                    <p class="text-gray-500 text-xs mt-2">Pisahkan setiap fasilitas dengan koma</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="edit_status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="edit_status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 outline-none bg-white"
                        required>
                        <option value="available">Tersedia</option>
                        <option value="occupied">Ditempati</option>
                        <option value="maintenance">Perawatan</option>
                        <option value="unavailable">Tidak Tersedia</option>
                    </select>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                <button type="button" id="closeEditModalBtn"
                    class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-medium rounded-lg hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    💾 Simpan Perubahan
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

{{-- Script Modal --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('editUnitModal');
        const closeModalButtons = [
            document.getElementById('closeEditModal'),
            document.getElementById('closeEditModalBtn')
        ];
        const form = document.getElementById('editUnitForm');

        // Open modal dengan data dari button
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const name = button.dataset.name;
                const status = button.dataset.status;
                const category = button.dataset.category;
                const description = button.dataset.description || '';
                const pricePerDay = button.dataset.price || '';
                const capacity = button.dataset.capacity || '';
                const facilities = button.dataset.facilities || '';

                // Set form action
                form.action = `/units/${id}`;

                // Populate form fields
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_status').value = status;
                document.getElementById('edit_category').value = category;
                document.getElementById('edit_description').value = description;
                document.getElementById('edit_price_per_day').value = pricePerDay;
                document.getElementById('edit_capacity').value = capacity;
                document.getElementById('edit_facilities').value = facilities;

                // Show modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scroll
            });
        });

        // Close modal handlers
        closeModalButtons.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', () => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scroll
                });
            }
        });

        // Close modal ketika klik di luar
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // Close modal dengan tombol ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
</script>

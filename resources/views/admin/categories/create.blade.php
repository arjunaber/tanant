<!-- Create Category Modal -->
<div id="createCategoryModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden animate-fade-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">Tambah Kategori Baru</h3>
                <p class="text-green-100 text-sm mt-1">Lengkapi informasi kategori yang akan ditambahkan</p>
            </div>
            <button type="button" class="text-white hover:bg-white/20 rounded-lg p-2 transition-all duration-200"
                data-modal-hide="createCategoryModal">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form Content -->
        <form action="{{ route('categories.store') }}" method="POST" class="overflow-y-auto max-h-[calc(90vh-120px)]">
            @csrf

            <div class="p-6 space-y-5">
                <!-- Nama Kategori -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 outline-none"
                        placeholder="Masukkan nama kategori" required>
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

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 outline-none resize-none"
                        placeholder="Tambahkan deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                    <p class="text-gray-500 text-xs mt-2">Deskripsi membantu mengidentifikasi tujuan kategori</p>
                </div>

                <!-- Tips -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-green-800">Tips Kategori yang Baik</h4>
                            <ul class="text-xs text-green-700 mt-1 space-y-1">
                                <li>• Gunakan nama yang jelas dan deskriptif</li>
                                <li>• Kategori akan digunakan untuk mengelompokkan unit</li>
                                <li>• Pastikan nama kategori mudah dipahami</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                <button type="button" data-modal-hide="createCategoryModal"
                    class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Kategori
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

    input:focus,
    textarea:focus {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('createCategoryModal');

        // Open modal (pakai atribut dari tombol)
        document.querySelectorAll('[data-modal-toggle="createCategoryModal"]').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => document.getElementById('name').focus(), 150);
            });
        });

        // Close modal (tombol close atau batal)
        document.querySelectorAll('[data-modal-hide="createCategoryModal"]').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        });

        // Close jika klik di backdrop
        modal.addEventListener('click', e => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // Tutup pakai ESC
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
</script>

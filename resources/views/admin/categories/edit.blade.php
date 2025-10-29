<!-- Edit Category Modal -->
<div id="editCategoryModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden animate-fade-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">Edit Kategori</h3>
                <p class="text-green-100 text-sm mt-1">Perbarui informasi kategori</p>
            </div>
            <button type="button" class="text-white hover:bg-white/20 rounded-lg p-2 transition-all duration-200"
                id="closeEditCategoryModal">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form Content -->
        <form id="editCategoryForm" method="POST" class="overflow-y-auto max-h-[calc(90vh-120px)]">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-5">
                <!-- Nama Kategori -->
                <div>
                    <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="edit_name"
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
                    <label for="edit_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" id="edit_description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 outline-none resize-none"
                        placeholder="Tambahkan deskripsi kategori (opsional)"></textarea>
                    <p class="text-gray-500 text-xs mt-2">Deskripsi membantu mengidentifikasi tujuan kategori</p>
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

                <!-- Informasi Statistik -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800">Informasi Kategori</h4>
                            <p class="text-xs text-blue-700 mt-1" id="categoryStats">
                                Memuat informasi kategori...
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                <button type="button" id="closeEditCategoryModalBtn"
                    class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        const editModal = document.getElementById('editCategoryModal');
        const closeEditModal = document.getElementById('closeEditCategoryModal');
        const closeEditModalBtn = document.getElementById('closeEditCategoryModalBtn');
        const editForm = document.getElementById('editCategoryForm');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const data = this.dataset;
                editForm.action = `/categories/${data.id}`;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_description').value = data.description || '';

                // Update stats information
                const statsElement = document.getElementById('categoryStats');
                if (statsElement) {
                    statsElement.textContent =
                        `Kategori "${data.name}" sedang digunakan oleh beberapa unit.`;
                }

                editModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        });

        if (closeEditModal) {
            closeEditModal.addEventListener('click', () => {
                editModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }

        if (closeEditModalBtn) {
            closeEditModalBtn.addEventListener('click', () => {
                editModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }

        // Tutup modal jika klik di luar area modal
        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) {
                editModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !editModal.classList.contains('hidden')) {
                editModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
</script>

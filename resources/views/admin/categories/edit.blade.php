<!-- Edit Category Modal -->
<div id="editCategoryModal" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
    style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden animate-fade-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">Edit Kategori</h3>
                <p class="text-blue-100 text-sm mt-1">Perbarui informasi kategori yang dipilih</p>
            </div>
            <button type="button" class="text-white hover:bg-white/20 rounded-lg p-2 transition-all duration-200"
                data-modal-hide="editCategoryModal">
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
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none"
                        placeholder="Masukkan nama kategori" required>
                    <p class="text-red-500 text-xs mt-2 hidden" id="edit_name_error"></p>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="edit_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" id="edit_description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none resize-none"
                        placeholder="Tambahkan deskripsi kategori (opsional)"></textarea>
                    <p class="text-gray-500 text-xs mt-2">Deskripsi membantu mengidentifikasi tujuan kategori</p>
                </div>

                <!-- Informasi Tambahan -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800">Tips Edit Kategori</h4>
                            <ul class="text-xs text-blue-700 mt-1 space-y-1">
                                <li>• Pastikan nama kategori tetap konsisten</li>
                                <li>• Perubahan akan mempengaruhi semua unit dalam kategori ini</li>
                                <li>• Update deskripsi untuk kejelasan yang lebih baik</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                <button type="button" data-modal-hide="editCategoryModal"
                    class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>

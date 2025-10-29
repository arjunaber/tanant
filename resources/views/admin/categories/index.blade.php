{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@push('styles')
    <style>
        /* === Search Container === */
        .search-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        /* === Modal Base Styles === */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }

        .modal-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow: hidden;
            transform: translateY(-20px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal-container.active {
            transform: translateY(0);
            opacity: 1;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Kategori</h1>
            <button data-modal-toggle="createCategoryModal"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori Baru
            </button>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Search Bar -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 shadow-lg mb-6">
            <form method="GET" action="{{ route('categories.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                        class="w-full py-3 pl-10 pr-4 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition">Cari</button>
                    @if (request('search'))
                        <a href="{{ route('categories.index') }}"
                            class="bg-white text-gray-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Kategori</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Deskripsi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-semibold">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $category->description ? Str::limit($category->description, 50) : '-' }}
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button
                                        onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description) }}')"
                                        class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded">Edit</button>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">Tidak ada kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.categories.create')
    @include('admin.categories.edit')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editModal = document.getElementById('editCategoryModal');
            const editForm = document.getElementById('editCategoryForm');
            const nameInput = document.getElementById('edit_name');
            const descInput = document.getElementById('edit_description');

            // === Fungsi untuk membuka modal edit ===
            window.openEditModal = function(id, name, description) {
                if (!editModal || !editForm) return;

                editForm.action = `/categories/${id}`;
                nameInput.value = name || '';
                descInput.value = description || '';

                editModal.classList.remove('hidden');
                editModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            };

            // === Klik tombol edit (versi data attribute opsional) ===
            document.addEventListener('click', function(e) {
                const editBtn = e.target.closest('[data-modal-target="editCategoryModal"]');
                if (!editBtn) return;

                const categoryId = editBtn.getAttribute('data-id');
                const categoryName = editBtn.getAttribute('data-name');
                const categoryDesc = editBtn.getAttribute('data-description');

                nameInput.value = categoryName || '';
                descInput.value = categoryDesc || '';
                editForm.action = `/categories/${categoryId}`;

                editModal.classList.remove('hidden');
                editModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // === Tutup modal (klik tombol close atau batal) ===
            document.addEventListener('click', function(e) {
                const closeBtn = e.target.closest('[data-modal-hide="editCategoryModal"]');
                if (!closeBtn) return;

                editModal.classList.add('hidden');
                editModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            // === Tutup modal jika klik di luar area modal ===
            editModal.addEventListener('click', function(e) {
                if (e.target === editModal) {
                    editModal.classList.add('hidden');
                    editModal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });

            // === AJAX Update Kategori ===
            if (editForm) {
                editForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const action = this.action;

                    try {
                        const response = await fetch(action, {
                            method: 'POST', // karena pakai @method('PUT') di form
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        if (!response.ok) throw await response.json();

                        // Tutup modal
                        editModal.classList.add('hidden');
                        editModal.style.display = 'none';
                        document.body.style.overflow = '';

                        // Notifikasi sukses
                        alert('Kategori berhasil diperbarui!');

                        // Refresh halaman untuk memuat data terbaru
                        location.reload();

                    } catch (error) {
                        console.error(error);
                        if (error.errors && error.errors.name) {
                            const nameError = document.getElementById('edit_name_error');
                            nameError.textContent = error.errors.name[0];
                            nameError.classList.remove('hidden');
                        } else {
                            alert('Gagal memperbarui kategori.');
                        }
                    }
                });
            }
        });
    </script>
@endpush

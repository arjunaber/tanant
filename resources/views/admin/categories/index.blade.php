{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@push('styles')
    <style>
        /* Search Container */
        .search-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .search-label {
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            gap: 0.75rem;
        }

        .search-input-group {
            flex: 1;
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid transparent;
            border-radius: 0.75rem;
            font-size: 0.9375rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .btn-search {
            padding: 0.875rem 2rem;
            background: white;
            color: #667eea;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .btn-search:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-reset {
            padding: 0.875rem 2rem;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            backdrop-filter: blur(10px);
        }

        .btn-reset:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow: hidden;
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal-container.active {
            transform: scale(1);
            opacity: 1;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            color: white;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .modal-body {
            padding: 1.5rem;
            max-height: calc(90vh - 120px);
            overflow-y: auto;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: white;
            color: #475569;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slideIn {
            animation: slideIn 0.3s ease-out;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Kategori</h1>
            <button onclick="openCreateModal()"
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

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong class="font-semibold">Error:</strong>
                <ul class="mt-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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

        <!-- Table Card -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Daftar Kategori</h2>
                        <p class="text-sm text-gray-600 mt-1">Kelola semua kategori yang tersedia dalam sistem</p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <span class="text-sm text-gray-600">
                            Total: <strong class="text-blue-600">{{ $categories->total() }}</strong> kategori
                        </span>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Deskripsi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Jumlah Unit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tanggal Dibuat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $category->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-xs">
                                        {{ $category->description ? Str::limit($category->description, 50) : '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $category->units_count }} unit
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div>{{ $category->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $category->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <button
                                            onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')"
                                            class="edit-btn inline-flex items-center justify-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded transition-all duration-200 min-h-[32px]">
                                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Edit
                                        </button>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            class="inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded transition-all duration-200 min-h-[32px]"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada data kategori</p>
                                    @if (request('search'))
                                        <p class="text-sm mt-2">Hasil pencarian untuk
                                            "<strong>{{ request('search') }}</strong>" tidak ditemukan</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="flex flex-col sm:flex-row justify-between items-center bg-gray-50 p-4 rounded-lg shadow mt-4 gap-2">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-semibold text-indigo-600">{{ $categories->firstItem() ?? 0 }}</span> -
                    <span class="font-semibold text-indigo-600">{{ $categories->lastItem() ?? 0 }}</span> dari
                    <span class="font-semibold text-indigo-600">{{ $categories->total() }}</span> kategori
                </div>
                <div class="flex flex-wrap gap-2">
                    @if ($categories->onFirstPage())
                        <span class="px-3 py-1 rounded bg-gray-200 text-gray-400 cursor-not-allowed">‹</span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}"
                            class="px-3 py-1 rounded bg-white border border-gray-300 hover:bg-indigo-600 hover:text-white transition">‹</a>
                    @endif

                    @for ($i = 1; $i <= $categories->lastPage(); $i++)
                        @if ($i == $categories->currentPage())
                            <span class="px-3 py-1 rounded bg-indigo-600 text-white">{{ $i }}</span>
                        @else
                            <a href="{{ $categories->appends(request()->query())->url($i) }}"
                                class="px-3 py-1 rounded bg-white border border-gray-300 hover:bg-indigo-600 hover:text-white transition">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}"
                            class="px-3 py-1 rounded bg-white border border-gray-300 hover:bg-indigo-600 hover:text-white transition">›</a>
                    @else
                        <span class="px-3 py-1 rounded bg-gray-200 text-gray-400 cursor-not-allowed">›</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create Category Modal -->
    <div id="createCategoryModal" class="modal-overlay">
        <div class="modal-container animate-slideIn">
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h3 class="modal-title">Tambah Kategori Baru</h3>
                    <button type="button" class="modal-close" onclick="closeCreateModal()">
                        &times;
                    </button>
                </div>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Kategori <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="form-input"
                            placeholder="Masukkan nama kategori" required value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-input form-textarea"
                            placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="modal-overlay">
        <div class="modal-container animate-slideIn">
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h3 class="modal-title">Edit Kategori</h3>
                    <button type="button" class="modal-close" onclick="closeEditModal()">
                        &times;
                    </button>
                </div>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name" class="form-label">Nama Kategori <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-input"
                            placeholder="Masukkan nama kategori" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="edit_description" class="form-input form-textarea"
                            placeholder="Masukkan deskripsi kategori (opsional)"></textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Kategori</button>
                </div>
            </form>
        </div>
    </div>
@endsection

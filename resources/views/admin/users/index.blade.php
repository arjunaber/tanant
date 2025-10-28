{{-- resources/views/admin/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

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

        /* Pagination Modern */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: linear-gradient(to right, #f8fafc, #f1f5f9);
            border-top: 1px solid #e2e8f0;
        }

        .pagination-info {
            font-size: 0.9375rem;
            color: #475569;
            font-weight: 500;
        }

        .pagination-info strong {
            color: #667eea;
            font-weight: 700;
        }

        .pagination-links {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .pagination-link {
            min-width: 2.5rem;
            height: 2.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            color: #475569;
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 600;
            transition: all 0.2s ease;
            background: white;
        }

        .pagination-link:hover:not(.disabled):not(.active) {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }

        .pagination-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            transform: translateY(-1px);
        }

        .pagination-link.disabled {
            color: #cbd5e1;
            cursor: not-allowed;
            background: #f8fafc;
            border-color: #e2e8f0;
        }

        .pagination-link.disabled:hover {
            transform: none;
        }

        .pagination-ellipsis {
            padding: 0 0.5rem;
            color: #94a3b8;
            font-weight: 600;
        }

        /* Arrow buttons */
        .pagination-link.arrow {
            font-size: 1.125rem;
        }

        /* Table Container */
        .table-container {
            overflow-x: auto;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .search-container {
                padding: 1.5rem;
            }

            .search-wrapper {
                flex-direction: column;
            }

            .btn-search,
            .btn-reset {
                width: 100%;
            }

            .pagination-container {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .pagination-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .pagination-link {
                min-width: 2.25rem;
                height: 2.25rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 768px) {
            .search-input {
                font-size: 1rem;
                /* Prevent zoom on iOS */
            }
        }
    </style>
@endpush
@vite('resources/css/app.css')
@stack('styles')

@section('content')
    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <button data-modal-target="createUnitModal" data-modal-toggle="createUnitModal"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Unit Baru
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

        <!-- Search Bar Modern -->
        <div class="search-container">
            <form method="GET" action="{{ route('admin.index') }}">
                <label class="search-label">Cari Unit Berdasarkan Nama</label>
                <div class="search-wrapper">
                    <div class="search-input-group">
                        <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Ketik nama unit yang ingin dicari..." class="search-input" autocomplete="off">
                    </div>
                    <button type="submit" class="btn-search">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </span>
                    </button>
                    @if (request('search'))
                        <a href="{{ route('admin.index') }}" class="btn-reset">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset
                            </span>
                        </a>
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
                        <h2 class="text-lg font-semibold text-gray-800">Daftar Unit</h2>
                        <p class="text-sm text-gray-600 mt-1">Kelola semua unit yang tersedia dalam sistem</p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <span class="text-sm text-gray-600">
                            Total: <strong class="text-blue-600">{{ $units->total() }}</strong> unit
                        </span>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="w-full min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama Unit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Harga</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kapasitas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tanggal Dibuat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($units as $unit)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ ($units->currentPage() - 1) * $units->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $unit->name }}</div>
                                    @if ($unit->description)
                                        <div class="text-sm text-gray-500 mt-1 max-w-xs">
                                            {{ Str::limit($unit->description, 50) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($unit->categories as $category)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($unit->price_per_day)
                                        <div class="text-sm font-semibold text-green-600">
                                            Rp {{ number_format($unit->price_per_day, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-500">/hari</div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($unit->capacity)
                                        <div class="flex items-center text-sm text-gray-700">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            {{ $unit->capacity }} orang
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($unit->status === 'available')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Tersedia
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Tidak Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div>{{ $unit->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $unit->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <button
                                            class="edit-btn inline-flex items-center justify-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded transition-all duration-200 min-h-[32px]"
                                            data-id="{{ $unit->id }}" data-name="{{ $unit->name }}"
                                            data-status="{{ $unit->status }}"
                                            data-category="{{ $unit->categories->pluck('id')->implode(',') }}"
                                            data-description="{{ $unit->description }}"
                                            data-price="{{ $unit->price_per_day }}"
                                            data-capacity="{{ $unit->capacity }}"
                                            data-facilities="{{ $unit->facilities }}">
                                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Edit
                                        </button>

                                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST"
                                            class="inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded transition-all duration-200 min-h-[32px]"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus unit ini?')">
                                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
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
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada data unit</p>
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

            <!-- Pagination Modern -->
            @if ($units->hasPages())
                <div class="pagination-container">
                    <div class="pagination-info">
                        Menampilkan <strong>{{ $units->firstItem() ?? 0 }}</strong> -
                        <strong>{{ $units->lastItem() ?? 0 }}</strong> dari <strong>{{ $units->total() }}</strong> unit
                    </div>
                    <div class="pagination-links">
                        {{-- Previous Button --}}
                        @if ($units->onFirstPage())
                            <span class="pagination-link disabled arrow">‹</span>
                        @else
                            <a href="{{ $units->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-link arrow">‹</a>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max($units->currentPage() - 2, 1);
                            $end = min($start + 4, $units->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        @if ($start > 1)
                            <a href="{{ $units->appends(request()->query())->url(1) }}" class="pagination-link">1</a>
                            @if ($start > 2)
                                <span class="pagination-ellipsis">⋯</span>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            @if ($i == $units->currentPage())
                                <span class="pagination-link active">{{ $i }}</span>
                            @else
                                <a href="{{ $units->appends(request()->query())->url($i) }}"
                                    class="pagination-link">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($end < $units->lastPage())
                            @if ($end < $units->lastPage() - 1)
                                <span class="pagination-ellipsis">⋯</span>
                            @endif
                            <a href="{{ $units->appends(request()->query())->url($units->lastPage()) }}"
                                class="pagination-link">{{ $units->lastPage() }}</a>
                        @endif

                        {{-- Next Button --}}
                        @if ($units->hasMorePages())
                            <a href="{{ $units->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-link arrow">›</a>
                        @else
                            <span class="pagination-link disabled arrow">›</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('admin.units.create')
    @include('admin.units.edit')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal handlers
            const editButtons = document.querySelectorAll('.edit-btn');
            const editModal = document.getElementById('editUnitModal');
            const closeEditModal = document.getElementById('closeEditModal');
            const editForm = document.getElementById('editUnitForm');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const data = this.dataset;
                    editForm.action = `/units/${data.id}`;
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_status').value = data.status;
                    document.getElementById('edit_category').value = data.category;
                    document.getElementById('edit_description').value = data.description || '';
                    document.getElementById('edit_price_per_day').value = data.price || '';
                    document.getElementById('edit_capacity').value = data.capacity || '';
                    document.getElementById('edit_facilities').value = data.facilities || '';
                    editModal.classList.remove('hidden');
                });
            });

            if (closeEditModal) {
                closeEditModal.addEventListener('click', () => editModal.classList.add('hidden'));
            }

            if (editModal) {
                editModal.addEventListener('click', (e) => {
                    if (e.target === editModal) editModal.classList.add('hidden');
                });
            }

            // Create modal
            document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = document.getElementById(btn.dataset.modalTarget);
                    if (target) target.classList.remove('hidden');
                });
            });

            document.querySelectorAll('[data-modal-hide]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.closest('[id$="Modal"]');
                    if (target) target.classList.add('hidden');
                });
            });
        });
    </script>
@endpush

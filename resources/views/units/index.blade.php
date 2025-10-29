@extends('layouts.app')

@section('title', 'Daftar Ruangan - Tenant Ruangan')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Daftar Ruangan</h1>
            <p class="text-gray-600 mt-2">Temukan ruangan perfect untuk kebutuhan Anda</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form action="{{ route('units.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Ruangan</label>
                    <input type="text" name="search" id="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari berdasarkan nama atau kode ruangan..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Category Filter -->
                <div class="flex-1">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->units_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="flex-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Ditempati</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                    </select>
                </div>

                <!-- Sort Options -->
                <div class="flex-1">
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                    <select name="sort" id="sort" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="capacity" {{ request('sort') == 'capacity' ? 'selected' : '' }}>Kapasitas Terkecil</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Terapkan
                    </button>
                   <a href="{{ url('/units') }}" 
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-gray-600">
                Menampilkan <span class="font-semibold">{{ $units->total() }}</span> ruangan
                @if(request('status'))
                    dengan status <span class="font-semibold text-blue-600">
                        @if(request('status') == 'available') Tersedia
                        @elseif(request('status') == 'occupied') Ditempati
                        @elseif(request('status') == 'maintenance') Perawatan
                        @endif
                    </span>
                @endif
            </p>
        </div>

        <!-- Units Grid -->
        @if($units->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($units as $unit)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Unit Image Placeholder -->
                        <div class="bg-gray-200 h-48 flex items-center justify-center relative">
                            <span class="text-gray-500 text-sm">Gambar Ruangan</span>
                            <!-- Status Badge Overlay -->
                            <div class="absolute top-2 right-2">
                                @if($unit->isAvailable())
                                    <span class="text-xs font-medium text-green-800 bg-green-100 px-2 py-1 rounded">
                                        Tersedia
                                    </span>
                                @elseif($unit->isOccupied())
                                    <span class="text-xs font-medium text-red-800 bg-red-100 px-2 py-1 rounded">
                                        Ditempati
                                    </span>
                                @elseif($unit->isUnderMaintenance())
                                    <span class="text-xs font-medium text-yellow-800 bg-yellow-100 px-2 py-1 rounded">
                                        Perawatan
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <!-- Unit Code -->
                            <div class="mb-2">
                                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                    {{ $unit->code }}
                                </span>
                            </div>

                            <!-- Unit Name -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $unit->name }}</h3>

                            <!-- Categories -->
                            <div class="mb-3">
                                @foreach($unit->categories->take(2) as $category)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                                @if($unit->categories->count() > 2)
                                    <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                        +{{ $unit->categories->count() - 2 }} lainnya
                                    </span>
                                @endif
                            </div>

                            <!-- Facilities Preview -->
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                {{ Str::limit($unit->description, 80) }}
                            </p>

                            <!-- Capacity and Price -->
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    {{ $unit->capacity }} orang
                                </div>
                                <div class="text-lg font-bold text-blue-600">
                                    {{ $unit->getFormattedPrice() }}/hari
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('units.show', $unit->id) }}" 
                                   class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                                    Lihat Detail
                                </a>
                                
                                @if($unit->isAvailable())
                                    @if(auth()->check() && auth()->user()->canRentAnotherUnit())
                                        <a href="{{ route('rentals.create', $unit->id) }}" 
                                           class="flex-1 bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition duration-200">
                                            Sewa
                                        </a>
                                    @else
                                        <button disabled 
                                                class="flex-1 bg-gray-400 text-white text-center py-2 px-4 rounded-md cursor-not-allowed"
                                                title="{{ !auth()->check() ? 'Login untuk menyewa' : 'Maksimal 2 peminjaman aktif' }}">
                                            Sewa
                                        </button>
                                    @endif
                                @else
                                    <button disabled 
                                            class="flex-1 bg-gray-400 text-white text-center py-2 px-4 rounded-md cursor-not-allowed"
                                            title="{{ $unit->isOccupied() ? 'Sedang ditempati' : 'Sedang dalam perawatan' }}">
                                        Sewa
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $units->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada ruangan ditemukan</h3>
                <p class="text-gray-600 mb-4">
                    @if(request('search') || request('category_id') || request('status'))
                        Coba ubah kriteria pencarian atau filter Anda
                    @else
                        Belum ada ruangan yang terdaftar dalam sistem
                    @endif
                </p>
                <div class="flex justify-center space-x-4">
                   <a href="{{ url('/units') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Tampilkan Semua Ruangan
                    </a>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="#" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Tambah Ruangan Baru
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- AJAX Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchResults = document.createElement('div');
    searchResults.className = 'absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 shadow-lg hidden';
    searchInput.parentNode.appendChild(searchResults);

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value;
        
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        fetch(`{{ route('units.search.ajax') }}?search=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(units => {
                if (units.length > 0) {
                    searchResults.innerHTML = units.map(unit => `
                        <a href="/units/${unit.id}" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200 last:border-b-0">
                            <div class="font-medium">${unit.name}</div>
                            <div class="text-sm text-gray-600">${unit.code} - ${unit.price_per_day}</div>
                        </a>
                    `).join('');
                    searchResults.classList.remove('hidden');
                } else {
                    searchResults.innerHTML = '<div class="px-4 py-2 text-gray-500">Tidak ada hasil ditemukan</div>';
                    searchResults.classList.remove('hidden');
                }
            });
    });

    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
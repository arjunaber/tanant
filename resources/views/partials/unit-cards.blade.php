@isset($units)
    @foreach($units as $unit)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <!-- Unit Image Placeholder -->
        <div class="bg-gray-200 h-48 flex items-center justify-center relative">
            <span class="text-gray-500 text-sm">Gambar Ruangan</span>
            
            <!-- Status Badge -->
            <div class="absolute top-2 right-2">
                @if($unit->isAvailable())
                    <span class="text-xs font-medium text-green-800 bg-green-100 px-2 py-1 rounded border border-green-200">
                        Tersedia
                    </span>
                @elseif($unit->isOccupied())
                    <span class="text-xs font-medium text-red-800 bg-red-100 px-2 py-1 rounded border border-red-200">
                        Ditempati
                    </span>
                @elseif($unit->isUnderMaintenance())
                    <span class="text-xs font-medium text-yellow-800 bg-yellow-100 px-2 py-1 rounded border border-yellow-200">
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

            <!-- Description -->
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
@endisset

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
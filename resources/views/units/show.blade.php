@extends('layouts.app')

@section('title', $unit->name . ' - Tenant Ruangan')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('units.index') }}" class="hover:text-blue-600">Ruangan</a></li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li class="text-gray-900">{{ $unit->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Images and Details -->
            <div>
                <!-- Main Image -->
                <div class="bg-gray-200 rounded-lg h-80 flex items-center justify-center mb-4">
                    <span class="text-gray-500">Gambar Ruangan {{ $unit->name }}</span>
                </div>

                <!-- Additional Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Informasi Ruangan</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-gray-600">Kode Ruangan</span>
                            <p class="font-medium">{{ $unit->code }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Status</span>
                            <p class="font-medium text-green-600">Tersedia</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Kapasitas</span>
                            <p class="font-medium">{{ $unit->capacity }} orang</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Harga per Hari</span>
                            <p class="font-medium text-blue-600">{{ $unit->getFormattedPrice() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Description and Actions -->
            <div>
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $unit->name }}</h1>
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($unit->categories as $category)
                                    <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-blue-600">{{ $unit->getFormattedPrice() }}</div>
                            <div class="text-sm text-gray-600">per hari</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Deskripsi</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $unit->description }}</p>
                    </div>

                    <!-- Facilities -->
                    @if($unit->facilities)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Fasilitas</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($unit->getFacilitiesArray() as $facility)
                                <div class="flex items-center text-sm text-gray-700">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ trim($facility) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        @if($canRent)
                            <a href="{{ route('rentals.create', $unit->id) }}" 
                               class="flex-1 bg-green-600 text-white text-center py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition duration-200">
                                Sewa Sekarang
                            </a>
                        @else
                            <button disabled 
                                    class="flex-1 bg-gray-400 text-white text-center py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                                @if(!auth()->check())
                                    Login untuk Menyewa
                                @elseif(!$unit->isAvailable())
                                    Sedang Tidak Tersedia
                                @else
                                    Maksimal 2 Peminjaman Aktif
                                @endif
                            </button>
                        @endif
                        <a href="{{ route('units.index') }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Related Units -->
                @if(isset($relatedUnits) && $relatedUnits->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Ruangan Serupa</h3>
                    <div class="space-y-4">
                        @foreach($relatedUnits as $relatedUnit)
                        <a href="{{ route('units.show', $relatedUnit->id) }}" 
                           class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="bg-gray-200 w-16 h-16 rounded flex items-center justify-center mr-4">
                                <span class="text-xs text-gray-500">Gambar</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $relatedUnit->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $relatedUnit->getFormattedPrice() }}/hari</p>
                            </div>
                            <div class="text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
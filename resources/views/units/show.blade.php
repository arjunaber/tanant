<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $unit->name }} - Tenant Ruangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <!-- Simple Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ url('/units') }}" class="text-xl font-bold text-blue-600">TenantRuangan</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/units') }}" class="text-gray-700 hover:text-blue-600">Ruangan</a>
                        <a href="{{ route('profile.show') }}" class="text-gray-700 hover:text-blue-600">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ url('/units') }}" class="hover:text-blue-600">Ruangan</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </li>
                    <li class="text-gray-900">{{ $unit->name }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div>
                    <!-- Main Image -->
                    <div class="bg-gray-200 rounded-lg h-80 flex items-center justify-center mb-4 relative">
                        <span class="text-gray-500">Gambar Ruangan</span>

                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            @if ($unit->status === 'available')
                                <span class="text-sm font-medium text-green-800 bg-green-100 px-3 py-1 rounded-full">
                                    Tersedia
                                </span>
                            @elseif($unit->status === 'occupied')
                                <span class="text-sm font-medium text-red-800 bg-red-100 px-3 py-1 rounded-full">
                                    Ditempati
                                </span>
                            @else
                                <span class="text-sm font-medium text-yellow-800 bg-yellow-100 px-3 py-1 rounded-full">
                                    Perawatan
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Informasi Ruangan</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-600">Kode Ruangan:</span>
                                <p class="font-medium">{{ $unit->code }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Status:</span>
                                <p
                                    class="font-medium 
                                    @if ($unit->status === 'available') text-green-600
                                    @elseif($unit->status === 'occupied') text-red-600
                                    @else text-yellow-600 @endif">
                                    @if ($unit->status === 'available')
                                        Tersedia
                                    @elseif($unit->status === 'occupied')
                                        Ditempati
                                    @else
                                        Perawatan
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Kapasitas:</span>
                                <p class="font-medium">{{ $unit->capacity }} orang</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Harga per Hari:</span>
                                <p class="font-medium text-blue-600">Rp
                                    {{ number_format($unit->price_per_day, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <!-- Header -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $unit->name }}</h1>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach ($unit->categories as $category)
                                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-blue-600">Rp
                                    {{ number_format($unit->price_per_day, 0, ',', '.') }}</div>
                                <div class="text-sm text-gray-600">per hari</div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">Deskripsi</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $unit->description }}</p>
                        </div>

                        <!-- Facilities -->
                        @if ($unit->facilities)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-3">Fasilitas</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @php
                                        $facilities = array_filter(array_map('trim', explode(',', $unit->facilities)));
                                    @endphp
                                    @foreach ($facilities as $facility)
                                        <div class="flex items-center text-sm text-gray-700">
                                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>{{ $facility }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex space-x-4">
                            @if ($canRent)
                                <a href="{{ route('rentals.create', $unit->id) }}"
                                    class="flex-1 bg-green-600 text-white text-center py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition duration-200">
                                    Sewa Sekarang
                                </a>
                            @else
                                <button disabled
                                    class="flex-1 bg-gray-400 text-white text-center py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                                    @if (!auth()->check())
                                        Login untuk Menyewa
                                    @elseif($unit->status !== 'available')
                                        @if ($unit->status === 'occupied')
                                            Sedang Ditempati
                                        @else
                                            Sedang Perawatan
                                        @endif
                                    @else
                                        Maksimal 2 Peminjaman Aktif
                                    @endif
                                </button>
                            @endif
                            <a href="{{ url('/units') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Related Units -->
                    @if ($relatedUnits->count() > 0)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold mb-4">Ruangan Serupa</h3>
                            <div class="space-y-4">
                                @foreach ($relatedUnits as $relatedUnit)
                                    <a href="{{ route('units.show', $relatedUnit->id) }}"
                                        class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                        <div
                                            class="bg-gray-200 w-16 h-16 rounded flex items-center justify-center mr-4 flex-shrink-0">
                                            <span class="text-xs text-gray-500">Gambar</span>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $relatedUnit->name }}</h4>
                                            <p class="text-sm text-gray-600">Rp
                                                {{ number_format($relatedUnit->price_per_day, 0, ',', '.') }}/hari</p>
                                            <span
                                                class="text-xs 
                                        @if ($relatedUnit->status === 'available') text-green-600
                                        @elseif($relatedUnit->status === 'occupied') text-red-600
                                        @else text-yellow-600 @endif">
                                                @if ($relatedUnit->status === 'available')
                                                    Tersedia
                                                @elseif($relatedUnit->status === 'occupied')
                                                    Ditempati
                                                @else
                                                    Perawatan
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-blue-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
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
</body>

</html>

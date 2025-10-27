<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Ruangan - Sewa Ruangan Mudah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-blue-600">TenantRuangan</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('units.index') }}" class="text-gray-700 hover:text-blue-600">Daftar Ruangan</a>
                        <a href="{{ route('rentals.my-rentals') }}" class="text-gray-700 hover:text-blue-600">Peminjaman Saya</a>
                        <a href="{{ route('profile.show') }}" class="text-gray-700 hover:text-blue-600">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Sewa Ruangan Mudah & Cepat</h1>
            <p class="text-xl mb-8">Temukan ruangan perfect untuk meeting, event, atau workspace Anda</p>
            <a href="{{ route('units.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition duration-300">
                Lihat Daftar Ruangan
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Mengapa Memilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Terpercaya</h3>
                    <p class="text-gray-600">Sistem booking yang aman dan terpercaya</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Customer service siap membantu kapan saja</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-600">Berbagai pilihan ruangan dengan harga kompetitif</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Rooms Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Ruangan Populer</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredUnits as $unit)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <span class="text-gray-500">Gambar Ruangan</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $unit->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $unit->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-600 font-bold">{{ $unit->getFormattedPrice() }}/hari</span>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Tersedia</span>
                        </div>
                        <a href="{{ route('units.show', $unit->id) }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded mt-4 hover:bg-blue-700">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('units.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Lihat Semua Ruangan
                </a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Kategori Ruangan</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($categories as $category)
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:bg-blue-50 transition duration-300">
                    <h3 class="font-semibold mb-2">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $category->getAvailableUnitsCount() }} ruangan tersedia</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 TenantRuangan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
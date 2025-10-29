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
                        <a href="{{ url('/units') }}" class="text-gray-700 hover:text-blue-600">Daftar Ruangan</a>
                        <a href="{{ route('rentals.my-rentals') }}" class="text-gray-700 hover:text-blue-600">Peminjaman
                            Saya</a>
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

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Sewa Ruangan Mudah & Cepat</h1>
            <p class="text-xl mb-8">Temukan ruangan perfect untuk meeting, event, atau workspace Anda</p>
            <a href="{{ url('/units') }}"
                class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition duration-300">
                Lihat Daftar Ruangan
            </a>
        </div>
    </section>

    <!-- All Rooms Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Semua Ruangan</h2>

            <!-- Status Legend -->
            <div class="flex justify-center mb-8">
                <div class="bg-white rounded-lg shadow-sm p-4 flex space-x-6">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Tersedia</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Ditempati</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Perawatan</span>
                    </div>
                </div>
            </div>

            <!-- Units Grid -->
            <div id="units-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @include('partials.unit-cards')
            </div>

            <!-- Load More Button -->
            @if ($units->hasMorePages())
                <div class="text-center">
                    <button id="load-more-btn" data-next-page="{{ $units->nextPageUrl() }}"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Load More Ruangan
                    </button>
                    <div id="loading-spinner" class="hidden mt-4">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <span class="ml-2 text-gray-600">Memuat...</span>
                    </div>
                </div>
            @else
                @if ($units->count() > 0)
                    <div class="text-center mt-8">
                        <p class="text-gray-600">Semua ruangan telah ditampilkan</p>
                    </div>
                @endif
            @endif

            <!-- No Units Message -->
            @if ($units->count() == 0)
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada ruangan tersedia</h3>
                    <p class="text-gray-600 mb-4">Silakan hubungi administrator untuk informasi lebih lanjut</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Kategori Ruangan</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    <div class="bg-gray-50 rounded-lg p-6 text-center hover:bg-blue-50 transition duration-300">
                        <h3 class="font-semibold mb-2">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $category->units_count }} ruangan tersedia</p>
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

    <!-- Load More Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreBtn = document.getElementById('load-more-btn');
            const unitsContainer = document.getElementById('units-container');
            const loadingSpinner = document.getElementById('loading-spinner');

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const nextPageUrl = this.getAttribute('data-next-page');

                    if (!nextPageUrl) return;

                    // Show loading
                    this.style.display = 'none';
                    if (loadingSpinner) {
                        loadingSpinner.classList.remove('hidden');
                    }

                    // Fetch next page
                    fetch(nextPageUrl + '&ajax=1', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Append new units
                            if (data.html) {
                                unitsContainer.insertAdjacentHTML('beforeend', data.html);
                            }

                            // Update load more button
                            if (data.hasMore && data.nextPage) {
                                this.setAttribute('data-next-page', data.nextPage);
                                this.style.display = 'inline-block';
                            } else {
                                this.remove();
                                // Show "all loaded" message
                                const allLoadedMsg = document.createElement('div');
                                allLoadedMsg.className = 'text-center mt-8';
                                allLoadedMsg.innerHTML =
                                    '<p class="text-gray-600">Semua ruangan telah ditampilkan</p>';
                                this.parentNode.appendChild(allLoadedMsg);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading more units:', error);
                            // Show error message
                            const errorMsg = document.createElement('div');
                            errorMsg.className = 'text-center mt-4 text-red-600';
                            errorMsg.textContent = 'Gagal memuat data. Silakan coba lagi.';
                            this.parentNode.appendChild(errorMsg);
                        })
                        .finally(() => {
                            // Hide loading
                            if (loadingSpinner) {
                                loadingSpinner.classList.add('hidden');
                            }
                        });
                });
            }
        });
    </script>

    <style>
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</body>

</html>

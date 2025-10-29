<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
                                TenantRuangan
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                           <a href="{{ url('/units') }}" class="text-gray-700 hover:text-blue-600">Ruangan</a>
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

        <!-- Page Content -->
        <main>
            @if (session('success'))
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{ $slot ?? '' }}
        </main>
    </div>
    @stack('scripts')
</body>

</html>

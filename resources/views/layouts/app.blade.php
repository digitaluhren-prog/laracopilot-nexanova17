<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Platforma Shqiptare')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Menu Toggle -->
    <div id="mobile-menu" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40" onclick="toggleMobileMenu()">
        <div class="bg-white w-64 h-full p-6" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <span class="text-xl font-bold text-red-600">Menu</span>
                <button onclick="toggleMobileMenu()" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="space-y-4">
                <a href="/" class="block text-gray-700 hover:text-red-600 font-semibold">Ballina</a>
                @if(session('user_logged_in'))
                    <a href="{{ route('user.dashboard') }}" class="block text-gray-700 hover:text-red-600 font-semibold">Dashboard</a>
                    <a href="{{ route('user.listings.index') }}" class="block text-gray-700 hover:text-red-600 font-semibold">Listimet e Mia</a>
                    <a href="{{ route('user.profile') }}" class="block text-gray-700 hover:text-red-600 font-semibold">Profili</a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-700 hover:text-red-600 font-semibold">Dil</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-red-600 font-semibold">Kyçu</a>
                    <a href="{{ route('register') }}" class="block text-gray-700 hover:text-red-600 font-semibold">Regjistrohu</a>
                @endif
            </nav>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-600 hover:text-gray-900 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <a href="/" class="text-xl md:text-2xl font-bold bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent">
                        🇦🇱 Platforma Shqiptare
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="text-gray-700 hover:text-red-600 font-semibold transition">Ballina</a>
                    @if(session('user_logged_in'))
                        <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-red-600 font-semibold transition">Dashboard</a>
                        <a href="{{ route('user.listings.index') }}" class="text-gray-700 hover:text-red-600 font-semibold transition">Listimet e Mia</a>
                        <div class="relative group">
                            <button class="flex items-center text-gray-700 hover:text-red-600 font-semibold transition">
                                <span class="mr-1">👤</span>
                                {{ session('user_name') }}
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600">Profili</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600">
                                        Dil
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 font-semibold transition">Kyçu</a>
                        <a href="{{ route('register') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-semibold">Regjistrohu</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div>
                    <h3 class="font-bold text-base md:text-lg mb-4">Platforma Shqiptare</h3>
                    <p class="text-sm text-gray-400">Lidhja e komunitetit shqiptar me biznese dhe shërbime të besueshme.</p>
                </div>
                <div>
                    <h4 class="font-bold text-sm md:text-base mb-4">Linqe të Shpejta</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="text-gray-400 hover:text-white transition">Ballina</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition">Regjistrohu</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Kyçu</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm md:text-base mb-4">Për Biznesin</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Shto Listim</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Çmimet</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Ndihmë</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm md:text-base mb-4">Kontakti</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📧 info@platform.al</li>
                        <li>📞 +355 69 XXX XXXX</li>
                        <li>📍 Tiranë, Shqipëri</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 py-4 md:py-6 text-center text-xs md:text-sm">
            <p>© {{ date('Y') }} Platforma Shqiptare. Të gjitha të drejtat e rezervuara.</p>
            <p class="mt-2">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="hover:underline text-red-400">LaraCopilot</a></p>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>

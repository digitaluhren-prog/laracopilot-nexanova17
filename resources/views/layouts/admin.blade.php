<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-sm text-gray-400 mt-1">{{ session('admin_name') }}</p>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 hover:bg-gray-700 transition @if(request()->routeIs('admin.dashboard')) bg-gray-700 @endif">
                    <span class="mr-3">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-700 transition @if(request()->routeIs('admin.users.*')) bg-gray-700 @endif">
                    <span class="mr-3">👥</span>
                    <span>Përdoruesit</span>
                </a>
                <a href="{{ route('admin.listings.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-700 transition @if(request()->routeIs('admin.listings.index')) bg-gray-700 @endif">
                    <span class="mr-3">📋</span>
                    <span>Listimet</span>
                </a>
                <a href="{{ route('admin.listings.pending') }}" class="flex items-center px-6 py-3 hover:bg-gray-700 transition @if(request()->routeIs('admin.listings.pending')) bg-gray-700 @endif">
                    <span class="mr-3">⏳</span>
                    <span>Në Pritje të Aprovimit</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-700 transition @if(request()->routeIs('admin.categories.*')) bg-gray-700 @endif">
                    <span class="mr-3">🏷️</span>
                    <span>Kategoritë</span>
                </a>
                <a href="{{ route('admin.ratings.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-700 transition @if(request()->routeIs('admin.ratings.*')) bg-gray-700 @endif">
                    <span class="mr-3">⭐</span>
                    <span>Vlerësimet</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-6">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded transition">
                        Dil nga Paneli
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm">
                <div class="px-8 py-4">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('header', 'Dashboard')</h2>
                </div>
            </header>
            <main class="p-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Platforma Shqiptare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-800 to-gray-900 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl text-white">🔐</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Admin Panel</h2>
                <p class="text-gray-600 mt-2">Kyçu në panelin e administratorit</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm font-bold text-blue-900 mb-3 flex items-center">
                    <span class="mr-2">🔑</span> Kredencialet e Testimit
                </p>
                <div class="space-y-2">
                    <div class="bg-white rounded px-3 py-2">
                        <p class="text-xs text-gray-600 font-semibold">Email:</p>
                        <p class="text-sm font-mono text-gray-900 font-bold">admin@platform.al</p>
                    </div>
                    <div class="bg-white rounded px-3 py-2">
                        <p class="text-xs text-gray-600 font-semibold">Fjalëkalimi:</p>
                        <p class="text-sm font-mono text-gray-900 font-bold">admin123</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="admin@platform.al" 
                        required 
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-red-600 transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Fjalëkalimi</label>
                    <input 
                        type="password" 
                        name="password" 
                        value="admin123" 
                        required 
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-red-600 transition"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-red-600 to-red-800 text-white py-3 px-4 rounded-lg hover:from-red-700 hover:to-red-900 transition font-bold text-lg shadow-lg transform hover:scale-105"
                >
                    Kyçu në Admin Panel
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="/" class="text-gray-600 hover:text-gray-900 text-sm font-semibold">
                    ← Kthehu në faqen kryesore
                </a>
            </div>
        </div>

        <div class="text-center mt-6">
            <p class="text-gray-400 text-sm">© {{ date('Y') }} Platforma Shqiptare - Admin Panel</p>
        </div>
    </div>
</body>
</html>
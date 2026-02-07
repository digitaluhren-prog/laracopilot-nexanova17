@extends('layouts.app')

@section('title', 'Kyçu - Platforma Shqiptare')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Kyçu</h2>
                <p class="text-gray-600 mt-2">Mirë se erdhe përsëri në Platformën Shqiptare</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm font-semibold text-blue-900 mb-2">Kredencialet e Testimit:</p>
                <p class="text-sm text-blue-800"><strong>Email:</strong> user@platform.al</p>
                <p class="text-sm text-blue-800"><strong>Fjalëkalimi:</strong> user123</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', 'user@platform.al') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fjalëkalimi</label>
                    <input type="password" name="password" value="user123" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('password') border-red-500 @enderror">
                    @error('password')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition font-bold text-lg shadow-lg">
                    Kyçu
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Nuk ke llogari? <a href="{{ route('register') }}" class="text-red-600 hover:underline font-semibold">Regjistrohu këtu</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

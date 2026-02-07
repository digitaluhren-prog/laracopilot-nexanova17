@extends('layouts.app')

@section('title', 'Regjistrohu - Platforma Shqiptare')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Regjistrohu</h2>
                <p class="text-gray-600 mt-2">Krijo llogari falas në Platformën Shqiptare</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Emri i Plotë *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telefoni</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+355 69 123 4567" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Qyteti</label>
                    <select name="city" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                        <option value="">Zgjidh Qytetin</option>
                        <option value="Tiranë" {{ old('city') == 'Tiranë' ? 'selected' : '' }}>Tiranë</option>
                        <option value="Durrës" {{ old('city') == 'Durrës' ? 'selected' : '' }}>Durrës</option>
                        <option value="Vlorë" {{ old('city') == 'Vlorë' ? 'selected' : '' }}>Vlorë</option>
                        <option value="Shkodër" {{ old('city') == 'Shkodër' ? 'selected' : '' }}>Shkodër</option>
                        <option value="Korçë" {{ old('city') == 'Korçë' ? 'selected' : '' }}>Korçë</option>
                        <option value="Elbasan" {{ old('city') == 'Elbasan' ? 'selected' : '' }}>Elbasan</option>
                        <option value="Fier" {{ old('city') == 'Fier' ? 'selected' : '' }}>Fier</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fjalëkalimi *</label>
                    <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('password') border-red-500 @enderror">
                    @error('password')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmo Fjalëkalimin *</label>
                    <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                </div>

                <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition font-bold text-lg shadow-lg">
                    Regjistrohu
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Ke një llogari? <a href="{{ route('login') }}" class="text-red-600 hover:underline font-semibold">Kyçu këtu</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

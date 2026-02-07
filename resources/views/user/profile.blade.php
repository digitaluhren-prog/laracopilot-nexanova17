@extends('layouts.app')

@section('title', 'Profili Im - Platforma Shqiptare')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 md:py-8">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8">Profili Im</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm md:text-base">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-4 md:p-8">
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Emri i Plotë *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('name') border-red-500 @enderror">
                @error('name')<span class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                <input type="email" value="{{ $user->email }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 bg-gray-100 text-sm md:text-base">
                <p class="text-xs text-gray-500 mt-1">Email nuk mund të ndryshohet</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Telefoni</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+355 69 123 4567" class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Qyteti</label>
                <select name="city" class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base">
                    <option value="">Zgjidh Qytetin</option>
                    <option value="Tiranë" {{ old('city', $user->city) == 'Tiranë' ? 'selected' : '' }}>Tiranë</option>
                    <option value="Durrës" {{ old('city', $user->city) == 'Durrës' ? 'selected' : '' }}>Durrës</option>
                    <option value="Vlorë" {{ old('city', $user->city) == 'Vlorë' ? 'selected' : '' }}>Vlorë</option>
                    <option value="Shkodër" {{ old('city', $user->city) == 'Shkodër' ? 'selected' : '' }}>Shkodër</option>
                    <option value="Korçë" {{ old('city', $user->city) == 'Korçë' ? 'selected' : '' }}>Korçë</option>
                    <option value="Elbasan" {{ old('city', $user->city) == 'Elbasan' ? 'selected' : '' }}>Elbasan</option>
                    <option value="Fier" {{ old('city', $user->city) == 'Fier' ? 'selected' : '' }}>Fier</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Bio</label>
                <textarea name="bio" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base" placeholder="Trego diçka për veten...">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <hr class="my-6 md:my-8">

            <h3 class="text-lg md:text-xl font-bold mb-4">Ndrysho Fjalëkalimin</h3>
            <p class="text-xs md:text-sm text-gray-600 mb-4">Lëre bosh nëse nuk dëshiron të ndryshosh fjalëkalimin</p>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Fjalëkalimi Aktual</label>
                <input type="password" name="current_password" class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('current_password') border-red-500 @enderror">
                @error('current_password')<span class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Fjalëkalimi i Ri</label>
                <input type="password" name="new_password" class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('new_password') border-red-500 @enderror">
                @error('new_password')<span class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmo Fjalëkalimin e Ri</label>
                <input type="password" name="new_password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base">
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 md:gap-4">
                <a href="{{ route('user.dashboard') }}" class="bg-gray-300 text-gray-700 px-6 py-2 md:py-3 rounded-lg hover:bg-gray-400 transition font-semibold text-center text-sm md:text-base">
                    Anullo
                </a>
                <button type="submit" class="bg-red-600 text-white px-6 py-2 md:py-3 rounded-lg hover:bg-red-700 transition font-semibold text-sm md:text-base">
                    Ruaj Ndryshimet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

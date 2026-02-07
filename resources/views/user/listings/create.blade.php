@extends('layouts.app')

@section('title', 'Krijo Listim të Ri - Platforma Shqiptare')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 md:py-8">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8">Krijo Listim të Ri</h1>

    <div class="bg-white rounded-lg shadow-md p-4 md:p-8">
        <form action="{{ route('user.listings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Images Upload -->
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">📸 Fotot e Listimit</label>
                <input type="file" name="images[]" accept="image/jpeg,image/jpg,image/png,image/webp" multiple class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('images.*') border-red-500 @enderror">
                <p class="text-xs text-gray-600 mt-2">💡 <strong>Foto e parë</strong> do të shfaqet si foto kryesore. Mund të ngarkoni deri në 10 foto.</p>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP (Max: 2MB për foto)</p>
                @error('images.*')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Titulli i Listimit *</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('title') border-red-500 @enderror" placeholder="p.sh. Klinika Dentare Dr. Alban">
                @error('title')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Kategoria *</label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('category_id') border-red-500 @enderror">
                    <option value="">Zgjidh Kategorinë</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->icon }} {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Përshkrimi *</label>
                <textarea name="description" rows="6" required class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('description') border-red-500 @enderror" placeholder="Përshkruani shërbimin tuaj në detaje...">{{ old('description') }}</textarea>
                @error('description')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Qyteti *</label>
                    <select name="city" required class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('city') border-red-500 @enderror">
                        <option value="">Zgjidh Qytetin</option>
                        <option value="Tiranë" {{ old('city') == 'Tiranë' ? 'selected' : '' }}>Tiranë</option>
                        <option value="Durrës" {{ old('city') == 'Durrës' ? 'selected' : '' }}>Durrës</option>
                        <option value="Vlorë" {{ old('city') == 'Vlorë' ? 'selected' : '' }}>Vlorë</option>
                        <option value="Shkodër" {{ old('city') == 'Shkodër' ? 'selected' : '' }}>Shkodër</option>
                        <option value="Korçë" {{ old('city') == 'Korçë' ? 'selected' : '' }}>Korçë</option>
                        <option value="Elbasan" {{ old('city') == 'Elbasan' ? 'selected' : '' }}>Elbasan</option>
                        <option value="Fier" {{ old('city') == 'Fier' ? 'selected' : '' }}>Fier</option>
                    </select>
                    @error('city')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Adresa *</label>
                    <input type="text" name="address" value="{{ old('address') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('address') border-red-500 @enderror" placeholder="Rruga, Nr.">
                    @error('address')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Telefoni *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('phone') border-red-500 @enderror" placeholder="+355 69 XXX XXXX">
                    @error('phone')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email (Opsional)</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('email') border-red-500 @enderror" placeholder="info@example.com">
                    @error('email')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Website (Opsional)</label>
                <input type="url" name="website" value="{{ old('website') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('website') border-red-500 @enderror" placeholder="https://example.com">
                @error('website')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 md:gap-4 pt-6 border-t">
                <a href="{{ route('user.listings.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold text-center text-sm md:text-base">
                    Anullo
                </a>
                <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition font-semibold text-sm md:text-base shadow-lg">
                    ✅ Krijo Listimin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

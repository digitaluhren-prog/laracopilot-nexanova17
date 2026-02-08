@extends('layouts.admin')

@section('title', 'Ndrysho Listimin - Admin Panel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.listings.show', $listing->id) }}" class="text-blue-600 hover:underline mb-2 inline-block">← Kthehu te Detajet</a>
        <h1 class="text-3xl font-bold">Ndrysho Listimin</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('admin.listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Existing Images -->
            @if($listing->images->count() > 0)
            <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                <label class="block text-sm font-bold text-gray-700 mb-3">📸 Fotot Ekzistuese</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($listing->images as $index => $image)
                    <div class="relative group">
                        <img src="{{ $image->getImageUrl() }}" alt="Image {{ $index + 1 }}" class="w-full h-32 object-cover rounded-lg">
                        @if($index === 0)
                            <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">Kryesore</span>
                        @endif
                        <label class="absolute top-2 right-2 bg-white rounded-full p-2 shadow-md cursor-pointer hover:bg-red-50 transition">
                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        </label>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-600 mt-3">✓ Kliko në shenjën e kontrollit për të fshirë fotot. Foto e parë është gjithmonë foto kryesore.</p>
            </div>
            @endif

            <!-- Add New Images -->
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">📸 Shto Foto të Reja</label>
                <input type="file" name="images[]" accept="image/jpeg,image/jpg,image/png,image/webp" multiple class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('images.*') border-red-500 @enderror">
                <p class="text-xs text-gray-600 mt-2">💡 Fotot e reja do të shtohen në fund të galerisë.</p>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP (Max: 2MB për foto)</p>
                @error('images.*')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Titulli i Listimit *</label>
                <input type="text" name="title" value="{{ old('title', $listing->title) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('title') border-red-500 @enderror">
                @error('title')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Kategoria *</label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('category_id') border-red-500 @enderror">
                    <option value="">Zgjidh Kategorinë</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>{{ $category->icon }} {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Përshkrimi *</label>
                <textarea name="description" rows="6" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $listing->description) }}</textarea>
                @error('description')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Qyteti *</label>
                    <select name="city" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('city') border-red-500 @enderror">
                        <option value="">Zgjidh Qytetin</option>
                        <option value="Tiranë" {{ old('city', $listing->city) == 'Tiranë' ? 'selected' : '' }}>Tiranë</option>
                        <option value="Durrës" {{ old('city', $listing->city) == 'Durrës' ? 'selected' : '' }}>Durrës</option>
                        <option value="Vlorë" {{ old('city', $listing->city) == 'Vlorë' ? 'selected' : '' }}>Vlorë</option>
                        <option value="Shkodër" {{ old('city', $listing->city) == 'Shkodër' ? 'selected' : '' }}>Shkodër</option>
                        <option value="Korçë" {{ old('city', $listing->city) == 'Korçë' ? 'selected' : '' }}>Korçë</option>
                        <option value="Elbasan" {{ old('city', $listing->city) == 'Elbasan' ? 'selected' : '' }}>Elbasan</option>
                        <option value="Fier" {{ old('city', $listing->city) == 'Fier' ? 'selected' : '' }}>Fier</option>
                    </select>
                    @error('city')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Adresa *</label>
                    <input type="text" name="address" value="{{ old('address', $listing->address) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('address') border-red-500 @enderror">
                    @error('address')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Telefoni *</label>
                    <input type="text" name="phone" value="{{ old('phone', $listing->phone) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('phone') border-red-500 @enderror">
                    @error('phone')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email (Opsional)</label>
                    <input type="email" name="email" value="{{ old('email', $listing->email) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Website (Opsional)</label>
                <input type="url" name="website" value="{{ old('website', $listing->website) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('website') border-red-500 @enderror">
                @error('website')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t">
                <a href="{{ route('admin.listings.show', $listing->id) }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Anullo
                </a>
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg">
                    💾 Ruaj Ndryshimet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

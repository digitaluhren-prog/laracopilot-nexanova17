@extends('layouts.app')

@section('title', 'Ndrysho Listimin - Platforma Shqiptare')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 md:py-8">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8">Ndrysho Listimin</h1>

    <div class="bg-white rounded-lg shadow-md p-4 md:p-8">
        <form action="{{ route('user.listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Existing Images --}}
            @if($listing->images->count())
            <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                <label class="block text-sm font-bold text-gray-700 mb-3">📸 Fotot Ekzistuese</label>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($listing->images as $index => $image)
                        <div class="relative group border rounded-lg overflow-hidden shadow-sm">
                            <img src="{{ $image->url }}" class="w-full h-32 object-cover">

                            @if($index === 0)
                                <span class="absolute top-1 left-1 bg-red-600 text-white text-xs px-2 py-1 rounded font-bold">
                                    Cover
                                </span>
                            @endif

                            <label class="absolute top-1 right-1 bg-white/90 rounded-full p-2 shadow cursor-pointer hover:bg-red-50 transition">
                                <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"
                                       class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            </label>
                        </div>
                    @endforeach
                </div>

                <p class="text-xs text-gray-600 mt-3">
                    ✓ Shëno fotot që dëshiron të fshish. Foto e parë është gjithmonë cover.
                </p>
            </div>
            @endif

            {{-- Add New Images --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">📸 Shto Foto të Reja</label>

                <input type="file" name="images[]" id="imagesInput" multiple
                       accept="image/jpeg,image/jpg,image/png,image/webp"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('images.*') border-red-500 @enderror">

                <p class="text-xs text-gray-600 mt-2">
                    💡 Fotot e reja shtohen në fund të galerisë (max 10 gjithsej).
                </p>

                @error('images.*')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror

                {{-- Preview new images --}}
                <div id="imagePreview" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4 hidden"></div>
            </div>

            {{-- Title --}}
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Titulli i Listimit *</label>
                <input type="text" name="title" value="{{ old('title', $listing->title) }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('title') border-red-500 @enderror">
                @error('title')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            {{-- Category --}}
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Kategoria *</label>
                <select name="category_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('category_id') border-red-500 @enderror">
                    <option value="">Zgjidh Kategorinë</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->icon }} {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Përshkrimi *</label>
                <textarea name="description" rows="6" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('description') border-red-500 @enderror">{{ old('description', $listing->description) }}</textarea>
                @error('description')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            {{-- City + Address --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Qyteti *</label>
                    <select name="city" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('city') border-red-500 @enderror">
                        <option value="">Zgjidh Qytetin</option>
                        @foreach(['Tiranë','Durrës','Vlorë','Shkodër','Korçë','Elbasan','Fier'] as $city)
                            <option value="{{ $city }}" {{ old('city', $listing->city) == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    @error('city')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Adresa *</label>
                    <input type="text" name="address" value="{{ old('address', $listing->address) }}" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('address') border-red-500 @enderror">
                    @error('address')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Phone + Email --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Telefoni *</label>
                    <input type="text" name="phone" value="{{ old('phone', $listing->phone) }}" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('phone') border-red-500 @enderror">
                    @error('phone')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email (Opsional)</label>
                    <input type="email" name="email" value="{{ old('email', $listing->email) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('email') border-red-500 @enderror">
                    @error('email')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Website --}}
            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Website (Opsional)</label>
                <input type="url" name="website" value="{{ old('website', $listing->website) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 md:py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent text-sm md:text-base @error('website') border-red-500 @enderror">
                @error('website')<span class="text-red-500 text-xs md:text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row justify-end gap-3 md:gap-4 pt-6 border-t">
                <a href="{{ route('user.listings.index') }}"
                   class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold text-center text-sm md:text-base">
                    Anullo
                </a>
                <button type="submit"
                        class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition font-semibold text-sm md:text-base shadow-lg">
                    💾 Ruaj Ndryshimet
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Preview JS --}}
<script>
document.getElementById('imagesInput')?.addEventListener('change', function () {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    const files = Array.from(this.files).slice(0, 10);

    if (files.length) preview.classList.remove('hidden');

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'border rounded-lg overflow-hidden shadow-sm';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-28 object-cover">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection
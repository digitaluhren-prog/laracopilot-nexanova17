@extends('layouts.app')

@section('title', 'Ballina - Platforma Shqiptare')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-5xl font-bold mb-4 md:mb-6">Mirë se erdhe në Platformën Shqiptare</h1>
        <p class="text-lg md:text-xl mb-6 md:mb-8 text-red-100">Gjeni profesionistë, shërbime dhe biznese të besueshme në komunitetin tonë</p>
        <div class="flex flex-col sm:flex-row justify-center gap-3 md:gap-4 px-4">
            @if(!session('user_logged_in'))
                <a href="{{ route('register') }}" class="bg-white text-red-600 px-6 md:px-8 py-3 rounded-lg font-bold hover:bg-red-50 transition shadow-lg text-center">
                    Regjistrohu Falas
                </a>
                <a href="{{ route('login') }}" class="bg-red-900 text-white px-6 md:px-8 py-3 rounded-lg font-bold hover:bg-red-950 transition shadow-lg text-center">
                    Kyçu
                </a>
            @else
                <a href="{{ route('user.listings.create') }}" class="bg-white text-red-600 px-6 md:px-8 py-3 rounded-lg font-bold hover:bg-red-50 transition shadow-lg text-center">
                    Shto Listim të Ri
                </a>
                <a href="{{ route('user.dashboard') }}" class="bg-red-900 text-white px-6 md:px-8 py-3 rounded-lg font-bold hover:bg-red-950 transition shadow-lg text-center">
                    Dashboard
                </a>
            @endif
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="max-w-7xl mx-auto px-4 py-12 md:py-16">
    <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12">Kategoritë e Shërbimeve</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 md:gap-6">
        @foreach($categories as $category)
        <a href="{{ route('home') }}?category={{ $category->id }}" class="bg-white rounded-lg shadow-md p-4 md:p-6 text-center hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="text-3xl md:text-4xl mb-2 md:mb-3">{{ $category->icon }}</div>
            <h3 class="font-bold text-base md:text-lg mb-1 md:mb-2">{{ $category->name }}</h3>
            <p class="text-xs md:text-sm text-gray-600">{{ $category->approved_listings_count }} listime</p>
        </a>
        @endforeach
    </div>
</div>

<!-- Search & Filter Section -->
<div class="bg-gray-100 py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <form action="{{ route('home') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Kërko</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Emri i biznesit..." class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Kategoria</label>
                        <select name="category" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                            <option value="">Të gjitha</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Qyteti</label>
                        <select name="city" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                            <option value="">Të gjitha</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                            Kërko
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Listings Section -->
<div class="max-w-7xl mx-auto px-4 py-12 md:py-16">
    <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8">Listimet e Fundit</h2>
    @if($listings->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($listings as $listing)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                @php
                    $mainImage = $listing->getMainImage();
                @endphp
                @if($mainImage)
                    <img src="{{ $mainImage }}" alt="{{ $listing->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="bg-gradient-to-r from-red-500 to-red-600 h-48 flex items-center justify-center text-white text-5xl">
                        {{ $listing->category->icon }}
                    </div>
                @endif
                <div class="p-4 md:p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">{{ $listing->category->name }}</span>
                        <div class="flex items-center text-yellow-500">
                            <span class="mr-1">⭐</span>
                            <span class="text-sm font-semibold">{{ number_format($listing->rating_average, 1) }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ $listing->rating_count }})</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-base md:text-lg mb-2 line-clamp-2">{{ $listing->title }}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($listing->description, 80) }}</p>
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="mr-2">📍</span>
                        <span class="truncate">{{ $listing->city }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <span class="mr-2">📞</span>
                        <span class="truncate">{{ $listing->phone }}</span>
                    </div>
                    <a href="{{ route('listing.show', $listing->id) }}" class="block text-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-semibold text-sm">
                        Shiko Detajet
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $listings->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Nuk ka listime për këtë kërkesë.</p>
        </div>
    @endif
</div>

<!-- Features Section -->
<div class="bg-gray-100 py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12">Pse të Zgjidhni Ne?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            <div class="text-center bg-white rounded-lg p-6 shadow-md">
                <div class="text-4xl md:text-5xl mb-4">✅</div>
                <h3 class="font-bold text-lg md:text-xl mb-3">Verifikuar dhe i Besueshëm</h3>
                <p class="text-sm md:text-base text-gray-600">Të gjitha listimet janë verifikuar nga administratorët tanë për të siguruar cilësi të lartë.</p>
            </div>
            <div class="text-center bg-white rounded-lg p-6 shadow-md">
                <div class="text-4xl md:text-5xl mb-4">🌍</div>
                <h3 class="font-bold text-lg md:text-xl mb-3">Komuniteti Shqiptar</h3>
                <p class="text-sm md:text-base text-gray-600">Platforma e vetme e dedikuar për komunitetin shqiptar jashtë vendit.</p>
            </div>
            <div class="text-center bg-white rounded-lg p-6 shadow-md">
                <div class="text-4xl md:text-5xl mb-4">💯</div>
                <h3 class="font-bold text-lg md:text-xl mb-3">Falas dhe i Thjeshtë</h3>
                <p class="text-sm md:text-base text-gray-600">Regjistrohu falas dhe fillo të krijosh listimet e tua në vetëm disa minuta.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 md:mb-6">Gati për të Filluar?</h2>
        <p class="text-lg md:text-xl mb-6 md:mb-8 text-red-100">Bashkohu me mijëra profesionistë dhe biznese në platformën tonë</p>
        @if(!session('user_logged_in'))
            <a href="{{ route('register') }}" class="inline-block bg-white text-red-600 px-8 md:px-10 py-3 md:py-4 rounded-lg font-bold hover:bg-red-50 transition shadow-lg text-base md:text-lg">
                Regjistrohu Tani
            </a>
        @else
            <a href="{{ route('user.listings.create') }}" class="inline-block bg-white text-red-600 px-8 md:px-10 py-3 md:py-4 rounded-lg font-bold hover:bg-red-50 transition shadow-lg text-base md:text-lg">
                Krijo Listimin e Parë
            </a>
        @endif
    </div>
</div>
@endsection

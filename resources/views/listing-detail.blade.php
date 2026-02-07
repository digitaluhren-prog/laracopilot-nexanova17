@extends('layouts.app')

@section('title', $listing->title . ' - Platforma Shqiptare')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Listing Images -->
            @if($listing->hasImages())
                @php
                    $mainImage = $listing->images->first();
                    $galleryImages = $listing->images->skip(1);
                @endphp
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 md:mb-6">
                    <img src="{{ $mainImage->getImageUrl() }}" alt="{{ $listing->title }}" class="w-full h-64 md:h-96 object-cover">
                </div>
                
                @if($galleryImages->count() > 0)
                <div class="grid grid-cols-3 gap-2 mb-4 md:mb-6">
                    @foreach($galleryImages->take(6) as $image)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ $image->getImageUrl() }}" alt="Gallery image" class="w-full h-24 md:h-32 object-cover cursor-pointer hover:opacity-75 transition">
                    </div>
                    @endforeach
                </div>
                @endif
            @else
                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-md mb-4 md:mb-6 h-64 md:h-96 flex items-center justify-center text-white">
                    <div class="text-9xl">{{ $listing->category->icon }}</div>
                </div>
            @endif

            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-4 md:mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs md:text-sm font-semibold inline-block w-fit">{{ $listing->category->name }}</span>
                    <div class="flex items-center text-yellow-500">
                        <span class="mr-1 text-lg md:text-xl">⭐</span>
                        <span class="text-base md:text-lg font-bold">{{ number_format($listing->rating_average, 1) }}</span>
                        <span class="text-gray-500 ml-1 text-sm md:text-base">({{ $listing->rating_count }} vlerësime)</span>
                    </div>
                </div>
                <h1 class="text-2xl md:text-4xl font-bold mb-4">{{ $listing->title }}</h1>
                <div class="flex flex-wrap items-center text-gray-600 gap-3 md:gap-4 text-sm md:text-base">
                    <div class="flex items-center">
                        <span class="mr-2">👤</span>
                        <span>{{ $listing->user->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="mr-2">👁️</span>
                        <span>{{ $listing->view_count }} shikime</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-4 md:mb-6">
                <h2 class="text-xl md:text-2xl font-bold mb-4">Përshkrimi</h2>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed whitespace-pre-line">{{ $listing->description }}</p>
            </div>

            <!-- Add Rating Form -->
            @if(session('user_logged_in'))
                @php
                    $userRating = $listing->ratings()->where('user_id', session('user_id'))->first();
                @endphp
                @if(!$userRating)
                <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-4 md:mb-6">
                    <h2 class="text-xl md:text-2xl font-bold mb-4">Lëni një Vlerësim</h2>
                    <form action="{{ route('rating.store', $listing->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Vlerësimi juaj *</label>
                            <div class="flex items-center space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" required class="hidden peer">
                                        <span class="text-3xl text-gray-300 peer-checked:text-yellow-500 hover:text-yellow-400 transition">★</span>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Komenti (Opsional)</label>
                            <textarea name="comment" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent" placeholder="Ndani eksperiencën tuaj...">{{ old('comment') }}</textarea>
                            @error('comment')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                            Dërgo Vlerësimin
                        </button>
                    </form>
                </div>
                @else
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                    <p class="font-semibold">Ju keni vlerësuar këtë listim.</p>
                    @if(!$userRating->approved)
                        <p class="text-sm mt-1">Vlerësimi juaj është në pritje të aprovimit nga administratorët.</p>
                    @endif
                    <form action="{{ route('rating.destroy', $userRating->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline font-semibold" onclick="return confirm('Je i sigurt që dëshiron ta fshish vlerësimin tënd?')">
                            Fshi Vlerësimin Tim
                        </button>
                    </form>
                </div>
                @endif
            @else
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                    <p class="font-semibold">Duhet të kyçeni për të lënë një vlerësim.</p>
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline mt-2 inline-block">Kyçu këtu</a>
                </div>
            @endif

            <!-- Ratings -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
                <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Vlerësimet e Klientëve</h2>
                @if($listing->approvedRatings->count() > 0)
                    <div class="space-y-4">
                        @foreach($listing->approvedRatings as $rating)
                        <div class="border-b pb-4 last:border-b-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold mr-3 flex-shrink-0">
                                        {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-sm md:text-base">{{ $rating->user->name }}</div>
                                        <div class="text-xs md:text-sm text-gray-500">{{ $rating->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-base md:text-lg {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            @if($rating->comment)
                                <p class="text-sm md:text-base text-gray-700 sm:ml-13">{{ $rating->comment }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8 text-sm md:text-base">Ende nuk ka vlerësime për këtë listim.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-4 md:mb-6 lg:sticky lg:top-4">
                <h3 class="text-lg md:text-xl font-bold mb-4">Informacion Kontakti</h3>
                <div class="space-y-3 md:space-y-4">
                    <div class="flex items-start">
                        <span class="text-xl md:text-2xl mr-3 flex-shrink-0">📍</span>
                        <div>
                            <div class="font-semibold text-xs md:text-sm text-gray-600">Adresa</div>
                            <div class="text-sm md:text-base text-gray-900">{{ $listing->address }}</div>
                            <div class="text-sm md:text-base text-gray-600">{{ $listing->city }}</div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <span class="text-xl md:text-2xl mr-3 flex-shrink-0">📞</span>
                        <div>
                            <div class="font-semibold text-xs md:text-sm text-gray-600">Telefoni</div>
                            <a href="tel:{{ $listing->phone }}" class="text-sm md:text-base text-red-600 hover:underline font-semibold break-all">{{ $listing->phone }}</a>
                        </div>
                    </div>
                    @if($listing->email)
                    <div class="flex items-start">
                        <span class="text-xl md:text-2xl mr-3 flex-shrink-0">📧</span>
                        <div>
                            <div class="font-semibold text-xs md:text-sm text-gray-600">Email</div>
                            <a href="mailto:{{ $listing->email }}" class="text-sm md:text-base text-red-600 hover:underline break-all">{{ $listing->email }}</a>
                        </div>
                    </div>
                    @endif
                    @if($listing->website)
                    <div class="flex items-start">
                        <span class="text-xl md:text-2xl mr-3 flex-shrink-0">🌐</span>
                        <div>
                            <div class="font-semibold text-xs md:text-sm text-gray-600">Website</div>
                            <a href="{{ $listing->website }}" target="_blank" class="text-sm md:text-base text-red-600 hover:underline break-all">{{ $listing->website }}</a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mt-6 pt-6 border-t">
                    <a href="tel:{{ $listing->phone }}" class="block w-full bg-red-600 text-white text-center px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold text-sm md:text-base">
                        📞 Kontakto Tani
                    </a>
                </div>
            </div>

            <!-- Category Info -->
            <div class="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-lg shadow-md p-4 md:p-6">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl mb-3">{{ $listing->category->icon }}</div>
                    <h4 class="font-bold text-base md:text-lg mb-2">{{ $listing->category->name }}</h4>
                    <p class="text-red-100 text-xs md:text-sm">{{ $listing->category->description }}</p>
                    <a href="{{ route('home') }}?category={{ $listing->category->id }}" class="mt-4 inline-block bg-white text-red-600 px-4 py-2 rounded-lg hover:bg-red-50 transition font-semibold text-xs md:text-sm">
                        Shiko të gjitha në {{ $listing->category->name }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

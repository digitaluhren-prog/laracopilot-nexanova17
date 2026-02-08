@extends('layouts.admin')

@section('title', 'Shiko Listimin - Admin Panel')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.listings.index') }}" class="text-blue-600 hover:underline mb-2 inline-block">← Kthehu te Listimet</a>
            <h1 class="text-3xl font-bold">Detajet e Listimit</h1>
        </div>
        <div class="flex space-x-3">
            @if($listing->status === 'pending')
                <form action="{{ route('admin.listings.approve', $listing->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                        ✅ Aprovo
                    </button>
                </form>
                <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                    ❌ Refuzo
                </button>
            @endif
            <a href="{{ route('admin.listings.edit', $listing->id) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                ✏️ Ndrysho
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Images -->
            @if($listing->hasImages())
                @php
                    $mainImage = $listing->images->first();
                    $galleryImages = $listing->images->skip(1);
                @endphp
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <img src="{{ $mainImage->getImageUrl() }}" alt="{{ $listing->title }}" class="w-full h-96 object-cover">
                </div>
                
                @if($galleryImages->count() > 0)
                <div class="grid grid-cols-4 gap-3 mb-6">
                    @foreach($galleryImages as $image)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ $image->getImageUrl() }}" alt="Gallery image" class="w-full h-32 object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
            @else
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md mb-6 h-96 flex items-center justify-center text-white">
                    <div class="text-9xl">{{ $listing->category->icon }}</div>
                </div>
            @endif

            <!-- Header Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($listing->status === 'approved') bg-green-100 text-green-800
                        @elseif($listing->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        @if($listing->status === 'approved') ✅ Aprovuar
                        @elseif($listing->status === 'pending') ⏳ Në Pritje
                        @else ❌ Refuzuar @endif
                    </span>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $listing->category->name }}</span>
                </div>
                <h2 class="text-2xl font-bold mb-4">{{ $listing->title }}</h2>
                <div class="flex items-center text-gray-600 space-x-4 text-sm">
                    <div class="flex items-center">
                        <span class="mr-2">👤</span>
                        <span>{{ $listing->user->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="mr-2">📧</span>
                        <span>{{ $listing->user->email }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="mr-2">📅</span>
                        <span>{{ $listing->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            @if($listing->status === 'rejected' && $listing->rejection_reason)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <h3 class="font-bold text-red-800 mb-2">Arsyeja e Refuzimit:</h3>
                <p class="text-red-700">{{ $listing->rejection_reason }}</p>
            </div>
            @endif

            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold mb-3">Përshkrimi</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $listing->description }}</p>
            </div>

            <!-- Ratings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Vlerësimet ({{ $listing->approvedRatings->count() }})</h3>
                @if($listing->approvedRatings->count() > 0)
                    <div class="space-y-4">
                        @foreach($listing->approvedRatings as $rating)
                        <div class="border-b pb-4 last:border-b-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                        {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold">{{ $rating->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $rating->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-lg {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            @if($rating->comment)
                                <p class="text-gray-700 ml-13">{{ $rating->comment }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Nuk ka vlerësime ende.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">Informacion Kontakti</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <span class="text-2xl mr-3">📍</span>
                        <div>
                            <div class="font-semibold text-sm text-gray-600">Adresa</div>
                            <div class="text-gray-900">{{ $listing->address }}</div>
                            <div class="text-gray-600">{{ $listing->city }}</div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <span class="text-2xl mr-3">📞</span>
                        <div>
                            <div class="font-semibold text-sm text-gray-600">Telefoni</div>
                            <div class="text-gray-900">{{ $listing->phone }}</div>
                        </div>
                    </div>
                    @if($listing->email)
                    <div class="flex items-start">
                        <span class="text-2xl mr-3">📧</span>
                        <div>
                            <div class="font-semibold text-sm text-gray-600">Email</div>
                            <div class="text-gray-900 break-all">{{ $listing->email }}</div>
                        </div>
                    </div>
                    @endif
                    @if($listing->website)
                    <div class="flex items-start">
                        <span class="text-2xl mr-3">🌐</span>
                        <div>
                            <div class="font-semibold text-sm text-gray-600">Website</div>
                            <div class="text-blue-600 hover:underline break-all">
                                <a href="{{ $listing->website }}" target="_blank">{{ $listing->website }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Statistika</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">👁️ Shikime</span>
                        <span class="font-bold">{{ $listing->view_count }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">⭐ Vlerësim Mesatar</span>
                        <span class="font-bold">{{ number_format($listing->rating_average, 1) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">📊 Vlerësime</span>
                        <span class="font-bold">{{ $listing->rating_count }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">📸 Foto</span>
                        <span class="font-bold">{{ $listing->images->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold mb-4">Refuzo Listimin</h3>
        <form action="{{ route('admin.listings.reject', $listing->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Arsyeja e Refuzimit *</label>
                <textarea name="rejection_reason" rows="4" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent" placeholder="Shkruani arsyen pse refuzoni këtë listim..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Anullo
                </button>
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                    Refuzo Listimin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

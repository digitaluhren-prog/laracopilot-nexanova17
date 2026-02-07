@extends('layouts.app')

@section('title', 'Listimet e Mia - Platforma Shqiptare')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl font-bold">Listimet e Mia</h1>
        <a href="{{ route('user.listings.create') }}" class="w-full sm:w-auto bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold text-center text-sm md:text-base">
            ➕ Shto Listim të Ri
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm md:text-base">
            {{ session('success') }}
        </div>
    @endif

    @if($listings->count() > 0)
        <!-- Mobile Card View -->
        <div class="block md:hidden space-y-4">
            @foreach($listings as $listing)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @php
                    $mainImage = $listing->getMainImage();
                @endphp
                @if($mainImage)
                    <img src="{{ $mainImage }}" alt="{{ $listing->title }}" class="w-full h-40 object-cover">
                @else
                    <div class="bg-gradient-to-r from-red-500 to-red-600 h-40 flex items-center justify-center text-white text-5xl">
                        {{ $listing->category->icon }}
                    </div>
                @endif
                <div class="p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-base truncate">{{ $listing->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $listing->category->name }}</p>
                            <p class="text-xs text-gray-500">{{ $listing->city }} • {{ $listing->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            @if($listing->status === 'approved') bg-green-100 text-green-800
                            @elseif($listing->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($listing->status === 'approved') ✅ Aprovuar
                            @elseif($listing->status === 'pending') ⏳ Në Pritje
                            @else ❌ Refuzuar @endif
                        </span>
                        <div class="flex space-x-3">
                            <a href="{{ route('user.listings.edit', $listing->id) }}" class="text-blue-600 hover:underline text-sm font-semibold">Ndrysho</a>
                            <form action="{{ route('user.listings.destroy', $listing->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm font-semibold" onclick="return confirm('Je i sigurt që dëshiron ta fshish këtë listim?')">
                                    Fshi
                                </button>
                            </form>
                        </div>
                    </div>
                    @if($listing->status === 'rejected' && $listing->rejection_reason)
                        <div class="mt-3 pt-3 border-t text-xs text-red-600">
                            <strong>Arsyeja:</strong> {{ $listing->rejection_reason }}
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Listimi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategoria</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Qyteti</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Statusi</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Veprime</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($listings as $listing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @php
                                        $mainImage = $listing->getMainImage();
                                    @endphp
                                    @if($mainImage)
                                        <img src="{{ $mainImage }}" alt="{{ $listing->title }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                    @else
                                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-xl mr-3">
                                            {{ $listing->category->icon }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $listing->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $listing->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $listing->category->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $listing->city }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($listing->status === 'approved') bg-green-100 text-green-800
                                    @elseif($listing->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($listing->status === 'approved') ✅ Aprovuar
                                    @elseif($listing->status === 'pending') ⏳ Në Pritje
                                    @else ❌ Refuzuar @endif
                                </span>
                                @if($listing->status === 'rejected' && $listing->rejection_reason)
                                    <p class="text-xs text-red-600 mt-1">{{ $listing->rejection_reason }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('user.listings.edit', $listing->id) }}" class="text-blue-600 hover:underline mr-3">Ndrysho</a>
                                <form action="{{ route('user.listings.destroy', $listing->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Je i sigurt që dëshiron ta fshish këtë listim?')">
                                        Fshi
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">
            {{ $listings->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 md:p-12 text-center">
            <div class="text-5xl md:text-6xl mb-4">📋</div>
            <h3 class="text-lg md:text-xl font-bold mb-2">Nuk ke ende listime</h3>
            <p class="text-sm md:text-base text-gray-600 mb-6">Fillo duke krijuar listimin e parë të biznesit tënd</p>
            <a href="{{ route('user.listings.create') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold text-sm md:text-base">
                Krijo Listim
            </a>
        </div>
    @endif
</div>
@endsection

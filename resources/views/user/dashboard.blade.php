@extends('layouts.app')

@section('title', 'Dashboard - Platforma Shqiptare')

@section('content')
<div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl md:text-4xl font-bold mb-2">Mirë se erdhe, {{ session('user_name') }}!</h1>
        <p class="text-sm md:text-base text-red-100">Menaxho listimet dhe profilin tënd nga këtu</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-gray-500 text-xs md:text-sm font-semibold">Total Listime</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-1 md:mt-2">{{ $totalListings }}</p>
                </div>
                <div class="text-3xl md:text-4xl hidden md:block">📋</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-gray-500 text-xs md:text-sm font-semibold">Të Aprovuara</p>
                    <p class="text-2xl md:text-3xl font-bold text-green-600 mt-1 md:mt-2">{{ $approvedListings }}</p>
                </div>
                <div class="text-3xl md:text-4xl hidden md:block">✅</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-gray-500 text-xs md:text-sm font-semibold">Në Pritje</p>
                    <p class="text-2xl md:text-3xl font-bold text-yellow-600 mt-1 md:mt-2">{{ $pendingListings }}</p>
                </div>
                <div class="text-3xl md:text-4xl hidden md:block">⏳</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-gray-500 text-xs md:text-sm font-semibold">Të Refuzuara</p>
                    <p class="text-2xl md:text-3xl font-bold text-red-600 mt-1 md:mt-2">{{ $rejectedListings }}</p>
                </div>
                <div class="text-3xl md:text-4xl hidden md:block">❌</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6 md:mb-8">
        <h2 class="text-xl md:text-2xl font-bold mb-4">Veprime të Shpejta</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
            <a href="{{ route('user.listings.create') }}" class="bg-red-600 text-white p-3 md:p-4 rounded-lg hover:bg-red-700 transition text-center font-semibold text-sm md:text-base">
                ➕ Shto Listim të Ri
            </a>
            <a href="{{ route('user.listings.index') }}" class="bg-blue-600 text-white p-3 md:p-4 rounded-lg hover:bg-blue-700 transition text-center font-semibold text-sm md:text-base">
                📋 Shiko Të Gjitha Listimet
            </a>
            <a href="{{ route('user.profile') }}" class="bg-green-600 text-white p-3 md:p-4 rounded-lg hover:bg-green-700 transition text-center font-semibold text-sm md:text-base">
                👤 Ndrysho Profilin
            </a>
        </div>
    </div>

    <!-- Recent Listings -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Listimet e Fundit</h2>
        @if($recentListings->count() > 0)
            <div class="space-y-4">
                @foreach($recentListings as $listing)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b pb-4 last:border-b-0 gap-3">
                    <div class="flex items-center space-x-3 md:space-x-4 flex-1">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-red-100 rounded-lg flex items-center justify-center text-xl md:text-2xl flex-shrink-0">
                            {{ $listing->category->icon }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-sm md:text-lg truncate">{{ $listing->title }}</h3>
                            <p class="text-xs md:text-sm text-gray-600">{{ $listing->category->name }} • {{ $listing->city }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $listing->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between sm:justify-end gap-3 sm:space-x-3">
                        <span class="px-2 md:px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                            @if($listing->status === 'approved') bg-green-100 text-green-800
                            @elseif($listing->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($listing->status === 'approved') ✅ Aprovuar
                            @elseif($listing->status === 'pending') ⏳ Në Pritje
                            @else ❌ Refuzuar @endif
                        </span>
                        <a href="{{ route('user.listings.edit', $listing->id) }}" class="text-blue-600 hover:underline font-semibold text-xs md:text-sm whitespace-nowrap">Ndrysho</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('user.listings.index') }}" class="text-red-600 hover:underline font-semibold text-sm md:text-base">Shiko të gjitha listimet →</a>
            </div>
        @else
            <div class="text-center py-8 md:py-12">
                <p class="text-gray-500 mb-4 text-sm md:text-base">Nuk ke ende listime të krijuara.</p>
                <a href="{{ route('user.listings.create') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold text-sm md:text-base">
                    Krijo Listimin e Parë
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

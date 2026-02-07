@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')
@section('header', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Përdorues</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</p>
            </div>
            <div class="text-4xl">👥</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Listime</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalListings }}</p>
            </div>
            <div class="text-4xl">📋</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Në Pritje</p>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingListings }}</p>
            </div>
            <div class="text-4xl">⏳</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Të Aprovuara</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $approvedListings }}</p>
            </div>
            <div class="text-4xl">✅</div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-semibold">Total Kategori</p>
                <p class="text-3xl font-bold mt-2">{{ $totalCategories }}</p>
            </div>
            <div class="text-4xl">🏷️</div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-semibold">Total Vlerësime</p>
                <p class="text-3xl font-bold mt-2">{{ $totalRatings }}</p>
            </div>
            <div class="text-4xl">⭐</div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm font-semibold">Vlerësime për Moderim</p>
                <p class="text-3xl font-bold mt-2">{{ $pendingRatings }}</p>
            </div>
            <div class="text-4xl">🔍</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Listings by Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold mb-4">Listimet sipas Statusit</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                <div class="flex items-center">
                    <span class="text-2xl mr-3">⏳</span>
                    <span class="font-semibold">Në Pritje</span>
                </div>
                <span class="text-2xl font-bold text-yellow-600">{{ $listingsByStatus['pending'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center">
                    <span class="text-2xl mr-3">✅</span>
                    <span class="font-semibold">Të Aprovuara</span>
                </div>
                <span class="text-2xl font-bold text-green-600">{{ $listingsByStatus['approved'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center">
                    <span class="text-2xl mr-3">❌</span>
                    <span class="font-semibold">Të Refuzuara</span>
                </div>
                <span class="text-2xl font-bold text-red-600">{{ $listingsByStatus['rejected'] }}</span>
            </div>
        </div>
    </div>

    <!-- Listings by Category -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold mb-4">Listimet sipas Kategorisë</h3>
        <div class="space-y-3">
            @foreach($listingsByCategory->take(6) as $category)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="flex items-center">
                    <span class="text-2xl mr-3">{{ $category->icon }}</span>
                    <span class="font-semibold">{{ $category->name }}</span>
                </div>
                <span class="text-xl font-bold text-gray-700">{{ $category->listings_count }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Recent Users -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h3 class="text-xl font-bold mb-4">Përdoruesit e Fundit</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Përdoruesi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Qyteti</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Regjistruar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($recentUsers as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->city ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Listings -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold">Listimet e Fundit</h3>
        <a href="{{ route('admin.listings.pending') }}" class="text-red-600 hover:underline font-semibold">Shiko të gjitha →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Titulli</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kategoria</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Përdoruesi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Statusi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Data</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($recentListings as $listing)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">{{ $listing->category->icon }}</span>
                            <span class="font-semibold">{{ Str::limit($listing->title, 40) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $listing->category->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $listing->user->name }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            @if($listing->status === 'approved') bg-green-100 text-green-800
                            @elseif($listing->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($listing->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $listing->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

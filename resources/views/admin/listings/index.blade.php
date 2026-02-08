@extends('layouts.admin')

@section('title', 'Menaxho Listimet - Admin Panel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Menaxho Listimet</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('admin.listings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-2">Kërko</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Titulli ose përdoruesi..." class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Statusi</label>
                <select name="status" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                    <option value="">Të gjitha</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Në Pritje</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprovuar</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refuzuar</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Filtro
                </button>
            </div>
        </form>
    </div>

    <!-- Listings Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Listimi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Përdoruesi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategoria</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Statusi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Veprime</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($listings as $listing)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @php
                                    $mainImage = $listing->getMainImage();
                                @endphp
                                @if($mainImage)
                                    <img src="{{ $mainImage }}" alt="{{ $listing->title }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                @else
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-xl mr-3">
                                        {{ $listing->category->icon }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-semibold text-gray-900">{{ Str::limit($listing->title, 40) }}</div>
                                    <div class="text-sm text-gray-500">{{ $listing->city }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $listing->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $listing->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $listing->category->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($listing->status === 'approved') bg-green-100 text-green-800
                                @elseif($listing->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($listing->status === 'approved') ✅ Aprovuar
                                @elseif($listing->status === 'pending') ⏳ Në Pritje
                                @else ❌ Refuzuar @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $listing->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                            <a href="{{ route('admin.listings.show', $listing->id) }}" class="text-blue-600 hover:underline">👁️ Shiko</a>
                            <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Je i sigurt që dëshiron ta fshish këtë listim?')">
                                    🗑️ Fshi
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Nuk ka listime për këtë filtër.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $listings->links() }}
    </div>
</div>
@endsection

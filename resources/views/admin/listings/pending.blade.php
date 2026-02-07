@extends('layouts.admin')

@section('title', 'Listime në Pritje të Aprovimit - Admin Panel')
@section('header', 'Listime në Pritje të Aprovimit')

@section('content')
<div class="bg-yellow-100 border border-yellow-400 rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <span class="text-4xl mr-4">⏳</span>
            <div>
                <h3 class="text-xl font-bold text-yellow-900">Listime për Moderim</h3>
                <p class="text-yellow-800">Këto listime janë në pritje të aprovimit nga ju</p>
            </div>
        </div>
        <div class="text-4xl font-bold text-yellow-900">{{ $listings->total() }}</div>
    </div>
</div>

@if($listings->count() > 0)
<div class="space-y-6">
    @foreach($listings as $listing)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-start">
                    <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center text-3xl mr-4">
                        {{ $listing->category->icon }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold mb-1">{{ $listing->title }}</h3>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="flex items-center"><span class="mr-1">🏷️</span> {{ $listing->category->name }}</span>
                            <span class="flex items-center"><span class="mr-1">📍</span> {{ $listing->city }}</span>
                            <span class="flex items-center"><span class="mr-1">👤</span> {{ $listing->user->name }}</span>
                            <span class="flex items-center"><span class="mr-1">📅</span> {{ $listing->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                    ⏳ Në Pritje
                </span>
            </div>

            <div class="mb-4">
                <h4 class="font-bold mb-2">Përshkrimi:</h4>
                <p class="text-gray-700 leading-relaxed">{{ $listing->description }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <h4 class="font-bold text-sm text-gray-600 mb-1">Adresa</h4>
                    <p class="text-gray-900">{{ $listing->address }}</p>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-gray-600 mb-1">Telefoni</h4>
                    <p class="text-gray-900">{{ $listing->phone }}</p>
                </div>
                @if($listing->email)
                <div>
                    <h4 class="font-bold text-sm text-gray-600 mb-1">Email</h4>
                    <p class="text-gray-900">{{ $listing->email }}</p>
                </div>
                @endif
                @if($listing->website)
                <div>
                    <h4 class="font-bold text-sm text-gray-600 mb-1">Website</h4>
                    <p class="text-gray-900"><a href="{{ $listing->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $listing->website }}</a></p>
                </div>
                @endif
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                <button onclick="document.getElementById('reject-modal-{{ $listing->id }}').classList.remove('hidden')" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                    ❌ Refuzo
                </button>
                <form action="{{ route('admin.listings.approve', $listing->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                        ✅ Aprovo
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal-{{ $listing->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold mb-4">Refuzo Listimin</h3>
            <form action="{{ route('admin.listings.reject', $listing->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Arsyeja e Refuzimit *</label>
                    <textarea name="rejection_reason" rows="4" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent" placeholder="Shpjego arsyen pse refuzohet ky listim..."></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="document.getElementById('reject-modal-{{ $listing->id }}').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                        Anullo
                    </button>
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                        Refuzo Listimin
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-6">
    {{ $listings->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow-md p-12 text-center">
    <div class="text-6xl mb-4">✅</div>
    <h3 class="text-xl font-bold mb-2">Nuk ka listime në pritje</h3>
    <p class="text-gray-600">Të gjitha listimet janë moderuar. Punim i shkëlqyer!</p>
</div>
@endif
@endsection

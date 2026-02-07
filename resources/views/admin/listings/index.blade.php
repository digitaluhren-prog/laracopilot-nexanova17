@extends('layouts.admin')

@section('title', 'Menaxhimi i Listimeve - Admin Panel')
@section('header', 'Menaxhimi i Listimeve')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-xl font-bold">Total Listime</h3>
            <p class="text-gray-600">Menaxho të gjitha listimet e platformës</p>
        </div>
        <div class="text-4xl font-bold text-red-600">{{ $listings->total() }}</div>
    </div>
    
    <form action="{{ route('admin.listings.index') }}" method="GET" class="flex items-center space-x-4">
        <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-600 focus:border-transparent">
            <option value="">Të gjitha statuset</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Në Pritje</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Të Aprovuara</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Të Refuzuara</option>
        </select>
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
            Filtro
        </button>
        @if(request('status'))
            <a href="{{ route('admin.listings.index') }}" class="text-gray-600 hover:underline">Pastro Filtrin</a>
        @endif
    </form>
</div>

@if($listings->count() > 0)
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Listimi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategoria</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Përdoruesi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Statusi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Data</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Veprime</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($listings as $listing)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-2xl mr-3">
                            {{ $listing->category->icon }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ Str::limit($listing->title, 40) }}</div>
                            <div class="text-sm text-gray-500">{{ $listing->city }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $listing->category->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $listing->user->name }}</td>
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
                <td class="px-6 py-4 text-sm text-gray-600">{{ $listing->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-right text-sm font-medium">
                    @if($listing->status === 'pending')
                        <form action="{{ route('admin.listings.approve', $listing->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-green-600 hover:underline mr-3">Aprovo</button>
                        </form>
                    @endif
                    <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" class="inline">
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
<div class="mt-6">
    {{ $listings->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow-md p-12 text-center">
    <div class="text-6xl mb-4">📋</div>
    <h3 class="text-xl font-bold mb-2">Nuk ka listime</h3>
    <p class="text-gray-600">Nuk ka listime që përputhen me filtrin e zgjedhur</p>
</div>
@endif
@endsection

@extends('layouts.admin')

@section('title', 'Menaxhimi i Kategorive - Admin Panel')
@section('header', 'Menaxhimi i Kategorive')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-xl font-bold">Total Kategori</h3>
        <p class="text-gray-600">Menaxho kategoritë e platformës</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
        ➕ Shto Kategori të Re
    </a>
</div>

@if($categories->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($categories as $category)
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center">
                <div class="text-4xl mr-3">{{ $category->icon }}</div>
                <div>
                    <h3 class="font-bold text-lg">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $category->slug }}</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $category->active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ $category->active ? 'Aktive' : 'Joaktive' }}
            </span>
        </div>
        
        @if($category->description)
        <p class="text-sm text-gray-600 mb-4">{{ $category->description }}</p>
        @endif
        
        <div class="flex items-center justify-between pt-4 border-t">
            <span class="text-sm font-semibold text-gray-700">
                📋 {{ $category->listings_count }} listime
            </span>
            <div class="flex space-x-2">
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 hover:underline text-sm font-semibold">
                    Ndrysho
                </a>
                @if($category->listings_count == 0)
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline text-sm font-semibold" onclick="return confirm('Je i sigurt që dëshiron ta fshish këtë kategori?')">
                        Fshi
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-6">
    {{ $categories->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow-md p-12 text-center">
    <div class="text-6xl mb-4">🏷️</div>
    <h3 class="text-xl font-bold mb-2">Nuk ka kategori</h3>
    <p class="text-gray-600 mb-6">Fillo duke krijuar kategorinë e parë</p>
    <a href="{{ route('admin.categories.create') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
        Krijo Kategori
    </a>
</div>
@endif
@endsection

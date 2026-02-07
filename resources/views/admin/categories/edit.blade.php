@extends('layouts.admin')

@section('title', 'Ndrysho Kategorinë - Admin Panel')
@section('header', 'Ndrysho Kategorinë')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex items-center mb-6">
            <div class="text-5xl mr-4">{{ $category->icon }}</div>
            <div>
                <h2 class="text-2xl font-bold">{{ $category->name }}</h2>
                <p class="text-gray-600">{{ $category->listings->count() }} listime në këtë kategori</p>
            </div>
        </div>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Emri i Kategorisë *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Ikona (Emoji)</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent" placeholder="🏥">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Përshkrimi</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent">{{ old('description', $category->description) }}</textarea>
                @error('description')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="active" value="1" {{ old('active', $category->active) ? 'checked' : '' }} class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-600">
                    <span class="ml-2 font-semibold text-gray-700">Kategoria është aktive</span>
                </label>
                <p class="text-xs text-gray-500 mt-1 ml-7">Nëse joaktive, kategoria nuk do të shfaqet në platformë</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800"><strong>Slug:</strong> {{ $category->slug }}</p>
                <p class="text-xs text-blue-700 mt-1">Slug do të përditësohet automatikisht nëse ndryshon emrin</p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Anullo
                </a>
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                    Ruaj Ndryshimet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Krijo Kategori - Admin Panel')
@section('header', 'Krijo Kategori të Re')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Emri i Kategorisë *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('name') border-red-500 @enderror" placeholder="p.sh. Doktorë">
                @error('name')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                <p class="text-xs text-gray-500 mt-1">Slug do të krijohet automatikisht nga emri</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Ikona (Emoji)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent" placeholder="🏥">
                <p class="text-xs text-gray-500 mt-1">Shto një emoji që përfaqëson kategorinë</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Përshkrimi</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent" placeholder="Përshkruani kategorinë...">{{ old('description') }}</textarea>
                @error('description')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">💡 <strong>Sugjerime:</strong></p>
                <ul class="text-sm text-blue-700 mt-2 space-y-1 ml-4 list-disc">
                    <li>Përdor emra të qartë dhe përshkrues</li>
                    <li>Zgjidh emoji që përfaqëson kategorinë</li>
                    <li>Shkruaj përshkrim të shkurtër por informues</li>
                </ul>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Anullo
                </a>
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                    Krijo Kategorinë
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

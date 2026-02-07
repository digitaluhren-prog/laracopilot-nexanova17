@extends('layouts.admin')

@section('title', 'Ndrysho Përdoruesin - Admin Panel')
@section('header', 'Ndrysho Përdoruesin')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex items-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-800 text-white rounded-full flex items-center justify-center font-bold text-2xl mr-4">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Emri i Plotë *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Telefoni</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+355 69 123 4567" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Qyteti</label>
                <select name="city" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                    <option value="">Zgjidh Qytetin</option>
                    <option value="Tiranë" {{ old('city', $user->city) == 'Tiranë' ? 'selected' : '' }}>Tiranë</option>
                    <option value="Durrës" {{ old('city', $user->city) == 'Durrës' ? 'selected' : '' }}>Durrës</option>
                    <option value="Vlorë" {{ old('city', $user->city) == 'Vlorë' ? 'selected' : '' }}>Vlorë</option>
                    <option value="Shkodër" {{ old('city', $user->city) == 'Shkodër' ? 'selected' : '' }}>Shkodër</option>
                    <option value="Korçë" {{ old('city', $user->city) == 'Korçë' ? 'selected' : '' }}>Korçë</option>
                    <option value="Elbasan" {{ old('city', $user->city) == 'Elbasan' ? 'selected' : '' }}>Elbasan</option>
                    <option value="Fier" {{ old('city', $user->city) == 'Fier' ? 'selected' : '' }}>Fier</option>
                </select>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800"><strong>Krijuar:</strong> {{ $user->created_at->format('d M Y, H:i') }}</p>
                <p class="text-sm text-blue-800 mt-1"><strong>Total Listime:</strong> {{ $user->listings->count() }}</p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
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

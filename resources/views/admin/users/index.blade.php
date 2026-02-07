@extends('layouts.admin')

@section('title', 'Menaxhimi i Përdoruesve - Admin Panel')
@section('header', 'Menaxhimi i Përdoruesve')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold">Total Përdorues</h3>
            <p class="text-gray-600">Menaxho të gjithë përdoruesit e platformës</p>
        </div>
        <div class="text-4xl font-bold text-red-600">{{ $users->total() }}</div>
    </div>
</div>

@if($users->count() > 0)
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Përdoruesi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kontakti</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Qyteti</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Listime</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Regjistruar</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Veprime</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-800 text-white rounded-full flex items-center justify-center font-bold text-lg mr-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm">
                        <div class="text-gray-900">{{ $user->email }}</div>
                        <div class="text-gray-500">{{ $user->phone ?? 'N/A' }}</div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $user->city ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        {{ $user->listings_count }} listime
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-right text-sm font-medium">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline mr-3">Ndrysho</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Je i sigurt që dëshiron ta fshish këtë përdorues?')">
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
    {{ $users->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow-md p-12 text-center">
    <div class="text-6xl mb-4">👥</div>
    <h3 class="text-xl font-bold mb-2">Nuk ka përdorues</h3>
    <p class="text-gray-600">Ende nuk ka përdorues të regjistruar në platformë</p>
</div>
@endif
@endsection

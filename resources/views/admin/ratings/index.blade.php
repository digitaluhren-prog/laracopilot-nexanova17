@extends('layouts.admin')

@section('title', 'Menaxhimi i Vlerësimeve - Admin Panel')
@section('header', 'Menaxhimi i Vlerësimeve')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-xl font-bold">Total Vlerësime</h3>
            <p class="text-gray-600">Menaxho dhe modero vlerësimet e përdoruesve</p>
        </div>
        <div class="text-4xl font-bold text-red-600">{{ $ratings->total() }}</div>
    </div>
    
    <form action="{{ route('admin.ratings.index') }}" method="GET" class="flex items-center space-x-4">
        <select name="approved" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-600 focus:border-transparent">
            <option value="">Të gjitha vlerësimet</option>
            <option value="1" {{ request('approved') === '1' ? 'selected' : '' }}>Të Aprovuara</option>
            <option value="0" {{ request('approved') === '0' ? 'selected' : '' }}>Në Pritje të Aprovimit</option>
        </select>
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
            Filtro
        </button>
        @if(request('approved') !== null)
            <a href="{{ route('admin.ratings.index') }}" class="text-gray-600 hover:underline">Pastro Filtrin</a>
        @endif
    </form>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

@if($ratings->count() > 0)
<div class="space-y-4">
    @foreach($ratings as $rating)
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-start flex-1">
                <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-800 text-white rounded-full flex items-center justify-center font-bold text-lg mr-4">
                    {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h4 class="font-bold text-lg">{{ $rating->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $rating->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-xl {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                @endfor
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $rating->approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $rating->approved ? '✅ Aprovuar' : '⏳ Në Pritje' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <p class="text-sm font-semibold text-gray-600 mb-1">Për listimin:</p>
                        <div class="flex items-center">
                            <span class="text-2xl mr-2">{{ $rating->listing->category->icon }}</span>
                            <a href="{{ route('listing.show', $rating->listing->id) }}" target="_blank" class="font-bold text-gray-900 hover:text-red-600">
                                {{ $rating->listing->title }}
                            </a>
                        </div>
                    </div>
                    
                    @if($rating->comment)
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-3">
                        <p class="text-gray-800">{{ $rating->comment }}</p>
                    </div>
                    @endif
                    
                    <div class="flex justify-end space-x-3">
                        @if(!$rating->approved)
                            <form action="{{ route('admin.ratings.approve', $rating->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:underline font-semibold">
                                    ✅ Aprovo
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-semibold" onclick="return confirm('Je i sigurt që dëshiron ta fshish këtë vlerësim?')">
                                🗑️ Fshi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-6">
    {{ $ratings->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow-md p-12 text-center">
    <div class="text-6xl mb-4">⭐</div>
    <h3 class="text-xl font-bold mb-2">Nuk ka vlerësime</h3>
    <p class="text-gray-600">Nuk ka vlerësime që përputhen me filtrin e zgjedhur</p>
</div>
@endif
@endsection

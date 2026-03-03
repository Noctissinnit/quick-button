@extends('layouts.app')

@section('title', 'Institusi')

@section('content')
    <div class="mb-12">
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2">Institusi</h1>
            <p class="text-gray-600">Jelajahi berbagai institusi yang terkait dengan ATMI</p>
        </div>

        @if($institutions->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada institusi yang tersedia</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($institutions as $institution)
                    <div class="group">
                        <a href="{{ route('institutions.show', $institution->id) }}" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition h-full flex flex-col">
                            <!-- Institution Image/Icon Area -->
                            <div class="h-40 overflow-hidden bg-gradient-to-br from-blue-500 to-teal-500 flex items-center justify-center relative">
                                @if($institution->image)
                                    <img src="{{ asset('storage/' . $institution->image) }}" 
                                         alt="{{ $institution->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                         onerror="this.parentElement.innerHTML='<i class=\"fas fa-building text-5xl text-white opacity-40\"></i>
                                @else
                                    <i class="fas fa-building text-5xl text-white opacity-40"></i>
                                @endif
                            </div>

                            <!-- Institution Content -->
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                    {{ $institution->name }}
                                </h3>
                                
                                @if($institution->description)
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2 flex-1">
                                        {{ $institution->description }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition">
                                    <span class="text-sm">{{ $institution->cards->count() }} website</span>
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

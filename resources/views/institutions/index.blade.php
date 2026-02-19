@extends('layouts.app')

@section('title', 'Institusi')

@section('content')
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Institusi</h1>
        <p class="text-gray-600 mb-8">Jelajahi berbagai institusi yang terkait dengan ATMI</p>

        @if($institutions->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada institusi yang tersedia</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($institutions as $institution)
                    <div class="group">
                        <a href="{{ $institution->link }}" target="_blank" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition h-full">
                            <!-- Institution Card -->
                            <div class="bg-gradient-to-br from-blue-500 to-teal-500 h-40 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 opacity-10">
                                    <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="30" cy="30" r="20" fill="white"/>
                                        <circle cx="70" cy="70" r="25" fill="white"/>
                                        <rect x="20" y="60" width="30" height="20" fill="white"/>
                                    </svg>
                                </div>
                                <i class="fas fa-building text-6xl text-white opacity-90"></i>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $institution->name }}</h3>
                                @if($institution->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $institution->description }}</p>
                                @endif
                                
                                <div class="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition">
                                    <span class="text-sm">Kunjungi</span>
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

@extends('layouts.app')

@section('title', $institution->name)

@section('content')
    <!-- Institution Header with Image -->
    @if($institution->image)
        <div class="mb-8 bg-gray-100 rounded-lg overflow-hidden border border-gray-300 max-h-96 flex items-center justify-center">
            <img src="{{ asset('storage/' . $institution->image) }}" alt="{{ $institution->name }}" class="w-full h-auto object-cover">
        </div>
    @endif

    <div class="mb-8">
        <a href="{{ route('institutions.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">{{ $institution->name }}</h1>
        @if($institution->description)
            <p class="text-gray-600 text-lg">{{ $institution->description }}</p>
        @endif
        <a href="{{ $institution->link }}" target="_blank" class="text-blue-600 hover:underline font-semibold mt-4 inline-block">
            <i class="fas fa-external-link-alt"></i> Buka Website Institusi
        </a>
    </div>

    <!-- Cards Section -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Website & Layanan</h2>

        @if($cards->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada website/layanan untuk institusi ini</p>
            </div>
        @else
            <!-- Search Bar -->
            <div class="relative mb-8">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Cari Website/Layanan" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="cardsContainer">
                @foreach($cards as $card)
                    <div class="card-item group" data-category="{{ $card->category }}">
                        <a href="{{ $card->url }}" target="_blank" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition h-full">
                            <!-- Card Image/Icon Area -->
                            @if($card->image)
                                <div class="h-40 overflow-hidden bg-gray-200">
                                    <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                </div>
                            @else
                                <div class="bg-gradient-to-br from-blue-500 to-teal-500 h-40 flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-10">
                                        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="30" cy="30" r="20" fill="white"/>
                                            <circle cx="70" cy="70" r="25" fill="white"/>
                                            <rect x="20" y="60" width="30" height="20" fill="white"/>
                                        </svg>
                                    </div>
                                    @if($card->icon)
                                        <i class="{{ $card->icon }} text-6xl text-white opacity-90"></i>
                                    @else
                                        <i class="fas fa-link text-6xl text-white opacity-90"></i>
                                    @endif
                                </div>
                            @endif

                            <!-- Card Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $card->title }}</h3>
                                @if($card->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $card->description }}</p>
                                @endif
                                
                                <div class="flex items-center gap-2">
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $card->category === 'internal' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($card->category) }}
                                    </span>
                                </div>

                                <div class="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition mt-3">
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

    @if(!$cards->isEmpty())
        <script>
            const searchInput = document.getElementById('searchInput');
            const cardsContainer = document.getElementById('cardsContainer');

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const cards = cardsContainer.querySelectorAll('.card-item');

                cards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p') ? card.querySelector('p').textContent.toLowerCase() : '';
                    
                    const matches = title.includes(searchTerm) || description.includes(searchTerm);
                    card.style.display = matches ? 'block' : 'none';
                });
            });
        </script>
    @endif
@endsection

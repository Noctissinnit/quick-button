@extends('layouts.app')

@section('title', session('admin_logged_in') ? 'Admin Dashboard' : 'Layanan Kelembagaan ATMI Surakarta')

@section('content')
    @if(session('admin_logged_in'))
        <!-- Admin View -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
            <p class="text-gray-600">Kelola cards portal website</p>
        </div>

        <div class="mb-6">
            <a href="{{ route('cards.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg inline-flex items-center gap-2 transition">
                <i class="fas fa-plus"></i> Tambah Card Baru
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Title</th>
                        <th class="px-6 py-4 text-left font-semibold">Category</th>
                        <th class="px-6 py-4 text-left font-semibold">URL</th>
                        <th class="px-6 py-4 text-left font-semibold">Order</th>
                        <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cards as $card)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $card->title }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $card->category === 'internal' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($card->category) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ $card->url }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                    {{ substr($card->url, 0, 40) }}...
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $card->order }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('cards.edit', $card->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm inline-flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('cards.destroy', $card->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm inline-flex items-center gap-1" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada card</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <!-- Public View -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Layanan Kelembagaan ATMI Surakarta</h1>
            
            <!-- Search Bar -->
            <div class="relative mb-8">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Cari Layanan" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="flex gap-8 mb-8 border-b">
                <button type="button" class="tab-button active" data-category="all">
                    <span class="font-semibold">SEMUA LAYANAN</span>
                </button>
                <button type="button" class="tab-button" data-category="internal">
                    <span class="font-semibold">LINK INTERNAL</span>
                </button>
                <button type="button" class="tab-button" data-category="external">
                    <span class="font-semibold">LINK EKSTERNAL</span>
                </button>
            </div>

            <!-- Cards Grid -->
            @if($cards->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada layanan yang tersedia</p>
                </div>
            @else
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
                                            <i class="fas fa-cube text-6xl text-white opacity-90"></i>
                                        @endif
                                    </div>
                                @endif

                                <!-- Card Content -->
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $card->title }}</h3>
                                    @if($card->description)
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $card->description }}</p>
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
    @endif

    @if(!session('admin_logged_in'))
        <script>
            const searchInput = document.getElementById('searchInput');
            const tabButtons = document.querySelectorAll('.tab-button');
            const cardsContainer = document.getElementById('cardsContainer');
            let currentCategory = 'all';

            // Search functionality
            searchInput.addEventListener('input', function() {
                filterCards();
            });

            // Tab navigation
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentCategory = this.dataset.category;
                    filterCards();
                });
            });

            function filterCards() {
                const searchTerm = searchInput.value.toLowerCase();
                const cards = cardsContainer.querySelectorAll('.card-item');

                cards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p') ? card.querySelector('p').textContent.toLowerCase() : '';
                    const category = card.dataset.category;

                    const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                    const matchesCategory = currentCategory === 'all' || category === currentCategory;

                    card.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
                });
            }
        </script>
    @endif
@endsection

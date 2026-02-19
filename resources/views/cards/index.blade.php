@extends('layouts.app')

@section('title', session('admin_logged_in') ? 'Admin Dashboard' : 'Layanan Kelembagaan ATMI Surakarta')

@section('content')
    @if(session('admin_logged_in'))
        <!-- Admin View -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
            <p class="text-gray-600">Kelola cards dan institusi portal website</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Cards Management -->
            <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Cards</h2>
                    <i class="fas fa-layer-group text-blue-600 text-3xl"></i>
                </div>
                <p class="text-gray-600 mb-4">Kelola cards layanan</p>
                <a href="{{ route('cards.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center gap-2 transition">
                    <i class="fas fa-plus"></i> Tambah Card
                </a>
            </div>

            <!-- Institutions Management -->
            <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Institusi</h2>
                    <i class="fas fa-building text-green-600 text-3xl"></i>
                </div>
                <p class="text-gray-600 mb-4">Kelola data institusi</p>
                <a href="{{ route('admin.institutions.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center gap-2 transition">
                    <i class="fas fa-plus"></i> Kelola Institusi
                </a>
            </div>
        </div>

        <!-- Cards Section -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Daftar Cards</h2>
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
        </div>
    @else
        <!-- Public View - Show Institutions -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Layanan Kelembagaan ATMI Surakarta</h1>
            
            <!-- Search Bar -->
            <div class="relative mb-8">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Cari Institusi" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Institutions Grid -->
            @if($institutions->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada institusi yang tersedia</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="institutionsContainer">
                    @foreach($institutions as $institution)
                        <div class="institution-item group" data-name="{{ $institution->name }}">
                            <a href="{{ $institution->link }}" target="_blank" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition h-full">
                                <!-- Institution Header -->
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

                                <!-- Institution Content -->
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
    @endif

    @if(!session('admin_logged_in'))
        <script>
            const searchInput = document.getElementById('searchInput');
            const institutionsContainer = document.getElementById('institutionsContainer');

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const institutions = institutionsContainer.querySelectorAll('.institution-item');

                institutions.forEach(institution => {
                    const name = institution.dataset.name.toLowerCase();
                    const description = institution.querySelector('p') ? institution.querySelector('p').textContent.toLowerCase() : '';
                    
                    const matches = name.includes(searchTerm) || description.includes(searchTerm);
                    institution.style.display = matches ? 'block' : 'none';
                });
            });
        </script>
    @endif
@endsection

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
            
            <!-- Search Bar for Cards -->
            <div class="mb-6 bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-search text-gray-400"></i>
                    <input 
                        type="text" 
                        id="adminCardSearch" 
                        placeholder="Cari card berdasarkan judul, kategori, atau URL..." 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    >
                    <button onclick="resetAdminCardSearch()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition inline-flex items-center gap-2">
                        <i class="fas fa-times"></i> Reset
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full" id="cardsTable">
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
            
            <!-- Call to Action - Institution Cards Button -->
            @if(!$institutions->isEmpty())
                <div class="mb-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('institutions.index') }}" class="group bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-8 shadow-lg hover:shadow-2xl transition transform hover:scale-105 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-2xl md:text-3xl font-bold mb-2">Jelajahi Institusi</h2>
                                <p class="text-blue-100 text-sm md:text-base">Temukan websites dan layanan dari berbagai institusi</p>
                            </div>
                            <i class="fas fa-institutions text-5xl opacity-20"></i>
                        </div>
                        <div class="flex items-center gap-2 group-hover:gap-4 transition-all font-semibold mt-6">
                            <span>Lihat Semua Institusi</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="mt-6 text-blue-100 text-sm">
                            <span class="font-bold text-white">{{ $institutions->count() }}</span> institusi tersedia
                        </div>
                    </a>

                    <a href="{{ route('institutions.index') }}#cardsContainer" class="group bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg p-8 shadow-lg hover:shadow-2xl transition transform hover:scale-105 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-2xl md:text-3xl font-bold mb-2">Cards & Layanan</h2>
                                <p class="text-emerald-100 text-sm md:text-base">Koleksi website dan layanan terlengkap</p>
                            </div>
                            <i class="fas fa-link text-5xl opacity-20"></i>
                        </div>
                        <div class="flex items-center gap-2 group-hover:gap-4 transition-all font-semibold mt-6">
                            <span>Jelajahi Cards</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="mt-6 text-emerald-100 text-sm">
                            <span class="font-bold text-white">{{ $cards->count() }}</span> cards tersedia
                        </div>
                    </a>
                </div>
            @endif
            
            <!-- Advanced Search Bar -->
            <div class="relative mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-sliders-h text-blue-600"></i>
                        <h3 class="text-lg font-bold text-gray-800">Pencarian Lanjutan</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <div class="relative">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input 
                                    type="text" 
                                    id="advancedSearchInput" 
                                    placeholder="Cari institusi, layanan, atau deskripsi..." 
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                >
                            </div>
                            <p class="text-xs text-gray-500 mt-2" id="resultCount"></p>
                        </div>

                        <!-- Filter -->
                        <div>
                            <select id="categoryFilter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">Semua Kategori</option>
                                <option value="institution">Institusi Saja</option>
                                <option value="internal">Cards Internal</option>
                                <option value="external">Cards External</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Results Summary -->
                    <div id="searchSummary" class="mt-4 pt-4 border-t border-gray-200 hidden">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600" id="institutionCount">0</p>
                                <p class="text-sm text-gray-600">Institusi</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-green-600" id="internalCount">0</p>
                                <p class="text-sm text-gray-600">Internal Cards</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-purple-600" id="externalCount">0</p>
                                <p class="text-sm text-gray-600">External Cards</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-600" id="totalCount">0</p>
                                <p class="text-sm text-gray-600">Total Hasil</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results Section -->
            <div id="searchResultsSection" class="mb-12 hidden">
                <!-- Institutions Results -->
                <div id="institutionsResultsWrapper" class="mb-12 hidden">
                    <div class="flex items-center gap-2 mb-6">
                        <i class="fas fa-building text-blue-600 text-2xl"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Hasil Institusi <span id="instResultCount" class="text-gray-500 text-lg">(<span id="instCount">0</span>)</span></h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="institutionsResultsContainer">
                    </div>
                </div>

                <!-- Cards Results -->
                <div id="cardsResultsWrapper" class="mb-12 hidden">
                    <div class="flex items-center gap-2 mb-6">
                        <i class="fas fa-link text-green-600 text-2xl"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Hasil Cards <span id="cardResultCount" class="text-gray-500 text-lg">(<span id="cardCount">0</span>)</span></h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="cardsResultsContainer">
                    </div>
                </div>

                <!-- No Results -->
                <div id="noResultsMessage" class="text-center py-12 bg-gray-50 rounded-lg hidden">
                    <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-600 text-lg">Tidak ada hasil pencarian untuk "<span id="searchTermDisplay"></span>"</p>
                    <p class="text-gray-500 text-sm mt-2">Coba gunakan kata kunci lain</p>
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
                        <div class="institution-item group" data-name="{{ $institution->name }}" data-id="{{ $institution->id }}">
                            <a href="{{ route('institutions.show', $institution->id) }}" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition h-full">
                                <!-- Institution Header -->
                                <div class="bg-gradient-to-br from-blue-500 to-teal-500 h-40 flex items-center justify-center relative overflow-hidden">
                                    @if($institution->image)
                                        <img src="{{ asset('storage/' . $institution->image) }}" alt="{{ $institution->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="absolute inset-0 opacity-10">
                                            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="30" cy="30" r="20" fill="white"/>
                                                <circle cx="70" cy="70" r="25" fill="white"/>
                                                <rect x="20" y="60" width="30" height="20" fill="white"/>
                                            </svg>
                                        </div>
                                        <i class="fas fa-building text-6xl text-white opacity-90"></i>
                                    @endif
                                </div>

                                <!-- Institution Content -->
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $institution->name }}</h3>
                                    @if($institution->description)
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $institution->description }}</p>
                                    @endif
                                    
                                    <div class="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition">
                                        <span class="text-sm">Lihat Layanannya</span>
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Cards Section -->
            <div id="cardsSection" class="mt-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">
                    <i class="fas fa-link text-green-600 mr-3"></i>Semua Cards & Layanan
                </h2>

                @if($cards->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Belum ada cards yang tersedia</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="cardsContainer">
                        @foreach($cards as $card)
                            <div class="card-item" data-id="{{ $card->id }}" data-title="{{ $card->title }}" data-category="{{ $card->category }}" data-description="{{ $card->description }}">
                                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition h-full flex flex-col">
                                    <!-- Card Header -->
                                    <div class="bg-gradient-to-br from-teal-500 to-blue-500 h-32 flex items-center justify-center relative overflow-hidden">
                                        @if($card->image)
                                            <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->title }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-link text-4xl text-white opacity-80"></i>
                                        @endif
                                    </div>

                                    <!-- Card Content -->
                                    <div class="p-6 flex-1 flex flex-col">
                                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $card->title }}</h3>
                                        @if($card->description)
                                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $card->description }}</p>
                                        @endif
                                        
                                        <div class="flex items-center gap-2 mt-auto mb-3">
                                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $card->category === 'internal' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($card->category) }}
                                            </span>
                                        </div>
                                        
                                        <a href="{{ $card->url }}" target="_blank" class="text-blue-600 hover:underline text-sm font-semibold inline-flex items-center gap-1">
                                            Kunjungi
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if(!session('admin_logged_in'))
        <script>
            // Data collection from DOM
            let allInstitutions = [];
            let allCards = [];

            // Initialize data from page
            function initializeData() {
                // Collect institutions data
                document.querySelectorAll('.institution-item').forEach(el => {
                    allInstitutions.push({
                        id: el.getAttribute('data-id') || el.innerText,
                        name: el.getAttribute('data-name') || el.querySelector('h3')?.textContent || '',
                        description: el.querySelector('p')?.textContent || '',
                        element: el.cloneNode(true),
                        type: 'institution'
                    });
                });

                // Collect cards data from card items
                document.querySelectorAll('.card-item').forEach(el => {
                    allCards.push({
                        id: el.getAttribute('data-id'),
                        title: el.getAttribute('data-title') || '',
                        category: el.getAttribute('data-category') || '',
                        description: el.getAttribute('data-description') || '',
                        url: el.querySelector('a[target="_blank"]')?.href || '',
                        element: el.cloneNode(true),
                        type: 'card'
                    });
                });
            }

            // Advanced Search Function
            function performAdvancedSearch() {
                const searchInput = document.getElementById('advancedSearchInput');
                const categoryFilter = document.getElementById('categoryFilter');
                const searchTerm = searchInput.value.toLowerCase().trim();
                const selectedCategory = categoryFilter.value;

                const searchResultsSection = document.getElementById('searchResultsSection');

                if (!searchTerm) {
                    searchResultsSection.classList.add('hidden');
                    document.getElementById('institutionsContainer').style.display = '';
                    document.getElementById('cardsContainer').style.display = '';
                    return;
                }

                // Hide original containers
                document.getElementById('institutionsContainer').style.display = 'none';
                document.getElementById('cardsContainer').style.display = 'none';

                // Filter institutions
                let filteredInstitutions = allInstitutions.filter(inst => {
                    if (selectedCategory === 'institution') {
                        return inst.name.toLowerCase().includes(searchTerm) || 
                               inst.description.toLowerCase().includes(searchTerm);
                    } else if (selectedCategory && selectedCategory !== '') {
                        return false;
                    }
                    return inst.name.toLowerCase().includes(searchTerm) || 
                           inst.description.toLowerCase().includes(searchTerm);
                });

                // Filter cards
                let filteredCards = allCards.filter(card => {
                    if (selectedCategory === 'institution') return false;
                    if (selectedCategory === 'internal' && card.category.toLowerCase() !== 'internal') return false;
                    if (selectedCategory === 'external' && card.category.toLowerCase() !== 'external') return false;
                    
                    return card.title.toLowerCase().includes(searchTerm) || 
                           card.description.toLowerCase().includes(searchTerm) ||
                           card.category.toLowerCase().includes(searchTerm);
                });

                // Display results
                displaySearchResults(filteredInstitutions, filteredCards, searchTerm, selectedCategory);
            }

            function displaySearchResults(institutions, cards, searchTerm, categoryFilter) {
                const searchResultsSection = document.getElementById('searchResultsSection');
                const institutionsResultsWrapper = document.getElementById('institutionsResultsWrapper');
                const cardsResultsWrapper = document.getElementById('cardsResultsWrapper');
                const noResultsMessage = document.getElementById('noResultsMessage');
                const searchSummary = document.getElementById('searchSummary');

                const totalResults = institutions.length + cards.length;

                // Clear previous results
                document.getElementById('institutionsResultsContainer').innerHTML = '';
                document.getElementById('cardsResultsContainer').innerHTML = '';

                if (totalResults === 0) {
                    searchResultsSection.classList.remove('hidden');
                    institutionsResultsWrapper.classList.add('hidden');
                    cardsResultsWrapper.classList.add('hidden');
                    noResultsMessage.classList.remove('hidden');
                    searchSummary.classList.add('hidden');
                    document.getElementById('searchTermDisplay').textContent = searchTerm;
                    return;
                }

                searchResultsSection.classList.remove('hidden');
                noResultsMessage.classList.add('hidden');
                searchSummary.classList.remove('hidden');

                // Display institutions results
                if (institutions.length > 0) {
                    institutionsResultsWrapper.classList.remove('hidden');
                    document.getElementById('institutionsResultsContainer').innerHTML = institutions.map(inst => `
                        <div class="group">
                            <a href="/institutions/${inst.id}" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition h-full">
                                <div class="bg-gradient-to-br from-blue-500 to-teal-500 h-40 flex items-center justify-center relative overflow-hidden">
                                    <i class="fas fa-building text-6xl text-white opacity-90"></i>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 highlight">${inst.name}</h3>
                                    ${inst.description ? `<p class="text-gray-600 text-sm mb-4 line-clamp-2 highlight">${inst.description}</p>` : ''}
                                    <div class="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition">
                                        <span class="text-sm">Lihat Layanannya</span>
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `).join('');

                    highlightSearchTerms(document.getElementById('institutionsResultsContainer'), searchTerm);
                } else {
                    institutionsResultsWrapper.classList.add('hidden');
                }

                // Display cards results
                if (cards.length > 0) {
                    cardsResultsWrapper.classList.remove('hidden');
                    document.getElementById('cardsResultsContainer').innerHTML = cards.map(card => `
                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition h-full flex flex-col">
                            <div class="bg-gradient-to-br from-teal-500 to-blue-500 h-32 flex items-center justify-center relative overflow-hidden">
                                <i class="fas fa-link text-4xl text-white opacity-80"></i>
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 highlight">${card.title}</h3>
                                ${card.description ? `<p class="text-gray-600 text-sm mb-4 line-clamp-2 highlight">${card.description}</p>` : ''}
                                <div class="flex items-center gap-2 mt-auto mb-3">
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-medium ${card.category.toLowerCase().includes('internal') ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'}">
                                        ${card.category}
                                    </span>
                                </div>
                                <a href="${card.url}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                    Kunjungi <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                            </div>
                        </div>
                    `).join('');

                    highlightSearchTerms(document.getElementById('cardsResultsContainer'), searchTerm);
                } else {
                    cardsResultsWrapper.classList.add('hidden');
                }

                // Update summary
                let internalCount = cards.filter(c => c.category.toLowerCase().includes('internal')).length;
                let externalCount = cards.filter(c => c.category.toLowerCase().includes('external')).length;
                
                document.getElementById('institutionCount').textContent = institutions.length;
                document.getElementById('internalCount').textContent = internalCount;
                document.getElementById('externalCount').textContent = externalCount;
                document.getElementById('totalCount').textContent = totalResults;

                document.getElementById('instCount').textContent = institutions.length;
                document.getElementById('cardCount').textContent = cards.length;
                document.getElementById('resultCount').textContent = `${totalResults} hasil ditemukan`;
            }

            function highlightSearchTerms(container, searchTerm) {
                const elements = container.querySelectorAll('.highlight');
                elements.forEach(el => {
                    const regex = new RegExp(`(${searchTerm})`, 'gi');
                    el.innerHTML = el.textContent.replace(regex, '<mark class="bg-yellow-200 font-semibold">$1</mark>');
                });
            }

            // Event Listeners
            document.getElementById('advancedSearchInput').addEventListener('input', performAdvancedSearch);
            document.getElementById('categoryFilter').addEventListener('change', performAdvancedSearch);

            // Reset search
            function resetSearch() {
                document.getElementById('advancedSearchInput').value = '';
                document.getElementById('categoryFilter').value = '';
                document.getElementById('searchResultsSection').classList.add('hidden');
                document.getElementById('institutionsContainer').style.display = '';
                document.getElementById('cardsContainer').style.display = '';
            }

            // Initialize
            initializeData();

            // Clear results on page load
            window.addEventListener('load', function() {
                document.getElementById('institutionsContainer').style.display = '';
                document.getElementById('cardsContainer').style.display = '';
            });
        </script>
    @else
        <!-- Admin Search Script -->
        <script>
            // Admin Card Search Functionality
            const adminCardSearchInput = document.getElementById('adminCardSearch');
            const cardsTable = document.getElementById('cardsTable');
            const tableRows = cardsTable.querySelectorAll('tbody tr');

            function searchAdminCards() {
                const searchTerm = adminCardSearchInput.value.toLowerCase().trim();
                
                tableRows.forEach(row => {
                    const title = row.querySelector('td:nth-child(1)')?.textContent.toLowerCase() || '';
                    const category = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                    const url = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                    
                    if (title.includes(searchTerm) || category.includes(searchTerm) || url.includes(searchTerm)) {
                        row.style.display = '';
                        
                        // Highlight matching text
                        if (searchTerm) {
                            [row.querySelector('td:nth-child(1)'), row.querySelector('td:nth-child(2)'), row.querySelector('td:nth-child(3)')].forEach(cell => {
                                if (cell) {
                                    const regex = new RegExp(`(${searchTerm})`, 'gi');
                                    cell.innerHTML = cell.textContent.replace(regex, '<mark class="bg-yellow-200 font-semibold">$1</mark>');
                                }
                            });
                        }
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show no results message
                const visibleRows = Array.from(tableRows).filter(row => row.style.display !== 'none');
                let noResultsRow = document.getElementById('noResultsAdminCard');
                
                if (visibleRows.length === 0 && searchTerm) {
                    if (!noResultsRow) {
                        noResultsRow = document.createElement('tr');
                        noResultsRow.id = 'noResultsAdminCard';
                        noResultsRow.innerHTML = `<td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-search text-2xl mb-2"></i>
                            <p class="text-sm">Tidak ada card yang cocok dengan "<strong>${adminCardSearchInput.value}</strong>"</p>
                        </td>`;
                        cardsTable.querySelector('tbody').appendChild(noResultsRow);
                    }
                } else if (noResultsRow) {
                    noResultsRow.remove();
                }
            }

            function resetAdminCardSearch() {
                adminCardSearchInput.value = '';
                tableRows.forEach(row => {
                    row.style.display = '';
                    // Remove highlighting
                    const cells = row.querySelectorAll('td');
                    cells.forEach(cell => {
                        cell.innerHTML = cell.innerText;
                    });
                });
                const noResultsRow = document.getElementById('noResultsAdminCard');
                if (noResultsRow) noResultsRow.remove();
            }

            adminCardSearchInput.addEventListener('input', searchAdminCards);
        </script>
    @endif
@endsection

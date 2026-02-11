@extends('layouts.app')

@section('title', 'Tambah Card Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Tambah Card Baru</h1>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('cards.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="title" class="block text-gray-700 font-medium mb-2">Judul *</label>
                    <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="icon" class="block text-gray-700 font-medium mb-2">Icon (FontAwesome Class)</label>
                    <input type="text" id="icon" name="icon" placeholder="Contoh: fas fa-globe" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('icon') border-red-500 @enderror" value="{{ old('icon') }}">
                    @error('icon')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-gray-700 font-medium mb-2">Gambar Card</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('image') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF | Max: 2MB</p>
                    @error('image')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="category" class="block text-gray-700 font-medium mb-2">Kategori *</label>
                    <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('category') border-red-500 @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="internal" {{ old('category') === 'internal' ? 'selected' : '' }}>Link Internal</option>
                        <option value="external" {{ old('category') === 'external' ? 'selected' : '' }}>Link Eksternal</option>
                    </select>
                    @error('category')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="url" class="block text-gray-700 font-medium mb-2">URL Website *</label>
                    <input type="url" id="url" name="url" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('url') border-red-500 @enderror" value="{{ old('url') }}" required>
                    @error('url')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="order" class="block text-gray-700 font-medium mb-2">Order (Urutan)</label>
                    <input type="number" id="order" name="order" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('order') border-red-500 @enderror" value="{{ old('order', 0) }}">
                    @error('order')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Tambah Card
                    </button>
                    <a href="{{ route('admin.cards') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

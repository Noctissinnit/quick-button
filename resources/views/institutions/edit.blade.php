@extends('layouts.app')

@section('title', 'Edit Institusi')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Edit Institusi</h1>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <h4 class="font-bold mb-2">Terjadi kesalahan:</h4>
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl">
        <form action="{{ route('admin.institutions.update', $institution->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama Institusi *</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name', $institution->name) }}" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-bold mb-2">Keterangan</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $institution->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="link" class="block text-gray-700 font-bold mb-2">Link *</label>
                <input type="url" name="link" id="link" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('link', $institution->link) }}" placeholder="https://example.com" required>
                @error('link')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    Perbarui Institusi
                </button>
                <a href="{{ route('admin.institutions.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

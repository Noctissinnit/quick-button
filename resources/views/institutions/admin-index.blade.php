@extends('layouts.app')

@section('title', 'Admin - Kelola Institusi')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Kelola Institusi</h1>
        <p class="text-gray-600">Manage institusi untuk halaman depan</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('admin.institutions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg inline-flex items-center gap-2 transition">
            <i class="fas fa-plus"></i> Tambah Institusi Baru
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold">Nama Institusi</th>
                    <th class="px-6 py-4 text-left font-semibold">Keterangan</th>
                    <th class="px-6 py-4 text-left font-semibold">Link</th>
                    <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($institutions as $institution)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold">{{ $institution->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $institution->description ? substr($institution->description, 0, 50) . '...' : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ $institution->link }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ substr($institution->link, 0, 40) }}...
                            </a>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.institutions.edit', $institution->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm inline-flex items-center gap-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.institutions.destroy', $institution->id) }}" method="POST" class="inline">
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
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada institusi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

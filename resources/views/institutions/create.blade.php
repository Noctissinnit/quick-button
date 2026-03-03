@extends('layouts.app')

@section('title', 'Tambah Institusi')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Tambah Institusi Baru</h1>
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
        <form action="{{ route('admin.institutions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama Institusi *</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-bold mb-2">Keterangan</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="link" class="block text-gray-700 font-bold mb-2">Link *</label>
                <input type="url" name="link" id="link" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('link') }}" placeholder="https://example.com" required>
                @error('link')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="imageInput" class="block text-gray-700 font-bold mb-2">Gambar Institusi</label>
                <input type="file" id="imageInput" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('croppedImage') border-red-500 @enderror">
                <p class="text-sm text-gray-600 mt-1">Format: JPG, PNG, GIF | Max: 2MB | Aspect Ratio: 16:9</p>
                @error('croppedImage')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Image Preview -->
                <div id="previewContainer" class="mt-4 hidden">
                    <div class="bg-gray-100 rounded-lg overflow-hidden border-2 border-gray-300">
                        <img id="imagePreview" src="" alt="Preview" class="w-full h-auto">
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Preview gambar Anda</p>
                </div>

                <!-- Crop Modal -->
                <div id="cropModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-8 w-full max-w-2xl max-h-screen overflow-auto">
                        <h3 class="text-xl font-bold mb-4">Crop Gambar</h3>
                        <p class="text-sm text-gray-600 mb-4">Sesuaikan gambar agar simetris (16:9)</p>
                        
                        <div class="bg-gray-100 rounded-lg overflow-hidden mb-6">
                            <img id="cropImage" src="" alt="Crop" class="w-full">
                        </div>

                        <div class="flex gap-4">
                            <button type="button" id="cropBtn" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                <i class="fas fa-check mr-2"></i>Crop & Gunakan
                            </button>
                            <button type="button" id="cancelCropBtn" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition">
                                <i class="fas fa-times mr-2"></i>Batal
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hidden input untuk gambar yang sudah di-crop -->
                <input type="hidden" id="croppedImage" name="croppedImage">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    Simpan Institusi
                </button>
                <a href="{{ route('admin.institutions.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Cropper.js Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        let cropper = null;
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('previewContainer');
        const cropModal = document.getElementById('cropModal');
        const cropImage = document.getElementById('cropImage');
        const cropBtn = document.getElementById('cropBtn');
        const cancelCropBtn = document.getElementById('cancelCropBtn');
        const croppedImageInput = document.getElementById('croppedImage');

        // Handle image selection
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                const imageUrl = event.target.result;
                
                // Show preview
                imagePreview.src = imageUrl;
                previewContainer.classList.remove('hidden');

                // Initialize cropper modal
                cropImage.src = imageUrl;
                cropModal.classList.remove('hidden');

                // Destroy previous cropper instance if exists
                if (cropper) {
                    cropper.destroy();
                }

                // Initialize new cropper
                cropper = new Cropper(cropImage, {
                    aspectRatio: 16 / 9,
                    autoCropArea: 1,
                    responsive: true,
                    guides: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: true,
                });
            };
            reader.readAsDataURL(file);
        });

        // Crop and use image
        cropBtn.addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas({
                maxWidth: 1200,
                maxHeight: 675,
                fillColor: '#fff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            // Store cropped image as base64
            const croppedImageBase64 = canvas.toDataURL('image/png');
            croppedImageInput.value = croppedImageBase64;
            
            // Update preview
            imagePreview.src = croppedImageBase64;
            cropModal.classList.add('hidden');
            
            console.log('Image cropped and saved');
        });

        // Cancel crop
        cancelCropBtn.addEventListener('click', function() {
            cropModal.classList.add('hidden');
        });
    </script>
@endsection

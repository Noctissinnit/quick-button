@extends('layouts.app')

@section('title', 'Edit Card')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Edit Card</h1>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('cards.update', $card->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="title" class="block text-gray-700 font-medium mb-2">Judul *</label>
                    <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('title') border-red-500 @enderror" value="{{ old('title', $card->title) }}" required>
                    @error('title')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('description') border-red-500 @enderror">{{ old('description', $card->description) }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="icon" class="block text-gray-700 font-medium mb-2">Icon (FontAwesome Class)</label>
                    <input type="text" id="icon" name="icon" placeholder="Contoh: fas fa-globe" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('icon') border-red-500 @enderror" value="{{ old('icon', $card->icon) }}">
                    @error('icon')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-gray-700 font-medium mb-2">Gambar Card</label>
                    @if($card->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->title }}" class="h-32 w-auto rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-500 mt-2">Gambar saat ini</p>
                        </div>
                    @endif
                    <input type="file" id="imageInput" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('image') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF | Max: 2MB | Aspect Ratio: 16:9</p>
                    @error('image')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
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

                <div class="mb-6">
                    <label for="category" class="block text-gray-700 font-medium mb-2">Kategori *</label>
                    <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('category') border-red-500 @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="internal" {{ old('category', $card->category) === 'internal' ? 'selected' : '' }}>Link Internal</option>
                        <option value="external" {{ old('category', $card->category) === 'external' ? 'selected' : '' }}>Link Eksternal</option>
                    </select>
                    @error('category')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="institution_id" class="block text-gray-700 font-medium mb-2">Institusi (Opsional)</label>
                    <select id="institution_id" name="institution_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('institution_id') border-red-500 @enderror">
                        <option value="">-- Tidak Ada Institusi --</option>
                        @foreach($institutions as $institution)
                            <option value="{{ $institution->id }}" {{ old('institution_id', $card->institution_id) == $institution->id ? 'selected' : '' }}>
                                {{ $institution->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('institution_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="url" class="block text-gray-700 font-medium mb-2">URL Website *</label>
                    <input type="url" id="url" name="url" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('url') border-red-500 @enderror" value="{{ old('url', $card->url) }}" required>
                    @error('url')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="order" class="block text-gray-700 font-medium mb-2">Order (Urutan)</label>
                    <input type="number" id="order" name="order" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('order') border-red-500 @enderror" value="{{ old('order', $card->order) }}">
                    @error('order')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Update Card
                    </button>
                    <a href="{{ route('admin.cards') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                        Batal
                    </a>
                </div>
            </form>
        </div>
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
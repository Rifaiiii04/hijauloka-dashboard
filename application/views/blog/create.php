<?php $this->load->view('includes/sidebar'); ?>

<!-- Main Content -->
<main class="flex-1 ml-64 p-6 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Tulis Artikel Baru</h1>
                <p class="text-gray-500 text-sm mt-1">Buat konten blog baru untuk website Anda</p>
            </div>
            <div class="mt-3 md:mt-0">
                <a href="<?= base_url('blog'); ?>" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm flex items-center shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <p><?= $this->session->flashdata('error'); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Blog Post Form -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <form action="<?= base_url('blog/store'); ?>" method="post" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Main Content Column -->
                        <div class="md:col-span-2">
                            <div class="mb-6">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                                <input type="text" name="title" id="title" required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="Masukkan judul artikel...">
                            </div>
                            
                            <div class="mb-6">
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                                <textarea name="content" id="content" rows="15" required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="Tulis konten artikel di sini..."></textarea>
                            </div>
                            
                            <div class="mb-6">
                                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Ringkasan (Opsional)</label>
                                <textarea name="excerpt" id="excerpt" rows="3"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="Ringkasan singkat artikel..."></textarea>
                                <p class="text-xs text-gray-500 mt-1">Ringkasan akan ditampilkan di halaman daftar artikel. Jika kosong, akan diambil dari konten.</p>
                            </div>
                        </div>
                        
                        <!-- Sidebar Column -->
                        <div>
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <h3 class="font-medium text-gray-700 mb-3">Publikasi</h3>
                                
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" id="status" 
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="published">Published</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors text-sm flex items-center">
                                        <i class="fas fa-save mr-2"></i> Simpan Artikel
                                    </button>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <h3 class="font-medium text-gray-700 mb-3">Kategori</h3>
                                
                                <div class="mb-4">
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kategori</label>
                                    <select name="category_id" id="category_id" 
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <h3 class="font-medium text-gray-700 mb-3">Gambar Utama</h3>
                                
                                <div class="mb-4">
                                    <div class="mb-2 w-full aspect-video bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                        <img id="imagePreview" src="" alt="" class="w-full h-full object-cover hidden">
                                        <div id="placeholderText" class="text-gray-400 flex flex-col items-center">
                                            <i class="fas fa-image text-3xl mb-2"></i>
                                            <span class="text-sm">Pratinjau Gambar</span>
                                        </div>
                                    </div>
                                    
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar</label>
                                    <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maks: 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    // Image preview functionality
    document.getElementById('featured_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = event.target.result;
                imagePreview.classList.remove('hidden');
                document.getElementById('placeholderText').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Initialize CKEditor for rich text editing
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof ClassicEditor !== 'undefined') {
            ClassicEditor
                .create(document.querySelector('#content'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo']
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>

<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
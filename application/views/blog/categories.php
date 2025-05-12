<?php $this->load->view('includes/sidebar'); ?>

<!-- Main Content -->
<main class="flex-1 ml-64 p-6 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Kategori Blog</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola kategori untuk artikel blog</p>
            </div>
            <div class="mt-3 md:mt-0">
                <a href="<?= base_url('blog'); ?>" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm flex items-center shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div id="toast" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg transition-all duration-300 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span><?= $this->session->flashdata('success'); ?></span>
                <button class="ml-4 text-white" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast');
                    if (toast) {
                        toast.classList.add('opacity-0', 'translate-y-[-20px]');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000);
            </script>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div id="toast-error" class="fixed top-4 right-4 z-50 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg transition-all duration-300 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span><?= $this->session->flashdata('error'); ?></span>
                <button class="ml-4 text-white" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-error');
                    if (toast) {
                        toast.classList.add('opacity-0', 'translate-y-[-20px]');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000);
            </script>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Category Form -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <h3 class="font-medium text-gray-700 mb-4">Tambah Kategori Baru</h3>
                    <form action="<?= base_url('blog/create_category'); ?>" method="post">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" name="name" id="name" required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Masukkan nama kategori...">
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors text-sm flex items-center">
                                <i class="fas fa-plus mr-2"></i> Tambah Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Categories List -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden md:col-span-2">
                <div class="p-6">
                    <h3 class="font-medium text-gray-700 mb-4">Daftar Kategori</h3>
                    
                    <?php if (!empty($categories)): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-xs text-gray-500 uppercase border-b border-gray-100">
                                        <th class="px-4 py-3 text-left font-medium">Nama</th>
                                        <th class="px-4 py-3 text-left font-medium">Slug</th>
                                        <th class="px-4 py-3 text-right font-medium">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($categories as $category): ?>
                                        <tr class="hover:bg-gray-50 text-sm transition-colors">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                <?= $category->name ?>
                                            </td>
                                            <td class="px-4 py-3 text-gray-500">
                                                <?= $category->slug ?>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="flex justify-end space-x-2">
                                                    <button onclick="editCategory(<?= $category->id ?>, '<?= $category->name ?>')" 
                                                            class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="Edit Kategori">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    
                                                    <button onclick="confirmDeleteCategory(<?= $category->id ?>)" 
                                                            class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Hapus Kategori">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center">
                            <div class="py-6 flex flex-col items-center">
                                <div class="bg-gray-100 p-4 rounded-full mb-4">
                                    <i class="fas fa-layer-group text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-base font-medium text-gray-800 mb-2">Belum ada kategori</h3>
                                <p class="text-gray-500">Tambahkan kategori pertama Anda</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Edit Category Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-edit text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Kategori</h3>
                        <div class="mt-2">
                            <form id="editCategoryForm" action="<?= base_url('blog/update_category'); ?>" method="post">
                                <input type="hidden" name="id" id="edit_category_id">
                                <div class="mb-4">
                                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                                    <input type="text" name="name" id="edit_name" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        placeholder="Masukkan nama kategori...">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="submitEditForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Simpan
                </button>
                <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Category Confirmation Modal -->
<div id="deleteCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Kategori</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Apakah Anda yakin ingin menghapus kategori ini? Semua artikel yang menggunakan kategori ini akan menjadi tanpa kategori.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="deleteCategoryForm" action="" method="POST">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                </form>
                <button type="button" onclick="closeDeleteCategoryModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Edit category functionality
    function editCategory(id, name) {
        document.getElementById('edit_category_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('editModal').classList.remove('hidden');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    
    function submitEditForm() {
        document.getElementById('editCategoryForm').submit();
    }
    
    // Delete category functionality
    function confirmDeleteCategory(id) {
        document.getElementById('deleteCategoryForm').action = '<?= base_url('blog/delete_category/') ?>' + id;
        document.getElementById('deleteCategoryModal').classList.remove('hidden');
    }
    
    function closeDeleteCategoryModal() {
        document.getElementById('deleteCategoryModal').classList.add('hidden');
    }
    
    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteCategoryModal');
        
        if (event.target === editModal) {
            closeEditModal();
        }
        
        if (event.target === deleteModal) {
            closeDeleteCategoryModal();
        }
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeEditModal();
            closeDeleteCategoryModal();
        }
    });
</script>
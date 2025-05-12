<?php $this->load->view('includes/sidebar'); ?>

<!-- Main Content -->
<main class="flex-1 ml-64 p-6 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <!-- Header with Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Manajemen Blog</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola artikel dan konten blog</p>
            </div>
            <div class="mt-3 md:mt-0 flex items-center space-x-2">
                <a href="<?= base_url('blog/categories'); ?>" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors text-sm flex items-center shadow-sm">
                    <i class="fas fa-layer-group mr-2"></i> Kategori
                </a>
                <a href="<?= base_url('blog/create'); ?>" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 text-sm rounded-lg transition-colors flex items-center shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Tulis Artikel
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
        
        <!-- Search Bar -->
        <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="relative flex-1">
                        <input type="text" 
                            id="searchInput"
                            class="w-full h-10 pl-10 pr-4 rounded-lg bg-gray-50 border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 text-sm" 
                            placeholder="Cari judul artikel...">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button id="searchBtn" class="ml-3 px-5 h-10 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm shadow-sm">
                        Cari
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Blog Posts List -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 class="font-medium text-gray-700">Daftar Artikel</h3>
                <div class="flex space-x-2">
                    <select id="filterCategory" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 bg-gray-50 focus:outline-none focus:ring-1 focus:ring-green-500">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>" <?= ($this->input->get('category') == $category->id) ? 'selected' : '' ?>>
                                <?= $category->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <select id="filterStatus" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 bg-gray-50 focus:outline-none focus:ring-1 focus:ring-green-500">
                        <option value="">Semua Status</option>
                        <option value="published" <?= ($this->input->get('status') == 'published') ? 'selected' : '' ?>>Published</option>
                        <option value="draft" <?= ($this->input->get('status') == 'draft') ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>
            </div>
            
            <?php if (!empty($posts)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase border-b border-gray-100">
                                <th class="px-4 py-3 text-left font-medium">Judul</th>
                                <th class="px-4 py-3 text-left font-medium">Kategori</th>
                                <th class="px-4 py-3 text-left font-medium">Status</th>
                                <th class="px-4 py-3 text-left font-medium">Tanggal</th>
                                <th class="px-4 py-3 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($posts as $post): ?>
                                <tr class="hover:bg-gray-50 text-sm transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <?php if ($post->featured_image): ?>
                                            <div class="w-10 h-10 rounded-md overflow-hidden mr-3 bg-gray-100 flex-shrink-0">
                                                <img src="<?= base_url($post->featured_image) ?>" alt="<?= $post->title ?>" class="w-full h-full object-cover">
                                            </div>
                                        <?php else: ?>
                                            <div class="w-10 h-10 rounded-md overflow-hidden mr-3 bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-file-alt text-gray-400"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <h4 class="font-medium text-gray-900 line-clamp-1"><?= $post->title ?></h4>
                                            <p class="text-xs text-gray-500">Oleh: <?= $post->author_name ?? 'Admin' ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    <?= $post->category_name ?? 'Tanpa Kategori' ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if ($post->status == 'published'): ?>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Published</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    <?= date('d M Y', strtotime($post->created_at)) ?>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="<?= base_url('blog/edit/' . $post->id) ?>" 
                                                class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="Edit Artikel">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- <a href="<?= base_url('blog/preview/' . $post->slug) ?>" target="_blank"
                                                class="p-1.5 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition-colors" title="Preview Artikel">
                                            <i class="fas fa-eye"></i>
                                        </a> -->
                                        
                                        <button onclick="confirmDelete(<?= $post->id ?>)" 
                                                class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Hapus Artikel">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                    <div>
                        Menampilkan <?= count($posts) ?> dari <?= $total_rows ?> artikel
                    </div>
                    
                    <!-- Pagination -->
                    <nav class="pagination">
                        <?php 
                            $current_page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
                            $current_page = $current_page / $per_page + 1;
                            $total_pages = ceil($total_rows / $per_page);
                            
                            if ($total_pages > 1):
                        ?>
                            <div class="inline-flex rounded-lg overflow-hidden shadow-sm">
                                <?php if ($current_page > 1): ?>
                                    <a href="<?= site_url('blog/' . (($current_page - 2) * $per_page)) ?>" 
                                    class="px-3 py-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-sm flex items-center justify-center">&laquo;</a>
                                <?php endif; ?>

                                <?php 
                                    $start_page = max(1, $current_page - 2);
                                    $end_page = min($total_pages, $start_page + 4);
                                    
                                    for ($i = $start_page; $i <= $end_page; $i++): 
                                ?>
                                    <a href="<?= site_url('blog/' . (($i - 1) * $per_page)) ?>" 
                                    class="px-3 py-1.5 <?= ($i == $current_page) ? 'bg-green-500 text-white border-green-500' : 'bg-white hover:bg-gray-50 border-gray-200' ?> border <?= ($i != $start_page) ? 'border-l-0' : '' ?> text-sm flex items-center justify-center">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($current_page < $total_pages): ?>
                                    <a href="<?= site_url('blog/' . ($current_page * $per_page)) ?>" 
                                    class="px-3 py-1.5 bg-white border border-l-0 border-gray-200 hover:bg-gray-50 text-sm flex items-center justify-center">&raquo;</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php else: ?>
                <div class="p-8 text-center">
                    <div class="py-6 flex flex-col items-center">
                        <div class="bg-gray-100 p-4 rounded-full mb-4">
                            <i class="fas fa-newspaper text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-base font-medium text-gray-800 mb-2">Belum ada artikel</h3>
                        <p class="text-gray-500">Mulai menulis artikel pertama Anda sekarang</p>
                        <a href="<?= base_url('blog/create'); ?>" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 text-sm rounded-lg transition-colors flex items-center shadow-sm">
                            <i class="fas fa-plus mr-2"></i> Tulis Artikel
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
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
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Artikel</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="deleteForm" action="" method="POST">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Search functionality
    document.getElementById('searchBtn').addEventListener('click', function() {
        const searchTerm = document.getElementById('searchInput').value;
        if (searchTerm.trim() !== '') {
            window.location.href = '<?= base_url('blog') ?>?search=' + encodeURIComponent(searchTerm);
        }
    });
    
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('searchBtn').click();
        }
    });
    
    // Filter functionality
    document.getElementById('filterCategory').addEventListener('change', function() {
        applyFilters();
    });
    
    document.getElementById('filterStatus').addEventListener('change', function() {
        applyFilters();
    });
    
    function applyFilters() {
        const category = document.getElementById('filterCategory').value;
        const status = document.getElementById('filterStatus').value;
        const searchTerm = new URLSearchParams(window.location.search).get('search') || '';
        
        let url = '<?= base_url('blog') ?>?';
        let params = [];
        
        if (category) {
            params.push('category=' + category);
        }
        
        if (status) {
            params.push('status=' + status);
        }
        
        if (searchTerm) {
            params.push('search=' + encodeURIComponent(searchTerm));
        }
        
        window.location.href = url + params.join('&');
    }
    
    // Delete confirmation
    function confirmDelete(id) {
        document.getElementById('deleteForm').action = '<?= base_url('blog/delete/') ?>' + id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Initialize search input with current search term
    document.addEventListener('DOMContentLoaded', function() {
        const searchTerm = new URLSearchParams(window.location.search).get('search');
        if (searchTerm) {
            document.getElementById('searchInput').value = searchTerm;
        }
    });
</script>
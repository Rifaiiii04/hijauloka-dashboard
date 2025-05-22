<?php $this->load->view('includes/sidebar'); ?>

<style>
.toggle-checkbox {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 24px;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.toggle-checkbox:checked + .toggle-slider {
    background-color: #08644C;
}

.toggle-checkbox:checked + .toggle-slider:before {
    transform: translateX(24px);
}

/* New styles for modern UI */
.main-content {
    background-color: #f9fafb;
    min-height: 100vh;
}

.content-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
}

.search-input {
    background-color: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.625rem 1rem;
    padding-left: 2.5rem;
    width: 100%;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #08644C;
    box-shadow: 0 0 0 3px rgba(8, 100, 76, 0.1);
}

.search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.btn-primary {
    background-color: #08644C;
    color: white;
    padding: 0.625rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary:hover {
    background-color: #064c3a;
}

.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern th {
    background-color: #f3f4f6;
    padding: 1rem;
    font-weight: 600;
    text-align: left;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.table-modern td {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    color: #4b5563;
}

.table-modern tr:hover {
    background-color: #f9fafb;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge.stock-good {
    background-color: #dcfce7;
    color: #166534;
}

.status-badge.stock-warning {
    background-color: #fef3c7;
    color: #92400e;
}

.status-badge.stock-empty {
    background-color: #fee2e2;
    color: #991b1b;
}

.action-btn {
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.action-btn.edit {
    color: #2563eb;
}

.action-btn.edit:hover {
    background-color: #eff6ff;
}

.action-btn.delete {
    color: #dc2626;
}

.action-btn.delete:hover {
    background-color: #fef2f2;
}

.modal-overlay {
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.modal-content {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    max-width: 32rem;
    width: 100%;
    margin: 1rem;
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.modal-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.625rem 0.75rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #08644C;
    box-shadow: 0 0 0 3px rgba(8, 100, 76, 0.1);
}

.image-preview {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.image-preview img {
    width: 5rem;
    height: 5rem;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
}

.pagination a {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    color: #4b5563;
    transition: all 0.2s;
}

.pagination a:hover {
    background-color: #f3f4f6;
}

.pagination .active {
    background-color: #08644C;
    color: white;
}

.form-group:hover label[style*="display: none"] {
    display: flex !important;
    opacity: 1 !important;
}
</style>

<main class="flex-1 ml-64 p-6 overflow-auto main-content">
    <div class="content-card p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Produk</h2>
            
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Cari produk..." class="search-input">
                </div>
                <button onclick="tambahProduk()" class="btn-primary flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Produk</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th>Video</th>
                        <th>Featured</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <?php $no = 1; foreach ($produk as $p): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="font-medium"><?= $p->nama_product; ?></td>
                        <td>
                            <span class="status-badge stock-good">
                                <?= $p->nama_kategori; ?>
                            </span>
                        </td>
                        <td>Rp <?= number_format($p->harga, 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($p->stok <= 0): ?>
                                <span class="status-badge stock-empty">Habis</span>
                            <?php elseif ($p->stok <= 10): ?>
                                <span class="status-badge stock-warning"><?= $p->stok ?></span>
                            <?php else: ?>
                                <span class="status-badge stock-good"><?= $p->stok ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="image-preview">
                                <?php 
                                $gambarArr = explode(',', $p->gambar);
                                foreach ($gambarArr as $gmbr): ?>
                                    <img src="<?= base_url('uploads/' . trim($gmbr)); ?>" alt="Product Image">
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td>
                            <?php if (!empty($p->cara_rawat_video)): ?>
                                <a href="<?= base_url('uploads/videos/' . $p->cara_rawat_video); ?>" target="_blank" class="text-blue-500 hover:underline flex items-center">
                                    <i class="fas fa-video mr-1"></i> Lihat Video
                                </a>
                            <?php else: ?>
                                <span class="text-gray-400">Tidak ada video</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button 
                                onclick="toggleFeatured(<?= $p->id_product ?>, this)"
                                data-featured="<?= isset($p->featured_position) ? '1' : '0' ?>"
                                class="w-full px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 ease-in-out <?= isset($p->featured_position) ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
                                <?= isset($p->featured_position) ? 'Featured (Position: ' . $p->featured_position . ')' : 'Not Featured' ?>
                            </button>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <button onclick="editProduk(<?= $p->id_product; ?>)" class="action-btn edit">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <button onclick="hapusProduk(<?= $p->id_product; ?>)" class="action-btn delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</main>

<!-- Keep existing modal HTML structure but add new classes -->
<div id="modalProduk" class="fixed inset-0 modal-overlay flex items-center justify-center hidden " style="overflow: scroll;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="text-xl font-bold text-gray-800" id="modalTitle">Tambah Produk</h2>
        </div>
        <form id="produkForm" action="<?= base_url('produk/store') ?>" method="POST" enctype="multipart/form-data" class="modal-body">
            <!-- Keep existing form structure but add new classes -->
            <input type="hidden" name="id_product" id="id_product">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_product" id="nama_product" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="desk_product" id="desk_product" class="form-input" rows="3" required></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <div class="space-y-2">
                        <?php foreach ($kategori as $k): ?>
                        <label class="inline-flex items-center mr-4">
                            <input type="checkbox" name="id_kategori[]" value="<?= $k->id_kategori; ?>" class="form-checkbox">
                            <span class="ml-2"><?= $k->nama_kategori; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Gambar (minimal 1, maksimal 5)</label>
                <input type="file" name="gambar[]" class="form-input" multiple required>
            </div>

            <div class="form-group">
                <label class="form-label">Video Cara Merawat (opsional)</label>
                <input type="file" name="cara_rawat_video" class="form-input" accept="video/mp4,video/x-m4v,video/*">
                <small class="text-gray-500">Format yang didukung: MP4, MOV, AVI (maks. 50MB)</small>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Produk -->
<div id="modalEditProduk" class="fixed inset-0 flex items-center justify-center hidden overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-4 my-16">
        <h2 class="text-xl font-bold mb-4">Edit Produk</h2>
        <form id="editProdukForm" action="<?= base_url('produk/update') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_product" id="edit_id_product">
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block">Nama Produk</label>
                    <input type="text" name="nama_product" id="edit_nama_product" class="w-full border p-2 rounded-lg" required>
                </div>
                <div>
                    <label class="block">Harga</label>
                    <input type="number" name="harga" id="edit_harga" class="w-full border p-2 rounded-lg" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block">Deskripsi</label>
                <textarea name="desk_product" id="edit_desk_product" class="w-full border p-2 rounded-lg" required></textarea>
            </div>
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                <label class="block">Kategori</label>
    <?php foreach ($kategori as $k): ?>
        <label class="inline-flex items-center mr-4">
            <input type="checkbox" name="id_kategori[]" value="<?= $k->id_kategori; ?>" class="form-checkbox">
            <span class="ml-2"><?= $k->nama_kategori; ?></span>
        </label>
    <?php endforeach; ?>
                </div>
                <div>
                    <label class="block">Stok</label>
                    <input type="number" name="stok" id="edit_stok" class="w-full border p-2 rounded-lg" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block">Gambar (minimal 1, maksimal 5)</label>
                <input type="file" name="gambar[]" class="w-full border p-2 rounded-lg" multiple>
                <!-- Simpan nama file lama dalam format comma separated -->
                <input type="hidden" name="gambar_lama" id="edit_gambar_lama">
            </div>
            
            <div class="mb-4">
                <label class="block">Video Cara Merawat (opsional)</label>
                <input type="file" name="cara_rawat_video" class="w-full border p-2 rounded-lg" accept="video/mp4,video/x-m4v,video/*">
                <small class="text-gray-500">Format yang didukung: MP4, MOV, AVI (maks. 50MB)</small>
                <div id="current_video_container" class="mt-2 hidden">
                    <p class="text-sm font-medium">Video saat ini:</p>
                    <p id="current_video_name" class="text-sm text-gray-600"></p>
                </div>
                <input type="hidden" name="video_lama" id="edit_video_lama">
            </div>
            
            <div class="text-right">
                <button type="button" onclick="closeModalEdit()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function tambahProduk() {
        document.getElementById('produkForm').reset();
        document.getElementById('modalTitle').innerText = "Tambah Produk";
        document.getElementById('produkForm').action = "<?= base_url('produk/store') ?>";
        document.getElementById('modalProduk').classList.remove('hidden');
    }

    function editProduk(id) {
        console.log("Memanggil editProduk dengan ID:", id);
        fetch("<?= base_url('produk/edit/') ?>" + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error! Status: " + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log("Data dari server:", data);
                if (!data.produk) {
                    alert("Data produk tidak ditemukan!");
                    return;
                }
                document.getElementById('edit_id_product').value = data.produk.id_product;
                document.getElementById('edit_nama_product').value = data.produk.nama_product;
                document.getElementById('edit_desk_product').value = data.produk.desk_product;
                document.getElementById('edit_harga').value = data.produk.harga;
                document.getElementById('edit_stok').value = data.produk.stok;
                document.getElementById('edit_gambar_lama').value = data.produk.gambar;
                
                // Handle video data
                if (data.produk.cara_rawat_video) {
                    document.getElementById('edit_video_lama').value = data.produk.cara_rawat_video;
                    document.getElementById('current_video_name').textContent = data.produk.cara_rawat_video;
                    document.getElementById('current_video_container').classList.remove('hidden');
                } else {
                    document.getElementById('current_video_container').classList.add('hidden');
                }

                let kategoriCheckboxes = document.querySelectorAll('input[name="id_kategori[]"]');
                kategoriCheckboxes.forEach(checkbox => {
                    checkbox.checked = data.selected_categories.includes(checkbox.value);
                });

                document.getElementById('modalEditProduk').classList.remove('hidden');
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                alert("Terjadi kesalahan saat mengambil data produk.");
            });
    }


    function hapusProduk(id) {
        if (confirm('Yakin ingin menghapus produk ini?')) {
            window.location.href = "<?= base_url('produk/delete/') ?>" + id;
        }
    }

    function closeModal() {
        document.getElementById('modalProduk').classList.add('hidden');
    }

    function closeModalEdit() {
        document.getElementById('modalEditProduk').classList.add('hidden');
    }


// Add this new search function
document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const tableBody = document.getElementById('productTableBody');
    const rows = tableBody.getElementsByTagName('tr');

    for (let row of rows) {
        const namaProduk = row.getElementsByTagName('td')[1].textContent.toLowerCase();
        const kategori = row.getElementsByTagName('td')[2].textContent.toLowerCase();
        
        if (namaProduk.includes(searchValue) || kategori.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});

// Restore the toggleFeatured function
function toggleFeatured(productId, button) {
    const isFeatured = button.getAttribute('data-featured') === '1';
    const action = isFeatured ? 'remove_featured' : 'make_featured';
    
    fetch(`<?= base_url('produk/') ?>${action}/${productId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button without page reload
            button.setAttribute('data-featured', isFeatured ? '0' : '1');
            button.className = `w-full px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 ease-in-out ${isFeatured ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-green-500 text-white hover:bg-green-600'}`;
            button.textContent = isFeatured ? 'Not Featured' : 'Featured';
            window.location.reload(); // Reload to update positions
        } else {
            alert(data.message || 'Gagal mengubah status featured');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah status featured');
    });
}
</script>


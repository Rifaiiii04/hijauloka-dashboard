<?php $this->load->view('includes/sidebar'); ?>

<main class="flex-1 ml-64 p-6 overflow-auto">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kategori</h1>
        <p class="text-gray-600">Kelola kategori produk HijauLoka</p>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <!-- Action Bar -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="Cari kategori..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <button onclick="tambahKategori()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-300 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Kategori</span>
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $no = 1; foreach ($kategori as $k): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $no++; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?= $k->nama_kategori; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button onclick="editKategori(<?= $k->id_kategori; ?>)" 
                                    class="text-blue-600 hover:text-blue-900 mr-3 transition-colors duration-200">
                                <i class="fas fa-pen-to-square"></i>
                            </button>
                            <button onclick="hapusKategori(<?= $k->id_kategori; ?>)" 
                                    class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal -->
<div id="modalKategori" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800" id="modalTitle">Tambah Kategori</h2>
        </div>
        
        <!-- Modal Body -->
        <form id="kategoriForm" method="POST" action="<?= base_url('kategori/store'); ?>" class="p-6">
            <input type="hidden" name="id_kategori" id="id_kategori">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" 
                       name="nama_kategori" 
                       id="nama_kategori" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                       required>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" 
                        onclick="closeModal()" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function tambahKategori() {
        document.getElementById('kategoriForm').reset();
        document.getElementById('modalTitle').innerText = 'Tambah Kategori';
        document.getElementById('modalKategori').classList.remove('hidden');
    }

    function editKategori(id) {
        fetch(`<?= base_url('kategori/edit/') ?>${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id_kategori').value = data.id_kategori;
                document.getElementById('nama_kategori').value = data.nama_kategori;
                document.getElementById('modalTitle').innerText = 'Edit Kategori';
                document.getElementById('modalKategori').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('modalKategori').classList.add('hidden');
    }

    function hapusKategori(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            window.location.href = `<?= base_url('kategori/delete/') ?>${id}`;
        }
    }

    // Close modal when clicking outside
    document.getElementById('modalKategori').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>

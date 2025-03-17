<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Produk</h2>
        <div class="overflow-x-auto">
            <table class="w-full max-h-64 border-collapse border border-gray-300 text-center">
                <thead class="bg-green-500">
                    <tr>
                        <th class="border border-gray-300 p-2 text-white">No</th>
                        <th class="border border-gray-300 p-2 text-white">Nama</th>
                        <th class="border border-gray-300 p-2 text-white">Deskripsi</th>
                        <th class="border border-gray-300 p-2 text-white">Kategori</th>
                        <th class="border border-gray-300 p-2 text-white">Harga</th>
                        <th class="border border-gray-300 p-2 text-white">Stok</th>
                        <th class="border border-gray-300 p-2 text-white">Gambar</th>
                        <th class="border border-gray-300 p-2 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($produk as $p): ?>
                    <tr class="hover:bg-gray-100 max-h-14">
                        <td class="border border-gray-300 p-2"><?= $no++; ?></td>
                        <td class="border border-gray-300 p-2"><?= $p->nama_product; ?></td>
                        <td class="border border-gray-300 p-2 max-w-32"><?= $p->desk_product; ?></td>
                        <td class="border border-gray-300 p-2"><?= $p->nama_kategori; ?></td>
                        <td class="border border-gray-300 p-2">Rp <?= number_format($p->harga, 2, ',', '.'); ?></td>
                        <td class="border border-gray-300 p-2"><?= $p->stok; ?></td>
                        <td class="border border-gray-300 p-2">
                            <img src="<?= base_url('uploads/' . $p->gambar); ?>" class="w-16 h-16">
                        </td>
                        <td class="border border-gray-300 p-2">
                            <button onclick="editProduk(<?= $p->id_product; ?>)" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">Edit</button>
                            <button onclick="hapusProduk(<?= $p->id_product; ?>)" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 ml-2">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-10 text-right">
            <button onclick="tambahProduk()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">+ Tambah Produk</button>
        </div>
    </div>
</main>

<!-- Modal Tambah/Edit Produk -->
<div id="modalProduk" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Tambah Produk</h2>
        <form id="produkForm" action="<?= base_url('produk/store') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_product" id="id_product">
            <div class="mb-4">
                <label class="block">Nama Produk</label>
                <input type="text" name="nama_product" id="nama_product" class="w-full border p-2 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block">Deskripsi</label>
                <textarea name="desk_product" id="desk_product" class="w-full border p-2 rounded-lg" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block">Kategori</label>
                <select name="id_kategori" id="id_kategori" class="w-full border p-2 rounded-lg" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k->id_kategori; ?>"><?= $k->nama_kategori; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block">Harga</label>
                <input type="number" name="harga" id="harga" class="w-full border p-2 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block">Stok</label>
                <input type="number" name="stok" id="stok" class="w-full border p-2 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block">Gambar</label>
                <input type="file" name="gambar" class="w-full border p-2 rounded-lg">
            </div>
            <div class="text-right">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Produk -->
<div id="modalEditProduk" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Edit Produk</h2>
        <form id="editProdukForm" action="<?= base_url('produk/update') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_product" id="edit_id_product">
            <div class="mb-4">
                <label class="block">Nama Produk</label>
                <input type="text" name="nama_product" id="edit_nama_product" class="w-full border p-2 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block">Deskripsi</label>
                <textarea name="desk_product" id="edit_desk_product" class="w-full border p-2 rounded-lg" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block">Kategori</label>
                <select name="id_kategori" id="edit_id_kategori" class="w-full border p-2 rounded-lg" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k->id_kategori; ?>"><?= $k->nama_kategori; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block">Harga</label>
                <input type="number" name="harga" id="edit_harga" class="w-full border p-2 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block">Stok</label>
                <input type="number" name="stok" id="edit_stok" class="w-full border p-2 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block">Gambar</label>
                <input type="file" name="gambar" class="w-full border p-2 rounded-lg">
                <input type="hidden" name="gambar_lama" id="edit_gambar_lama">
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
        fetch(`<?= base_url('produk/edit/') ?>${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').innerText = "Edit Produk";
                document.getElementById('produkForm').action = "<?= base_url('produk/update') ?>";
                document.getElementById('id_product').value = data.id_product;
                document.getElementById('nama_product').value = data.nama_product;
                document.getElementById('desk_product').value = data.desk_product;
                document.getElementById('id_kategori').value = data.id_kategori;
                document.getElementById('harga').value = data.harga;
                document.getElementById('stok').value = data.stok;
                document.getElementById('modalProduk').classList.remove('hidden');
            });
    }

    function hapusProduk(id) {
        if (confirm('Yakin ingin menghapus produk ini?')) {
            window.location.href = `<?= base_url('produk/delete/') ?>${id}`;
        }
    }

    function closeModal() {
        document.getElementById('modalProduk').classList.add('hidden');
    }

    function editProduk(id) {
        fetch("<?= base_url('produk/edit/') ?>" + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_id_product').value = data.produk.id_product;
                document.getElementById('edit_nama_product').value = data.produk.nama_product;
                document.getElementById('edit_desk_product').value = data.produk.desk_product;
                document.getElementById('edit_id_kategori').value = data.produk.id_kategori;
                document.getElementById('edit_harga').value = data.produk.harga;
                document.getElementById('edit_stok').value = data.produk.stok;
                document.getElementById('edit_gambar_lama').value = data.produk.gambar;
                document.getElementById('modalEditProduk').classList.remove('hidden');
            });
    }

    function closeModalEdit() {
        document.getElementById('modalEditProduk').classList.add('hidden');
    }
    
</script>

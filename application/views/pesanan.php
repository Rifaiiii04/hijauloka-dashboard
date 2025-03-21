<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Tambahkan di bagian atas halaman -->
<?php if($this->session->flashdata('error')): ?>
<div class="bg-red-100 border border-red-400 px-4 py-3 rounded mb-4">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>
<!-- Konten Utama -->
<main class="flex-1 ml-64 p-6 overflow-auto">
    <!-- Tabel Pesanan -->
    <div class="mt-10 bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Daftar Pesanan</h2>
            <button onclick="openModal()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah Pesanan</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
               <!-- Tambahkan Kolom Produk di Tabel -->
<thead class="bg-green-500">
    <tr>
        <th class="border border-gray-300 p-2 text-white">No</th>
        <th class="border border-gray-300 p-2 text-white">Nama Pelanggan</th>
        <th class="border border-gray-300 p-2 text-white">Produk</th>
        <th class="border border-gray-300 p-2 text-white">Tanggal Pesan</th>
        <th class="border border-gray-300 p-2 text-white">Total Harga</th>
        <th class="border border-gray-300 p-2 text-white">Status</th>
        <th class="border border-gray-300 p-2 text-white">Tanggal Dikirim</th>
        <th class="border border-gray-300 p-2 text-white">Tanggal Selesai</th>
        <th class="border border-gray-300 p-2 text-white">Tanggal Batal</th>
        <th class="border border-gray-300 p-2 text-white">Aksi</th>
    </tr>
</thead>

<tbody>
    <?php if (!empty($pesanan)): ?>
        <?php $no = 1; foreach ($pesanan as $p): ?>
            <tr class="hover:bg-gray-100">
                <td class="border border-gray-300 p-2"><?= $no++; ?></td>
                <td class="border border-gray-300 p-2"><?= $p->nama_pelanggan ?? 'N/A'; ?></td>
                <td class="border border-gray-300 p-2">
                    <?php if (!empty($p->produk)): ?>
                        <ul>
                            <?php foreach ($p->produk as $prod): ?>
                                <li><?= $prod->nama_produk ?? 'N/A'; ?> (<?= $prod->quantity ?? 0; ?> pcs) - Rp<?= number_format($prod->subtotal ?? 0, 0, ',', '.'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <span>Tidak ada produk</span>
                    <?php endif; ?>
                </td>
                <td class="border border-gray-300 p-2"><?= date('d-m-Y H:i', strtotime($p->tgl_pemesanan)) ?></td>
                <td class="border border-gray-300 p-2">Rp<?= number_format($p->total_harga ?? 0, 0, ',', '.'); ?></td>
                <td class="border border-gray-300 p-2"><?= ucfirst($p->stts_pemesanan ?? 'pending'); ?></td>
                <td class="border border-gray-300 p-2"><?= $p->tgl_dikirim ? date('d-m-Y H:i', strtotime($p->tgl_dikirim)) : '-' ?></td>
                <td class="border border-gray-300 p-2"><?= $p->tgl_selesai ? date('d-m-Y H:i', strtotime($p->tgl_selesai)) : '-' ?></td>
                <td class="border border-gray-300 p-2"><?= $p->tgl_batal ? date('d-m-Y H:i', strtotime($p->tgl_batal)) : '-' ?></td>
                <td class="border border-gray-300 p-2">
                    <!-- Tombol Edit -->
                    <button onclick="openEditModal('<?= $p->id_order ?>')" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">Edit</button>
                    <!-- Tombol Hapus -->
                    <a href="<?= site_url('pesanan/delete/'. ($p->id_order ?? '')); ?>" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 ml-2" onclick="return confirm('Hapus pesanan ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="10" class="text-center py-4">Tidak ada pesanan.</td>
        </tr>
    <?php endif; ?>
</tbody>

            </table>
        </div>
    </div>
</main>

<!-- Modal Tambah Pesanan -->
<div id="modalPesanan" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Tambah Pesanan</h2>
        <form id="formTambahPesanan" action="<?= site_url('pesanan/create'); ?>" method="POST">
            <input type="hidden" name="id_admin" value="1">
            
            <!-- Field Pelanggan -->
            <label class="block mb-2">Nama Pelanggan</label>
            <select name="id_user" class="w-full border p-2 rounded mb-3" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user->id_user; ?>"><?= $user->nama; ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Daftar Produk (Dinamis) -->
            <div id="produkContainer">
                <div class="produk-item mb-3">
                    <label class="block mb-2">Produk</label>
                    <select name="produk[]" class="w-full border p-2 rounded mb-2" required>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product->id_product; ?>">
                                <?= $product->nama_product ?> - Rp<?= number_format($product->harga, 0, ',', '.'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label class="block mb-2">Jumlah</label>
                    <input type="number" name="jumlah[]" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <!-- Tombol Tambah Produk -->
            <button type="button" onclick="tambahProduk()" class="bg-blue-500 text-white px-3 py-1 rounded-md mb-3">
                + Tambah Produk
            </button>

            <!-- Status -->
            <label class="block mb-2">Status</label>
            <select name="stts_pemesanan" class="w-full border p-2 rounded mb-3">
                <option value="pending">Pending</option>
                <option value="diproses">Diproses</option>
                <option value="dikirim">Dikirim</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class=" text-white px-4 py-2 rounded-md" style="background-color: red;">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditPesanan" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Edit Status Pesanan</h2>
        <form id="editForm" method="POST">
            <input type="hidden" name="id_order" id="edit_id_order">
            
            <!-- Dropdown Status -->
            <label class="block mb-2">Status</label>
            <select name="stts_pemesanan" id="edit_status" class="w-full border p-2 rounded mb-3">
                <option value="pending">Pending</option>
                <option value="diproses">Diproses</option>
                <option value="dikirim">Dikirim</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-white rounded-md" style="background-color: red;">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk menambah field produk
    function tambahProduk() {
        const container = document.getElementById('produkContainer');
        const newItem = document.createElement('div');
        newItem.className = 'produk-item mb-3';
        newItem.innerHTML = `
            <label class="block mb-2">Produk</label>
            <select name="produk[]" class="w-full border p-2 rounded mb-2" required>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product->id_product; ?>">
                        <?= $product->nama_product ?> - Rp<?= number_format($product->harga, 0, ',', '.'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label class="block mb-2">Jumlah</label>
            <input type="number" name="jumlah[]" class="w-full border p-2 rounded" required>
            <button type="button" onclick="hapusProduk(this)" class="bg-red-500 text-white px-2 py-1 rounded-md mt-2">Hapus</button>
        `;
        container.appendChild(newItem);
    }

    // Fungsi untuk menghapus field produk
    function hapusProduk(button) {
        button.closest('.produk-item').remove();
    }

    function openModal() {
    document.getElementById('modalPesanan').classList.remove('hidden');
}

document.getElementById('formTambahPesanan').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('<?= site_url('pesanan/create') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            window.location.reload(); // Reload jika sukses
        } else {
            alert('Gagal menyimpan pesanan!');
        }
    });
});

// Fungsi untuk menutup modal tambah pesanan
function closeModal() {
    document.getElementById('modalPesanan').classList.add('hidden');
}

     // Fungsi untuk membuka modal edit
     function openEditModal(id_order) {
        fetch(`<?= site_url('pesanan/get_status/') ?>${id_order}`)
            .then(response => {
                if (!response.ok) throw new Error("Gagal mengambil data");
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_id_order').value = id_order;
                document.getElementById('edit_status').value = data.stts_pemesanan;
                document.getElementById('modalEditPesanan').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data pesanan!');
            });
    }

    // Fungsi untuk menutup modal edit
    function closeEditModal() {
        document.getElementById('modalEditPesanan').classList.add('hidden');
    }

    // Submit form edit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch(`<?= site_url('pesanan/update') ?>`, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error("Update gagal");
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memperbarui status!');
        });
    });
</script>


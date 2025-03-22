<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Flashdata Alert -->
<?php if($this->session->flashdata('error')): ?>
    <script>
        alert("<?= $this->session->flashdata('error'); ?>");
    </script>
<?php endif; ?>
<?php if($this->session->flashdata('success')): ?>
    <script>
        alert("<?= $this->session->flashdata('success'); ?>");
    </script>
<?php endif; ?>

<!-- Konten Utama -->
<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-800">Daftar Pesanan</h1>
        <button onclick="openModal()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Pesanan
        </button>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
                <thead class="bg-green-500">
                    <tr>
                        <th class="border border-gray-300 p-2 text-white">No</th>
                        <th class="border border-gray-300 p-2 text-white">Nama Pelanggan</th>
                        <th class="border border-gray-300 p-2 text-white">Produk</th>
                        <th class="border border-gray-300 p-2 text-white">Tanggal Pesan</th>
                        <th class="border border-gray-300 p-2 text-white">Total Harga</th>
                        <th class="border border-gray-300 p-2 text-white">Status Pesanan</th>
                        <th class="border border-gray-300 p-2 text-white">Status Pembayaran</th>
                        <th class="border border-gray-300 p-2 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pesanan)): ?>
                        <?php $no = 1; foreach ($pesanan as $p): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 p-2"><?= $no++; ?></td>
                                <td class="border border-gray-300 p-2"><?= isset($p->nama_pelanggan) ? $p->nama_pelanggan : 'N/A'; ?></td>
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
                                <td class="border border-gray-300 p-2"><?= date('d-m-Y H:i', strtotime($p->tgl_pemesanan)); ?></td>
                                <td class="border border-gray-300 p-2">Rp<?= number_format($p->total_harga ?? 0, 0, ',', '.'); ?></td>
                                <td class="border border-gray-300 p-2"><?= ucfirst($p->stts_pemesanan ?? 'pending'); ?></td>
                                <td class="border border-gray-300 p-2">
                                    <span class="px-2 py-1 rounded-full <?php echo ($p->stts_pembayaran === 'lunas') ? 'bg-green-500 text-white' : 'bg-red-500 text-white'; ?>">
                                        <?= htmlspecialchars($p->stts_pembayaran); ?>
                                    </span>
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <button onclick="openEditModal('<?= $p->id_order; ?>')" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
                                        Edit
                                    </button>
                                    <a href="<?= site_url('pesanan/delete/' . $p->id_order); ?>" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 ml-2" onclick="return confirm('Hapus pesanan ini?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="border border-gray-300 p-2 text-center">Tidak ada pesanan.</td>
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
            <input type="hidden" name="id_admin" value="<?= $this->session->userdata('id_admin'); ?>">
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
            <!-- Status Pesanan & Pembayaran -->
            <label class="block mb-2">Status Pesanan</label>
            <select name="stts_pemesanan" class="w-full border p-2 rounded mb-3" required>
                <option value="pending">Pending</option>
                <option value="diproses">Diproses</option>
                <option value="dikirim">Dikirim</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
            <label class="block mb-2">Status Pembayaran</label>
            <select name="stts_pembayaran" class="w-full border p-2 rounded mb-3" required>
                <option value="belum_dibayar">Belum Dibayar</option>
                <option value="lunas">Lunas</option>
            </select>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Status Pesanan -->
<div id="modalEditPesanan" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Edit Status Pesanan</h2>
        <form id="editForm" method="POST" action="<?= site_url('pesanan/update_status'); ?>">
            <input type="hidden" name="id_order" id="edit_id_order">
            <label class="block mb-2">Status Pesanan</label>
            <select name="stts_pemesanan" id="edit_status" class="w-full border p-2 rounded mb-3" required>
                <option value="pending">Pending</option>
                <option value="diproses">Diproses</option>
                <option value="dikirim">Dikirim</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
            <label class="block mb-2">Status Pembayaran</label>
            <select name="stts_pembayaran" id="edit_status_pembayaran" class="w-full border p-2 rounded mb-3" required>
                <option value="belum_dibayar">Belum Dibayar</option>
                <option value="lunas">Lunas</option>
            </select>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</button>
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

    function hapusProduk(button) {
        button.closest('.produk-item').remove();
    }

    function openModal() {
        document.getElementById('modalPesanan').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalPesanan').classList.add('hidden');
    }

    function openEditModal(id_order) {
        fetch("<?= site_url('pesanan/get_status/') ?>" + id_order)
            .then(response => {
                if (!response.ok) throw new Error("Gagal mengambil data");
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_id_order').value = id_order;
                document.getElementById('edit_status').value = data.stts_pemesanan;
                document.getElementById('edit_status_pembayaran').value = data.stts_pembayaran;
                document.getElementById('modalEditPesanan').classList.remove('hidden');
            })
            .catch(error => {
                console.error("Error fetching order data:", error);
                alert("Gagal memuat data pesanan!");
            });
    }

    function closeEditModal() {
        document.getElementById('modalEditPesanan').classList.add('hidden');
    }
</script>

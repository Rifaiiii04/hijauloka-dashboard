<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Alert Flashdata -->
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
        <h1 class="text-3xl font-extrabold text-gray-800">Dashboard Transaksi</h1>
        <!-- Tombol Tambah Transaksi -->
        <button onclick="openTransaksiModal()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Transaksi
        </button>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
                <thead style="background-color: #007bff;">
                    <tr>
                        <th class="border border-gray-300 p-2 text-white">ID Transaksi</th>
                        <th class="border border-gray-300 p-2 text-white">Tanggal</th>
                        <th class="border border-gray-300 p-2 text-white">Nama Pelanggan</th>
                        <th class="border border-gray-300 p-2 text-white">Total Bayar</th>
                        <th class="border border-gray-300 p-2 text-white">Status Pembayaran</th>
                        <th class="border border-gray-300 p-2 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transaksi)) : ?>
                        <?php $no = 1; foreach ($transaksi as $t): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 p-2"><?= isset($t->id_transaksi) ? $t->id_transaksi : $t->id_order; ?></td>
                                <td class="border border-gray-300 p-2">
                                    <?= !empty($t->tanggal_transaksi) ? date('d M Y', strtotime($t->tanggal_transaksi)) : 'Tanggal tidak tersedia'; ?>
                                </td>
                                <td class="border border-gray-300 p-2"><?= isset($t->nama_pelanggan) ? $t->nama_pelanggan : 'Tidak diketahui'; ?></td>
                                <td class="border border-gray-300 p-2">
                                    <?= !empty($t->total_bayar) ? 'Rp ' . number_format($t->total_bayar, 0, ',', '.') : 'Total tidak tersedia'; ?>
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <?php 
                                        $status = !empty($t->status_pembayaran) ? $t->status_pembayaran : 'Tidak tersedia';
                                        $status_class = ($status === 'lunas') ? 'bg-green-500 text-white' : 'bg-red-500 text-white';
                                    ?>
                                    <span class="px-2 py-1 rounded-full <?= $status_class; ?>">
                                        <?= htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <button onclick="openDetailModal(<?= isset($t->id_transaksi) ? $t->id_transaksi : $t->id_order; ?>)" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">Detail</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="border border-gray-300 p-2 text-center">Tidak ada transaksi</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Detail Transaksi -->
<div id="detailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white rounded-lg p-6 w-1/2 shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Detail Transaksi</h2>
        <div id="modalContent">Loading...</div>
        <button onclick="window.print()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">Cetak Detail</button>
        <button onclick="closeDetailModal()" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md">Tutup</button>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div id="modalTransaksi" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Tambah Transaksi</h2>
        <form id="formTambahTransaksi" action="<?= site_url('transaksi/create') ?>" method="POST">
            <!-- Dropdown Pilih Pesanan -->
            <label class="block mb-2">Pilih Pesanan</label>
            <select name="order_id" class="w-full border p-2 rounded mb-3" required>
    <option value="">-- Pilih Pesanan --</option>
    <?php if (!empty($pesanan)) : ?>
        <?php foreach ($pesanan as $p): ?>
            <option value="<?= $p->id_order; ?>">
                <?= isset($p->nama_pelanggan) ? $p->nama_pelanggan : 'Unknown'; ?> - <?= date('d-m-Y', strtotime($p->tgl_pemesanan)) ?> - Rp<?= number_format($p->total_harga, 0, ',', '.'); ?>
            </option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="">Data pesanan tidak tersedia</option>
    <?php endif; ?>
</select>
            <!-- Pilih Metode Pembayaran -->
            <label class="block mb-2">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="w-full border p-2 rounded mb-3" required>
                <option value="transfer">Transfer</option>
                <option value="e-wallet">E-Wallet</option>
                <option value="cod">COD</option>
            </select>
            <div class="flex justify-end space-x-2">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
                <button type="button" onclick="closeTransaksiModal()" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</button>
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
    // Fungsi untuk membuka modal detail transaksi
    function openDetailModal(id) {
        fetch("<?= site_url('transaksi/detail/'); ?>" + id)
            .then(response => response.text())
            .then(data => {
                document.getElementById("modalContent").innerHTML = data;
                document.getElementById("detailModal").classList.remove("hidden");
            })
            .catch(error => {
                console.error("Error fetching detail:", error);
                alert("Gagal memuat detail transaksi.");
            });
    }

    function closeDetailModal() {
        document.getElementById("detailModal").classList.add("hidden");
    }

    // Fungsi untuk membuka dan menutup modal tambah transaksi
    function openTransaksiModal() {
        document.getElementById('modalTransaksi').classList.remove('hidden');
    }

    function closeTransaksiModal() {
        document.getElementById('modalTransaksi').classList.add('hidden');
    }

    // Fungsi untuk membuka modal edit status pesanan via AJAX
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

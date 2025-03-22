<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Konten -->
<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Transaksi</h1>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
                <thead style="background-color: #007bff;">
                    <tr>
                        <th class="border border-gray-300 p-2 text-white">ID Transaksi</th>
                        <th class="border border-gray-300 p-2 text-white">Tanggal</th>
                        <th class="border border-gray-300 p-2 text-white">Nama Pelanggan</th>
                        <th class="border border-gray-300 p-2 text-white">Total</th>
                        <th class="border border-gray-300 p-2 text-white">Status</th>
                        <th class="border border-gray-300 p-2 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transaksi)) : ?>
                        <?php foreach ($transaksi as $row) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 p-2"><?= $row->id_transaksi; ?></td>
                                <td class="border border-gray-300 p-2"><?= !empty($row->tanggal) ? date('d M Y', strtotime($row->tanggal)) : 'Tanggal tidak tersedia'; ?></td>
                                <td class="border border-gray-300 p-2"><?= htmlspecialchars($row->nama_pelanggan); ?></td>
                                <td class="border border-gray-300 p-2"><?= !empty($row->total) ? 'Rp ' . number_format($row->total, 0, ',', '.') : 'Total tidak tersedia'; ?></td>
                                <td class="border border-gray-300 p-2">
                                    <span class="px-2 py-1 rounded-full <?= !empty($row->status) && $row->status == 'Selesai' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' ?>">
                                        <?= !empty($row->status) ? htmlspecialchars($row->status) : 'Status tidak tersedia'; ?>
                                    </span>
                                </td>
                                <td class="border border-gray-300 p-2">
                                    <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600"
                                            onclick="openDetailModal(<?= $row->id_transaksi; ?>)">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="border border-gray-300 p-2">Tidak ada transaksi</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Detail -->
<div id="detailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white rounded-lg p-6 w-1/2 shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Detail Transaksi</h2>
        <div id="modalContent">Loading...</div>
        <button class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md" onclick="closeDetailModal()">Tutup</button>
    </div>
</div>

<script>
function openDetailModal(id) {
    fetch("<?= base_url('transaksi/detail/'); ?>" + id)
        .then(response => response.text())
        .then(data => {
            document.getElementById("modalContent").innerHTML = data;
            document.getElementById("detailModal").classList.remove("hidden");
        });
}

function closeDetailModal() {
    document.getElementById("detailModal").classList.add("hidden");
}
</script>


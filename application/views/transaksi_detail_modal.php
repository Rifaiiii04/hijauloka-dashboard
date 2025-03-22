<div>
    <p><strong>ID Transaksi:</strong> <?= $transaksi->id_transaksi; ?></p>
    <p><strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($transaksi->tanggal_transaksi)); ?></p>
    <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($transaksi->nama_pelanggan); ?></p>
    <p><strong>Total Bayar:</strong> Rp <?= number_format($transaksi->total_bayar, 0, ',', '.'); ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($transaksi->metode_pembayaran); ?></p>
    <p><strong>Status Pembayaran:</strong> <?= htmlspecialchars($transaksi->status_pembayaran); ?></p>

    <!-- Jika ada detail item transaksi, tampilkan dalam tabel -->
    <?php if (!empty($items)): ?>
        <h3 class="mt-4 font-bold">Detail Item</h3>
        <table class="w-full border-collapse border border-gray-300 text-center mt-2">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 p-2">Produk</th>
                    <th class="border border-gray-300 p-2">Harga</th>
                    <th class="border border-gray-300 p-2">Jumlah</th>
                    <th class="border border-gray-300 p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($item->nama_product); ?></td>
                        <td class="border border-gray-300 p-2">Rp <?= number_format($item->harga, 0, ',', '.'); ?></td>
                        <td class="border border-gray-300 p-2"><?= $item->jumlah; ?></td>
                        <td class="border border-gray-300 p-2">Rp <?= number_format($item->subtotal, 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

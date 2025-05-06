<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Detail Transaksi</h2>
    <p><strong>ID Transaksi:</strong> <?= $transaksi->id_transaksi; ?></p>
    <p>
        <strong>Tanggal:</strong> 
        <?= !empty($transaksi->tanggal_transaksi) ? date('d M Y, H:i', strtotime($transaksi->tanggal_transaksi)) : 'Tidak tersedia'; ?>
    </p>
    <p>
        <strong>Total Bayar:</strong> 
        <?= !empty($transaksi->total_bayar) ? 'Rp ' . number_format($transaksi->total_bayar, 0, ',', '.') : 'Tidak tersedia'; ?>
    </p>

    <hr class="my-4">

    <h3 class="text-xl font-semibold mb-2">Item Transaksi</h3>
    <div class="overflow-x-auto">
        <table class="min-w-[600px] w-full border-collapse border border-gray-300 text-center">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border border-gray-300 p-3">Produk</th>
                    <th class="border border-gray-300 p-3">Jumlah</th>
                    <th class="border border-gray-300 p-3 text-right">Harga</th>
                    <th class="border border-gray-300 p-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)) : ?>
                    <?php foreach ($items as $item) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 p-3"><?= htmlspecialchars($item->nama_product); ?></td>
                            <td class="border border-gray-300 p-3"><?= $item->jumlah; ?></td>
                            <td class="border border-gray-300 p-3 text-right"><?= 'Rp ' . number_format($item->harga, 0, ',', '.'); ?></td>
                            <td class="border border-gray-300 p-3 text-right"><?= 'Rp ' . number_format($item->subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="border border-gray-300 p-3 text-center text-gray-500">Tidak ada item transaksi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
</div>

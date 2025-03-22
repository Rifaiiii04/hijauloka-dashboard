<div class="overflow-x-auto">
    <table class="w-full border-collapse border border-gray-300 text-center">
        <thead style="background-color: #28a745;">
            <tr>
                <th class="border border-gray-300 p-2 text-white">Produk</th>
                <th class="border border-gray-300 p-2 text-white">Harga Satuan</th>
                <th class="border border-gray-300 p-2 text-white">Jumlah</th>
                <th class="border border-gray-300 p-2 text-white">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) : ?>
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 p-2"><?= htmlspecialchars($item->nama_product); ?></td>
                    <td class="border border-gray-300 p-2">Rp <?= number_format($item->harga_satuan, 0, ',', '.'); ?></td>
                    <td class="border border-gray-300 p-2"><?= $item->jumlah; ?></td>
                    <td class="border border-gray-300 p-2">Rp <?= number_format($item->subtotal, 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Konten Utama -->
<main class="flex-1 ml-64 p-6 overflow-auto">
    <!-- Header Dashboard -->
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-10">Dashboard</h1>
        
        <div class="flex " style="gap: 20px;">
            <!-- Transaksi Hari Ini -->
            <div class="p-6 rounded-lg text-center flex-1 min-w-[30%]" style="background-color: #cfe8fc;">
                <h2 class="text-xl font-bold text-blue-800 mb-2">Transaksi Hari Ini</h2>
                <p class="text-gray-600 cursor-pointer hover:underline">More Info 😊</p>
            </div>

            <!-- Produk Transaksi Terakhir -->
            <div class="p-6 rounded-lg text-center flex-1 min-w-[30%]" style="background-color: #d4edda;">
                <h2 class="text-xl font-bold text-green-800 mb-2">Produk Transaksi Terakhir</h2>
                <p class="text-gray-600 cursor-pointer hover:underline">More Info 😊</p>
            </div>

            <!-- Stok Masuk Hari Ini -->
            <div class="p-6 rounded-lg text-center flex-1 min-w-[30%]" style="background-color: #fff3cd;">
                <h2 class="text-xl font-bold text-yellow-800 mb-2">Stok Masuk Hari Ini</h2>
                <p class="text-gray-600 cursor-pointer hover:underline">More Info 😊</p>
            </div>
        </div>
    </div>

    <div class="mt-10 flex flex-wrap justify-between gap-6">
        <!-- Tanaman Terlaris -->
        <div class=" shadow-lg rounded-lg p-6 flex-1 min-w-[48%]">
            <h2 class="text-xl font-bold text-center mb-4 text-white rounded-md" style="background-color: #28a745;">Tanaman Terlaris</h2>
            <div class="flex justify-center">
                <canvas id="myPieChart" class="w-44 h-44"></canvas>
            </div>
        </div>

        <!-- Stok Tanaman -->
        <!-- Stok Tanaman -->
<div class="shadow-lg rounded-lg p-6 flex-1 min-w-[48%]">
    <h2 class="text-xl font-bold text-center mb-4 text-white rounded-md" style="background-color: #28a745;">Stok Tanaman</h2>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300 text-center">
            <thead style="background-color: #28a745;">
                <tr>
                    <th class="border border-gray-300 p-2 text-white">Nama</th>
                    <th class="border border-gray-300 p-2 text-white">Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($stok_tanaman)) : ?>
                    <?php foreach ($stok_tanaman as $tanaman) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 p-2"><?= htmlspecialchars($tanaman->nama_product); ?></td>
                            <td class="border border-gray-300 p-2"><?= $tanaman->stok; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2" class="border border-gray-300 p-2">Tidak ada stok tanaman</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
    
    <!-- line cart -->
<div class="bg-white shadow-lg rounded-lg p-6 flex-1 min-w-[48%]">
    <h2 class="text-xl font-bold text-center mb-4 text-white rounded-md" style="background-color: #28a745;">Grafik Penjualan</h2>
    <div class="flex justify-center">
        <canvas id="lineChart" class="w-full h-60"></canvas>
    </div>
</div>

</main>

<!-- Chart.js -->
<script src="<?= base_url('assets/js/chart.js'); ?>"></script>
<script src="<?= base_url('assets/js/dashboard_chart.js'); ?>"></script>

<!-- Menutup div utama dari header -->
</div>

<script>
  // Konversi data PHP ke JS
  const chartData = {
    bestProducts: <?= json_encode($best_products) ?>,
    monthlySales: <?= json_encode($monthly_sales) ?>
  };
</script>
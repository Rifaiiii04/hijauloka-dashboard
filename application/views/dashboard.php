<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Konten Utama -->
<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-10">Dashboard</h1>
        
        <div class="flex gap-6">
            <div class="p-6 rounded-lg text-center flex-1" style="background-color: #cfe8fc;">
                <h2 class="text-xl font-bold text-blue-800 mb-2">Transaksi Hari Ini</h2>
                <p class="text-gray-600 cursor-pointer hover:underline">More Info 😊</p>
            </div>
            <div class="p-6 rounded-lg text-center flex-1" style="background-color: #d4edda;">
                <h2 class="text-xl font-bold text-green-800 mb-2">Produk Transaksi Terakhir</h2>
                <p class="text-gray-600 cursor-pointer hover:underline">More Info 😊</p>
            </div>
            <div class="p-6 rounded-lg text-center flex-1" style="background-color: #fff3cd;">
                <h2 class="text-xl font-bold text-yellow-800 mb-2">Stok Masuk Hari Ini</h2>
                <p class="text-gray-600 cursor-pointer hover:underline">More Info 😊</p>
            </div>
        </div>
    </div>

    <div class="mt-10 flex flex-wrap justify-between gap-6">
        <!-- Pie Chart - Tanaman Terlaris -->
        <div class="shadow-lg rounded-lg p-6 flex-1 min-w-[48%]">
            <h2 class="text-xl font-bold text-center mb-4 text-white rounded-md" style="background-color: #28a745;">Tanaman Terlaris</h2>
            <div class="flex justify-center">
                <canvas id="myPieChart" class="w-44 h-44"></canvas>
            </div>
        </div>

        <!-- Tabel Stok Tanaman -->
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
    </div>
</main>

<!-- Load Chart.js Library -->
<script src="<?= base_url('assets/js/chart.js'); ?>"></script>

<!-- Script untuk inisialisasi Pie Chart -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const chartData = {
        products: <?= isset($best_products) ? json_encode($best_products) : '[]' ?>
    };

    console.log("Data produk untuk chart:", chartData.products);

    if (chartData.products && chartData.products.length > 0) {
        const canvas = document.getElementById("myPieChart");
        if (canvas) {
            const ctx = canvas.getContext("2d");
            new Chart(ctx, {
                type: "pie",
                data: {
                    labels: chartData.products.map(p => p.nama_product),
                    datasets: [{
                        data: chartData.products.map(p => p.total),
                        backgroundColor: chartData.products.map(() =>
                            `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`
                        )
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        } else {
            console.error("Canvas dengan id 'myPieChart' tidak ditemukan!");
        }
    } else {
        console.log("Data produk kosong atau tidak tersedia untuk chart.");
    }
});
</script>

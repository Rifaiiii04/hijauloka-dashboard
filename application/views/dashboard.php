<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Konten Utama -->
<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-10">Dashboard</h1>
        
        <!-- Card Dashboard -->
        <div class="flex gap-6">
            <!-- Total Pendapatan Bulan Ini -->
            <div class="p-6 rounded-lg text-center flex-1" style="background-color: #cfe8fc;">
                <h2 class="text-xl font-bold text-blue-800 mb-2">Total Pendapatan Bulan Ini</h2>
                <p class="text-2xl font-semibold mb-2">Rp <?= number_format($current_month_revenue, 0, ',', '.') ?></p>
            </div>
            
            <!-- Total Stok & Jenis Tanaman -->
            <div class="p-6 rounded-lg text-center flex-1" style="background-color: #d4edda;">
                <h2 class="text-xl font-bold text-green-800 mb-2">Total Stok Tanaman</h2>
                <p class="text-2xl font-semibold mb-2">
                    <?= $stok_summary->total_stok ?> Stok<br>
                    <span class="text-lg">dari <?= $stok_summary->jenis_tanaman ?> Jenis</span>
                </p>
            </div>
            
            <!-- Total Pesanan Hari Ini -->
            <div class="p-6 rounded-lg text-center flex-1" style="background-color: #fff3cd;">
                <h2 class="text-xl font-bold text-yellow-800 mb-2">Pesanan Hari Ini</h2>
                <p class="text-2xl font-semibold mb-2"><?= $today_orders ?> Pesanan</p>
            </div>
        </div>
    </div>

    <!-- Chart dan Tabel -->
    <div class="mt-10 flex flex-wrap justify-between gap-6">
        <!-- Pie Chart - Tanaman Terlaris -->
        <div class="shadow-lg rounded-lg p-6 flex-1 min-w-[48%]">
            <h2 class="text-xl font-bold text-center mb-4 text-white rounded-md" style="background-color: #08644C;">Tanaman Terlaris</h2>
            <div class="flex justify-center">
                <canvas id="myPieChart" class="w-44 h-44"></canvas>
            </div>
        </div>

        <!-- Tabel Stok Tanaman -->
        <div class="shadow-lg rounded-lg p-6 flex-1 min-w-[48%]">
            <h2 class="text-xl font-bold text-center mb-4 text-white rounded-md" style="background-color: #28a745;">Stok Tanaman</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 text-center">
                    <thead style="background-color: #08644C;">
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

    <!-- Line Chart Penjualan Bulanan -->
    <div class="mt-10">
        <div class="shadow-lg rounded-lg p-6 bg-white">
            <h2 class="text-xl font-bold text-center mb-4 text-white rounded-md" style="background-color: #08644C;">
                Total Penjualan Bulanan
            </h2>
            <div class="relative h-96">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>
</main>

<script src="<?= base_url('assets/js/chart.js'); ?>"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Pie Chart
    const pieData = {
        products: <?= isset($best_products) ? json_encode($best_products) : '[]' ?>
    };

    if (pieData.products && pieData.products.length > 0) {
        const pieCtx = document.getElementById('myPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: "pie",
            data: {
                labels: pieData.products.map(p => p.nama_product),
                datasets: [{
                    data: pieData.products.map(p => p.total),
                    backgroundColor: [
                        '#08644C',
                        '#28a745',
                        '#cfe8fc',
                        '#d4edda',
                        '#fff3cd'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Line Chart
    const lineData = {
        labels: <?= json_encode(array_column($monthly_sales, 'bulan')) ?>,
        datasets: [{
            label: 'Total Penjualan',
            data: <?= json_encode(array_column($monthly_sales, 'total')) ?>,
            borderColor: '#08644C',
            backgroundColor: 'rgba(8, 100, 76, 0.2)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#08644C',
            pointBorderColor: '#fff',
            pointHoverRadius: 8
        }]
    };

    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: lineData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>

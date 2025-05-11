
<?php $this->load->view('includes/sidebar'); ?>

<!-- Konten Utama -->
<main class="flex-1 ml-64 p-6 overflow-auto bg-gray-50">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600 mt-1">Selamat datang kembali, <?= $this->session->userdata('nama') ?? 'Admin' ?></p>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Pendapatan Bulan Ini -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-blue-50">
                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">
                    Bulan Ini
                </span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Pendapatan</h3>
            <p class="text-2xl font-bold text-gray-800">Rp <?= number_format($current_month_revenue, 0, ',', '.') ?></p>
        </div>

        <!-- Total Stok Tanaman -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-green-50">
                    <i class="fas fa-leaf text-green-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-green-600 bg-green-50 px-2.5 py-0.5 rounded-full">
                    Stok Aktif
                </span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Stok Tanaman</h3>
            <div class="flex items-baseline">
                <p class="text-2xl font-bold text-gray-800"><?= $stok_summary->total_stok ?></p>
                <span class="ml-2 text-sm text-gray-500">dari <?= $stok_summary->jenis_tanaman ?> jenis</span>
            </div>
        </div>

        <!-- Pesanan Pending -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-red-50">
                    <i class="fas fa-clock text-red-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-red-600 bg-red-50 px-2.5 py-0.5 rounded-full">
                    Perlu Perhatian
                </span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Pesanan Pending</h3>
            <div class="flex items-baseline">
                <p class="text-2xl font-bold text-gray-800"><?= $pending_orders ?></p>
                <span class="ml-2 text-sm text-gray-500">pesanan</span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Sales Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Grafik Penjualan Bulanan</h2>
            </div>
            <div class="p-6">
                <div class="relative h-80">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Stok Perlu Perhatian -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Stok Perlu Perhatian</h2>
                    <a href="<?= site_url('produk') ?>" class="text-sm text-green-600 hover:text-green-700">
                        Kelola Stok <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php 
                    $low_stock = array_filter($stok_tanaman, function($tanaman) {
                        return $tanaman->stok <= 10;
                    });
                    
                    if (!empty($low_stock)) : 
                        foreach ($low_stock as $tanaman) : 
                    ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-leaf text-gray-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800"><?= htmlspecialchars($tanaman->nama_product) ?></h3>
                                    <p class="text-sm text-gray-500">Stok tersisa: <?= $tanaman->stok ?></p>
                                </div>
                            </div>
                            <?php if ($tanaman->stok <= 0): ?>
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Habis
                                </span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Hampir Habis
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php 
                        endforeach;
                    else : 
                    ?>
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-2xl"></i>
                            </div>
                            <p class="text-gray-500">Semua stok dalam kondisi baik</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="<?= base_url('assets/js/chart.js'); ?>"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Line Chart
    const lineData = {
        labels: <?= json_encode(array_column($monthly_sales, 'bulan')) ?>,
        datasets: [{
            label: 'Total Penjualan',
            data: <?= json_encode(array_column($monthly_sales, 'total')) ?>,
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#10B981',
            pointBorderColor: '#fff',
            pointHoverRadius: 8,
            borderWidth: 2
        }]
    };

    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: lineData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#374151',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F3F4F6'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        },
                        color: '#6B7280'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280'
                    }
                }
            }
        }
    });
});
</script>

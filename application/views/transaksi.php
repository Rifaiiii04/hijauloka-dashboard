
<?php $this->load->view('includes/sidebar'); ?>

<!-- Toast Notification -->
<?php if($this->session->flashdata('error') || $this->session->flashdata('success')): ?>
<div id="toast" class="fixed top-4 right-4 z-50 bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 opacity-100 translate-y-0">
    <div class="flex items-center p-4 <?= $this->session->flashdata('error') ? 'bg-red-50 border-l-4 border-red-500' : 'bg-green-50 border-l-4 border-green-500' ?>">
        <div class="flex-shrink-0 mr-3">
            <i class="fas <?= $this->session->flashdata('error') ? 'fa-exclamation-circle text-red-500' : 'fa-check-circle text-green-500' ?>"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-medium"><?= $this->session->flashdata('error') ?: $this->session->flashdata('success') ?></p>
        </div>
        <div class="ml-3">
            <button onclick="document.getElementById('toast').classList.add('opacity-0', 'translate-y-[-20px]')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
<script>
    setTimeout(() => {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.classList.add('opacity-0', 'translate-y-[-20px]');
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
</script>
<?php endif; ?>

<!-- Main Content -->
<main class="flex-1 ml-64 p-6 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <!-- Header with Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Manajemen Transaksi</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola dan monitor status pembayaran</p>
            </div>
            <div class="mt-3 md:mt-0 flex items-center space-x-2">
                <button onclick="exportToExcel()" class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors text-sm flex items-center shadow-sm">
                    <i class="fas fa-file-excel mr-2"></i> Export Data
                </button>
            </div>
        </div>
        
        <!-- Transaction Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500">Total Transaksi</h3>
                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">Semua</span>
                </div>
                <p class="text-2xl font-bold text-gray-800"><?= $total_rows ?? 0 ?></p>
                <div class="mt-2 text-xs text-gray-500">Transaksi tercatat dalam sistem</div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
                    <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full">Rp</span>
                </div>
                <p class="text-2xl font-bold text-gray-800">Rp<?= number_format($total_income ?? 0, 0, ',', '.') ?></p>
                <div class="mt-2 text-xs text-gray-500">Dari seluruh transaksi</div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500">Transaksi Hari Ini</h3>
                    <span class="bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full"><?= date('d M') ?></span>
                </div>
                <p class="text-2xl font-bold text-gray-800"><?= $today_count ?? 0 ?></p>
                <div class="mt-2 text-xs text-gray-500">Transaksi baru hari ini</div>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="relative flex-1">
                        <input type="text" 
                            id="searchInput"
                            class="w-full h-10 pl-10 pr-4 rounded-lg bg-gray-50 border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 text-sm" 
                            placeholder="Cari nama pelanggan atau ID transaksi...">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button id="searchBtn" class="ml-3 px-5 h-10 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm shadow-sm">
                        Cari
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Transactions List -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 class="font-medium text-gray-700">Daftar Transaksi</h3>
                <div class="flex space-x-2">
                    <select id="filterStatus" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 bg-gray-50 focus:outline-none focus:ring-1 focus:ring-green-500">
                        <option value="">Semua Status</option>
                        <option value="lunas">Lunas</option>
                        <option value="pending">Pending</option>
                        <option value="gagal">Gagal</option>
                    </select>
                    <select id="sortOrder" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 bg-gray-50 focus:outline-none focus:ring-1 focus:ring-green-500">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="highest">Nominal Tertinggi</option>
                        <option value="lowest">Nominal Terendah</option>
                    </select>
                </div>
            </div>
            
            <?php if (!empty($transaksi)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase border-b border-gray-100">
                                <th class="px-4 py-3 text-left font-medium">ID</th>
                                <th class="px-4 py-3 text-left font-medium">Tanggal</th>
                                <th class="px-4 py-3 text-left font-medium">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-medium">Metode</th>
                                <th class="px-4 py-3 text-left font-medium">Total</th>
                                <th class="px-4 py-3 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($transaksi as $t): ?>
                                <tr class="hover:bg-gray-50 text-sm transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        #<?= isset($t->id_transaksi) ? $t->id_transaksi : $t->id_order; ?>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">
                                        <?= date('d M Y', strtotime($t->tanggal_transaksi)) ?>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900">
                                        <?= isset($t->nama_pelanggan) ? $t->nama_pelanggan : 'N/A' ?>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">
                                        <div class="flex items-center">
                                            <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-2">
                                                <i class="fas <?= (isset($t->metode_pembayaran) && strtolower($t->metode_pembayaran) == 'midtrans') ? 'fa-credit-card' : 'fa-money-bill-wave' ?> text-gray-500"></i>
                                            </span>
                                            <?= isset($t->metode_pembayaran) ? ucfirst($t->metode_pembayaran) : 'N/A' ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        Rp<?= number_format($t->total_bayar ?? 0, 0, ',', '.') ?>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <button onclick="openDetailModal(<?= isset($t->id_transaksi) ? $t->id_transaksi : $t->id_order; ?>)" 
                                                    class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <button onclick="printInvoice(<?= isset($t->id_transaksi) ? $t->id_transaksi : $t->id_order; ?>)" 
                                                    class="p-1.5 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors" title="Cetak Invoice">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                    <div>
                        Menampilkan <?= count($transaksi) ?> dari <?= $total_rows ?> transaksi
                    </div>
                    
                    <!-- Pagination -->
                    <nav class="pagination">
                        <?php 
                            $current_page = ($this->input->get('page')) ? $this->input->get('page') : 1;
                            $total_pages = ceil($total_rows / $per_page);
                            
                            if ($total_pages > 1):
                        ?>
                            <div class="inline-flex rounded-lg overflow-hidden shadow-sm">
                                <?php if ($current_page > 1): ?>
                                    <a href="<?= site_url('transaksi?page=' . ($current_page - 1)) ?>" 
                                    class="px-3 py-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-sm flex items-center justify-center">&laquo;</a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <a href="<?= site_url('transaksi?page=' . $i) ?>" 
                                    class="px-3 py-1.5 <?= ($i == $current_page) ? 'bg-green-500 text-white border-green-500' : 'bg-white hover:bg-gray-50 border-gray-200' ?> border <?= ($i != 1) ? 'border-l-0' : '' ?> text-sm flex items-center justify-center">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($current_page < $total_pages): ?>
                                    <a href="<?= site_url('transaksi?page=' . ($current_page + 1)) ?>" 
                                    class="px-3 py-1.5 bg-white border border-l-0 border-gray-200 hover:bg-gray-50 text-sm flex items-center justify-center">&raquo;</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php else: ?>
                <div class="p-8 text-center">
                    <div class="py-6 flex flex-col items-center">
                        <div class="bg-gray-100 p-4 rounded-full mb-4">
                            <i class="fas fa-receipt text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-base font-medium text-gray-800 mb-2">Tidak ada transaksi</h3>
                        <p class="text-gray-500">Belum ada transaksi yang tercatat dalam sistem</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-11/12 max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="text-xl font-bold text-gray-800">Detail Transaksi</h2>
            <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="modalContent" class="p-6">
            <div class="flex justify-center items-center p-8">
                <i class="fas fa-spinner fa-spin text-green-500 text-3xl"></i>
            </div>
        </div>
        <div class="p-6 border-t border-gray-200 flex justify-end space-x-3 sticky bottom-0 bg-white">
            <button onclick="closeDetailModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Tutup
            </button>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                <i class="fas fa-print mr-2"></i>Cetak Invoice
            </button>
        </div>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div id="modalTransaksi" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-96 max-w-full mx-4">
        <div class="p-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Tambah Transaksi</h2>
        </div>
        <form id="formTambahTransaksi" action="<?= site_url('transaksi/create') ?>" method="POST">
            <div class="p-5">
                <!-- Dropdown Pilih Pesanan -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Pilih Pesanan</label>
                    <select name="order_id" class="w-full p-3 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-500" required>
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
                </div>
                <!-- Pilih Metode Pembayaran -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full p-3 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-500" required>
                        <option value="transfer">Transfer</option>
                        <option value="e-wallet">E-Wallet</option>
                        <option value="cod">COD</option>
                        <option value="midtrans">Midtrans</option>
                    </select>
                </div>
            </div>
            <div class="p-5 border-t border-gray-100 flex justify-end space-x-3">
                <button type="button" onclick="closeTransaksiModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    
    // Search button click handler
    searchBtn.addEventListener('click', function() {
        const searchTerm = searchInput.value;
        let url = '<?= site_url('transaksi') ?>';
        
        if (searchTerm) {
            url += '?search=' + encodeURIComponent(searchTerm);
        }
        
        window.location.href = url;
    });
    
    // Allow search on Enter key
    searchInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            searchBtn.click();
        }
    });
    
    // Set search input from URL if exists
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    
    if (searchParam) {
        searchInput.value = searchParam;
    }
});

// Detail modal functions
function openDetailModal(id) {
    document.getElementById('modalContent').innerHTML = '<div class="flex justify-center items-center p-6"><i class="fas fa-spinner fa-spin text-green-500 text-2xl"></i></div>';
    document.getElementById('detailModal').classList.remove('hidden');
    
    fetch("<?= site_url('transaksi/detail/') ?>" + id)
        .then(response => response.ok ? response.text() : Promise.reject('Network response was not ok'))
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('modalContent').innerHTML = `
                <div class="p-6 text-center">
                    <div class="bg-red-100 p-4 rounded-full mb-3 mx-auto w-14 h-14 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    </div>
                    <h3 class="text-base font-medium text-gray-800 mb-1">Terjadi Kesalahan</h3>
                    <p class="text-gray-500 text-sm">Gagal memuat detail transaksi. Silakan coba lagi nanti.</p>
                </div>
            `;
        });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

function openTransaksiModal() {
    document.getElementById('modalTransaksi').classList.remove('hidden');
}

function closeTransaksiModal() {
    document.getElementById('modalTransaksi').classList.add('hidden');
}

// Print invoice
function printInvoice(id) {
    window.open("<?= site_url('transaksi/cetak/') ?>" + id, '_blank');
}

// Update status function
function updateStatus(id, status) {
    if (confirm('Apakah Anda yakin ingin mengubah status transaksi ini menjadi ' + status + '?')) {
        fetch("<?= site_url('transaksi/update_status/') ?>" + id, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Status transaksi berhasil diperbarui', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message || 'Gagal mengubah status transaksi', 'error');
            }
        })
        .catch(error => {
            showToast('Terjadi kesalahan saat mengubah status', 'error');
        });
    }
}

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 z-50 bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 opacity-0 translate-y-[-20px]';
    
    const bgColor = type === 'success' ? 'bg-green-50 border-l-4 border-green-500' : 'bg-red-50 border-l-4 border-red-500';
    const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    toast.innerHTML = `
        <div class="flex items-center p-3 ${bgColor}">
            <div class="flex-shrink-0 mr-2"><i class="fas ${icon} ${iconColor}"></i></div>
            <div class="flex-1"><p class="text-sm">${message}</p></div>
            <div class="ml-2">
                <button onclick="this.parentElement.parentElement.parentElement.classList.add('opacity-0', 'translate-y-[-20px]')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.classList.remove('opacity-0', 'translate-y-[-20px]');
        toast.classList.add('opacity-100', 'translate-y-0');
    }, 10);
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-[-20px]');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Export data to Excel
function exportToExcel() {
    window.location.href = "<?= site_url('transaksi/export') ?>";
}


// Add this to your existing script section
document.addEventListener('DOMContentLoaded', function() {
    // Filter and sort functionality
    const filterStatus = document.getElementById('filterStatus');
    const sortOrder = document.getElementById('sortOrder');
    
    if (filterStatus && sortOrder) {
        // Apply filters when changed
        filterStatus.addEventListener('change', applyFilters);
        sortOrder.addEventListener('change', applyFilters);
        
        // Set initial values from URL if present
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        const sortParam = urlParams.get('sort');
        
        if (statusParam) {
            filterStatus.value = statusParam;
        }
        
        if (sortParam) {
            sortOrder.value = sortParam;
        }
    }
    
    function applyFilters() {
        const status = filterStatus.value;
        const sort = sortOrder.value;
        const searchTerm = document.getElementById('searchInput').value;
        
        let url = '<?= site_url('transaksi') ?>';
        const params = [];
        
        if (status) {
            params.push('status=' + encodeURIComponent(status));
        }
        
        if (sort) {
            params.push('sort=' + encodeURIComponent(sort));
        }
        
        if (searchTerm) {
            params.push('search=' + encodeURIComponent(searchTerm));
        }
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        
        window.location.href = url;
    }
});
</script>

<?php $this->load->view('includes/sidebar'); ?>

<!-- Alert Flashdata -->
<?php if($this->session->flashdata('error')): ?>
    <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50" role="alert">
        <span class="block sm:inline"><?= $this->session->flashdata('error'); ?></span>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('success')): ?>
    <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50" role="alert">
        <span class="block sm:inline"><?= $this->session->flashdata('success'); ?></span>
    </div>
<?php endif; ?>

<!-- Main Content -->
<main class="flex-1 ml-64 p-6 overflow-auto bg-gray-50">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen Transaksi</h1>
        <p class="text-gray-600">Kelola dan pantau semua transaksi pelanggan</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Transaksi Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $today_count ?? 0 ?></h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        <?php
                        $today_income = 0;
                        foreach ($transaksi as $t) {
                            if (date('Y-m-d', strtotime($t->tanggal_transaksi)) == date('Y-m-d')) {
                                $today_income += $t->total_bayar;
                            }
                        }
                        echo 'Rp ' . number_format($today_income, 0, ',', '.');
                        ?>
                    </h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pesanan Belum Dibayar</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= count($pesanan ?? []) ?></h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Transaction Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Card Header with Search and Filters -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Transaksi</h2>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                        Total: <?= $total_rows ?? 0 ?> transaksi
                    </span>
                </div>
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari transaksi..." 
                               class="w-full md:w-64 px-4 py-2 pl-10 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select id="statusFilter" class="px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                        <option value="">Semua Status</option>
                        <option value="lunas">Lunas</option>
                        <option value="pending">Pending</option>
                        <option value="gagal">Gagal</option>
                    </select>
                    <select id="methodFilter" class="px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                        <option value="">Semua Metode</option>
                        <option value="transfer">Transfer</option>
                        <option value="e-wallet">E-Wallet</option>
                        <option value="cod">COD</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-6 font-medium text-left">Tanggal</th>
                        <th class="py-3 px-6 font-medium text-left">ID Transaksi</th>
                        <th class="py-3 px-6 font-medium text-left">Pelanggan</th>
                        <th class="py-3 px-6 font-medium text-right">Total</th>
                        <th class="py-3 px-6 font-medium text-center">Metode</th>
                        <th class="py-3 px-6 font-medium text-center">Status</th>
                        <th class="py-3 px-6 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="transactionTableBody" class="divide-y divide-gray-100">
                    <?php if (!empty($transaksi)) : ?>
                        <?php foreach ($transaksi as $t): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-800">
                                        <?= !empty($t->tanggal_transaksi) ? date('d M Y', strtotime($t->tanggal_transaksi)) : 'N/A'; ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?= !empty($t->tanggal_transaksi) ? date('H:i', strtotime($t->tanggal_transaksi)) : ''; ?> WIB
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-mono text-sm text-gray-600">
                                        #<?= str_pad($t->id_transaksi, 6, '0', STR_PAD_LEFT); ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-800">
                                        <?= isset($t->nama_pelanggan) ? $t->nama_pelanggan : 'Tidak diketahui'; ?>
                                    </div>
                                    <?php if(isset($t->email)): ?>
                                        <div class="text-xs text-gray-500"><?= $t->email; ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="font-bold text-green-700">
                                        <?= !empty($t->total_bayar) ? 'Rp ' . number_format($t->total_bayar, 0, ',', '.') : 'N/A'; ?>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <?php 
                                    $method = isset($t->metode_pembayaran) ? strtolower($t->metode_pembayaran) : '';
                                    $icon = 'fa-money-bill';
                                    $color = 'text-gray-600';
                                    $bgColor = 'bg-gray-100';
                                    
                                    if ($method == 'transfer') {
                                        $icon = 'fa-university';
                                        $color = 'text-blue-600';
                                        $bgColor = 'bg-blue-50';
                                    } elseif ($method == 'e-wallet') {
                                        $icon = 'fa-wallet';
                                        $color = 'text-purple-600';
                                        $bgColor = 'bg-purple-50';
                                    } elseif ($method == 'cod') {
                                        $icon = 'fa-hand-holding-usd';
                                        $color = 'text-green-600';
                                        $bgColor = 'bg-green-50';
                                    }
                                    ?>
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-sm <?= $bgColor ?> <?= $color ?>">
                                        <i class="fas <?= $icon ?> mr-1.5"></i>
                                        <span><?= ucfirst($method) ?: 'N/A' ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <?php 
                                    $status = isset($t->status_pembayaran) ? strtolower($t->status_pembayaran) : '';
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    $statusIcon = 'fa-question-circle';
                                    
                                    if ($status == 'lunas') {
                                        $statusClass = 'bg-green-100 text-green-800';
                                        $statusIcon = 'fa-check-circle';
                                    } elseif ($status == 'pending') {
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                        $statusIcon = 'fa-clock';
                                    } elseif ($status == 'gagal') {
                                        $statusClass = 'bg-red-100 text-red-800';
                                        $statusIcon = 'fa-times-circle';
                                    }
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                                        <i class="fas <?= $statusIcon ?> mr-1.5"></i>
                                        <?= ucwords($status) ?: 'N/A' ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="openDetailModal(<?= $t->id_transaksi; ?>)" 
                                                class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors" 
                                                title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if ($status == 'pending'): ?>
                                            <button onclick="updateStatus(<?= $t->id_transaksi; ?>, 'lunas')"
                                                    class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors"
                                                    title="Tandai Lunas">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-8 text-center">
                                <div class="py-8 flex flex-col items-center">
                                    <div class="bg-gray-100 p-6 rounded-full mb-4">
                                        <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-800 mb-1">Tidak ada transaksi</h3>
                                    <p class="text-gray-500">Belum ada transaksi yang tercatat dalam sistem</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-gray-100">
            <nav class="flex justify-center">
                <?php 
                    $current_page = ($this->input->get('page')) ? $this->input->get('page') : 1;
                    $total_pages = ceil($total_rows / $per_page);
                    
                    if ($total_pages > 1):
                ?>
                    <div class="flex gap-2">
                        <?php if ($current_page > 1): ?>
                            <a href="<?= site_url('transaksi?page=' . ($current_page - 1)) ?>" 
                               class="px-3 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                               <i class="fas fa-chevron-left mr-1 text-xs"></i> Prev
                            </a>
                        <?php endif; ?>

                        <?php 
                        // Show limited page numbers with ellipsis
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);
                        
                        if ($start_page > 1) echo '<span class="px-3 py-2 text-gray-500">...</span>';
                        
                        for ($i = $start_page; $i <= $end_page; $i++): 
                        ?>
                            <a href="<?= site_url('transaksi?page=' . $i) ?>" 
                               class="px-3 py-2 <?= ($i == $current_page) ? 'bg-green-500 text-white' : 'bg-white border border-gray-200 hover:bg-gray-50 text-gray-700' ?> rounded-lg transition-colors">
                                <?= $i ?>
                            </a>
                        <?php endfor; 
                        
                        if ($end_page < $total_pages) echo '<span class="px-3 py-2 text-gray-500">...</span>';
                        ?>

                        <?php if ($current_page < $total_pages): ?>
                            <a href="<?= site_url('transaksi?page=' . ($current_page + 1)) ?>" 
                               class="px-3 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                               Next <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</main>

<!-- Detail Modal -->
<div id="modalDetailTransaksi" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="text-xl font-bold text-gray-800">Detail Transaksi</h2>
            <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="modalDetailContent" class="p-6">
            Loading...
        </div>
        <div class="p-6 border-t border-gray-200 flex justify-end space-x-3 sticky bottom-0 bg-white">
            <button onclick="closeDetailModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Tutup
            </button>
            <button onclick="printInvoice()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                <i class="fas fa-print mr-2"></i>Cetak Invoice
            </button>
        </div>
    </div>
</div>

<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const methodFilter = document.getElementById('methodFilter');
    
    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const methodValue = methodFilter.value.toLowerCase();
        const tableBody = document.getElementById('transactionTableBody');
        const rows = tableBody.getElementsByTagName('tr');
        let visibleCount = 0;

        for (let row of rows) {
            const cells = row.getElementsByTagName('td');
            if (cells.length > 0) {
                const date = cells[0].textContent.toLowerCase();
                const id = cells[1].textContent.toLowerCase();
                const customer = cells[2].textContent.toLowerCase();
                const total = cells[3].textContent.toLowerCase();
                const method = cells[4].textContent.toLowerCase();
                const status = cells[5].textContent.toLowerCase();
                
                const matchesSearch = date.includes(searchValue) || 
                    id.includes(searchValue) ||
                    customer.includes(searchValue) || 
                    total.includes(searchValue) ||
                    method.includes(searchValue) ||
                    status.includes(searchValue);
                    
                const matchesStatus = statusValue === '' || status.includes(statusValue);
                const matchesMethod = methodValue === '' || method.includes(methodValue);
                
                if (matchesSearch && matchesStatus && matchesMethod) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            }
        }
        
        // Show "no results" message if needed
        const noResultsRow = tableBody.querySelector('.no-results-row');
        if (visibleCount === 0 && !noResultsRow) {
            const newRow = document.createElement('tr');
            newRow.className = 'no-results-row';
            newRow.innerHTML = `
                <td colspan="7" class="p-8 text-center">
                    <div class="py-8 flex flex-col items-center">
                        <div class="bg-gray-100 p-6 rounded-full mb-4">
                            <i class="fas fa-search text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-800 mb-1">Tidak ditemukan</h3>
                        <p class="text-gray-500">Tidak ada transaksi yang cocok dengan pencarian Anda</p>
                    </div>
                </td>
            `;
            tableBody.appendChild(newRow);
        } else if (visibleCount > 0 && noResultsRow) {
            noResultsRow.remove();
        }
    }
    
    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (statusFilter) statusFilter.addEventListener('change', filterTable);
    if (methodFilter) methodFilter.addEventListener('change', filterTable);
});

// Detail modal functions
function openDetailModal(id) {
    fetch("<?= site_url('transaksi/detail/') ?>" + id)
        .then(response => {
            if (!response.ok) throw new Error("Gagal mengambil data");
            return response.text();
        })
        .then(html => {
            document.getElementById('modalDetailContent').innerHTML = html;
            document.getElementById('modalDetailTransaksi').classList.remove('hidden');
        })
        .catch(error => {
            console.error("Error fetching transaction details:", error);
            alert("Gagal memuat detail transaksi");
        });
}

function closeDetailModal() {
    document.getElementById('modalDetailTransaksi').classList.add('hidden');
}

// Update status function
function updateStatus(id, status) {
    if (confirm('Apakah Anda yakin ingin mengubah status transaksi ini?')) {
        fetch("<?= site_url('transaksi/update_status/') ?>" + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Gagal mengubah status transaksi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status');
        });
    }
}

// Print invoice function
function printInvoice() {
    const modalContent = document.getElementById('modalDetailContent').innerHTML;
    const printWindow = window.open('', '_blank', 'height=600,width=800');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Invoice</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                .invoice-header { text-align: center; margin-bottom: 30px; }
                .invoice-header h1 { margin: 0; color: #08644C; }
                .invoice-details { margin-bottom: 20px; }
                .invoice-details table { width: 100%; }
                .invoice-details td { padding: 5px 0; }
                .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
                .items-table th { background-color: #f3f4f6; text-align: left; padding: 10px; border-bottom: 1px solid #e5e7eb; }
                .items-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; }
                .text-right { text-align: right; }
                .total-row { font-weight: bold; }
                .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #6b7280; }
                @media print {
                    body { padding: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="invoice-header">
                <h1>HIJAULOKA</h1>
                <p>Invoice</p>
            </div>
            ${modalContent}
            <div class="footer">
                <p>Terima kasih telah berbelanja di Hijauloka</p>
                <p>Dicetak pada ${new Date().toLocaleString()}</p>
            </div>
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
        printWindow.print();
    }, 500);
}

// Auto-hide flash messages
document.addEventListener('DOMContentLoaded', function() {
    const flashMessages = document.querySelectorAll('[role="alert"]');
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 300);
        }, 3000);
    });
});
</script>
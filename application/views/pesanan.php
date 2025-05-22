
<?php $this->load->view('includes/sidebar'); ?>

<!-- Toast Notification -->
<?php if($this->session->flashdata('error') || $this->session->flashdata('success')): ?>
<div id="toast" class="fixed top-4 right-4 z-50 bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 opacity-100 translate-y-0">
    <div class="flex items-center p-4 <?= $this->session->flashdata('error') ? 'bg-red-50 border-l-4 border-red-500' : 'bg-green-50 border-l-4 border-green-500' ?>">
        <div class="flex-shrink-0 mr-3">
            <i class="fas <?= $this->session->flashdata('error') ? 'fa-exclamation-circle text-red-500' : 'fa-check-circle text-green-500' ?>"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-medium <?= $this->session->flashdata('error') ?: $this->session->flashdata('success') ?>
            </p>
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
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pesanan</h1>
        </header>
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 bg-green-500 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="font-medium">Total Pesanan</h3>
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <p class="text-2xl font-bold mt-1"><?= $total_rows ?></p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 bg-red-500 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="font-medium">Pending</h3>
                        <i class="fas fa-clock"></i>
                    </div>
                    <p class="text-2xl font-bold mt-1"><?= count(array_filter($pesanan, function($p) { return $p->stts_pemesanan === 'pending'; })) ?></p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 bg-orange-500 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="font-medium">Dikirim</h3>
                        <i class="fas fa-truck"></i>
                    </div>
                    <p class="text-2xl font-bold mt-1"><?= count(array_filter($pesanan, function($p) { return $p->stts_pemesanan === 'dikirim'; })) ?></p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 bg-blue-500 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="font-medium">Selesai</h3>
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="text-2xl font-bold mt-1"><?= count(array_filter($pesanan, function($p) { return $p->stts_pemesanan === 'selesai'; })) ?></p>
                </div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 border-b border-gray-100">
                <h2 class="font-medium text-gray-700">Filter Pesanan</h2>
            </div>
            <div class="p-4">
                <div class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <div class="relative">
                            <input type="text" 
                                id="searchInput"
                                class="w-full h-10 pl-10 pr-4 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-500" 
                                placeholder="Cari nama pelanggan atau ID...">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="w-full sm:w-auto">
                        <select id="statusFilter" class="w-full h-10 px-3 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="dikirim">Dikirim</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    
                    <button id="searchBtn" class="px-4 h-10 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Orders List -->
        <?php if (!empty($pesanan)): ?>
            <div class="flex flex-wrap gap-4 mb-6">
                <?php foreach ($pesanan as $p): ?>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-200 w-72">
                        <!-- Order Header -->
                        <div class="p-3 <?= getStatusColor(strtolower($p->stts_pemesanan ?? 'pending')) ?>">
                            <div class="flex justify-between items-center">
                                <h3 class="font-bold text-white text-base">Order #<?= $p->id_order ?></h3>
                                <span class="px-2 py-1 rounded-full bg-white/20 text-white text-xs font-medium">
                                    <?= ucfirst($p->stts_pemesanan ?? 'pending') ?>
                                </span>
                            </div>
                            <p class="text-white/80 text-sm mt-1"><?= date('d M Y', strtotime($p->tgl_pemesanan)) ?></p>
                        </div>
                        
                        <!-- Order Content -->
                        <div class="p-4">
                            <!-- Customer -->
                            <div class="flex items-start mb-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-2 mt-1">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Pelanggan</p>
                                    <p class="font-medium"><?= isset($p->nama_pelanggan) ? $p->nama_pelanggan : 'N/A' ?></p>
                                </div>
                            </div>
                            
                            <!-- Payment Status -->
                            <div class="flex items-start mb-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-2 mt-1">
                                    <i class="fas fa-money-bill-wave text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Status Pembayaran</p>
                                    <p class="font-medium <?= $p->stts_pembayaran === 'lunas' ? 'text-green-600' : 'text-orange-500' ?>">
                                        <?= $p->stts_pembayaran === 'lunas' ? 'Lunas' : 'Belum Dibayar' ?>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Shipping Method -->
                            <div class="flex items-start mb-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-2 mt-1">
                                    <i class="fas fa-shipping-fast text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Pengiriman</p>
                                    <p class="font-medium"><?= strtoupper($p->kurir ?? 'Hijauloka') ?></p>
                                </div>
                            </div>
                            
                            <!-- Products Summary -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-1">Produk (<?= count($p->produk ?? []) ?>)</p>
                                <?php if (!empty($p->produk)): ?>
                                    <div class="space-y-2">
                                        <?php foreach ($p->produk as $index => $prod): ?>
                                            <?php if ($index < 2): ?>
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <p class="font-medium"><?= $prod->nama_produk ?? 'N/A' ?> (<?= $prod->quantity ?? 0 ?>)</p>
                                                    </div>
                                                    <p class="font-medium">Rp<?= number_format($prod->subtotal ?? 0, 0, ',', '.') ?></p>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        
                                        <?php if (count($p->produk) > 2): ?>
                                            <p class="text-sm text-gray-500 italic">+ <?= count($p->produk) - 2 ?> produk lainnya</p>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500">Tidak ada produk</p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Price Details -->
                            <div class="bg-gray-50 p-2 rounded-lg mb-3">
                                <div class="flex justify-between items-center mb-1">
                                    <p class="text-xs text-gray-500">Subtotal</p>
                                    <p class="text-sm font-medium">Rp<?= number_format((isset($p->ongkir) ? $p->total_harga - $p->ongkir : $p->total_harga) ?? 0, 0, ',', '.') ?></p>
                                </div>
                              
                            </div>
                            
                            <!-- Total -->
                            <div class="flex justify-between items-center pt-3 mt-2 border-t border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="text-lg font-bold">Rp<?= number_format($p->total_harga ?? 0, 0, ',', '.') ?></p>
                                </div>
                                
                                <div class="flex gap-2">
                                    <button onclick="openEditModal('<?= $p->id_order ?>')" 
                                            class="bg-green-500 text-white p-2 rounded-full hover:bg-green-600 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!--<a href="<?= site_url('pesanan/delete/' . $p->id_order) ?>" -->
                                    <!--   class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors" -->
                                    <!--   onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">-->
                                    <!--    <i class="fas fa-trash"></i>-->
                                    <!--</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty state remains the same -->
        <?php endif; ?>
        
        <!-- Pagination -->
        <?php 
            $current_page = ($this->input->get('page')) ? $this->input->get('page') : 1;
            $total_pages = ceil($total_rows / $per_page);
            
            if ($total_pages > 1):
        ?>
        <div class="flex justify-center">
            <nav class="inline-flex rounded-lg shadow-sm">
                <?php if ($current_page > 1): ?>
                    <a href="<?= site_url('pesanan?page=' . ($current_page - 1)) ?>" class="px-4 py-2 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-50">&laquo;</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="<?= site_url('pesanan?page=' . $i) ?>" 
                       class="px-4 py-2 <?= ($i == $current_page) ? 'bg-green-500 text-white border-green-500' : 'bg-white hover:bg-gray-50 border-gray-200' ?> <?= ($i == 1 && $current_page == 1) ? 'rounded-l-lg' : '' ?> <?= ($i == $total_pages && $current_page == $total_pages) ? 'rounded-r-lg' : '' ?> border <?= ($i != 1) ? 'border-l-0' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="<?= site_url('pesanan?page=' . ($current_page + 1)) ?>" class="px-4 py-2 bg-white rounded-r-lg border border-l-0 border-gray-200 hover:bg-gray-50">&raquo;</a>
                <?php endif; ?>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</main>

<!-- Modal Edit Status -->
<div id="modalEditPesanan" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 max-w-full mx-4 transform transition-all">
        <div class="p-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Update Status Pesanan</h2>
        </div>
        
        <form id="editForm" method="POST" action="<?= site_url('pesanan/update_status'); ?>">
            <div class="p-5">
                <input type="hidden" name="id_order" id="edit_id_order">
                
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Status Pesanan</label>
                    <select name="stts_pemesanan" id="edit_status" class="w-full p-3 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-500" required>
                        <option value="pending">Pending</option>
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                
                <!-- Payment Status Field -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Status Pembayaran</label>
                    <select name="stts_pembayaran" id="edit_payment_status" class="w-full p-3 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-500" required>
                        <option value="belum_dibayar">Belum Dibayar</option>
                        <option value="lunas">Lunas</option>
                    </select>
                </div>
            </div>
            
            <div class="p-5 border-t border-gray-100 flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Helper function for status colors
    <?php
    function getStatusColor($status) {
        switch ($status) {
            case 'pending': return 'bg-red-500';
            case 'diproses': return 'bg-green-500';
            case 'dikirim': return 'bg-yellow-500';
            case 'selesai': return 'bg-blue-500';
            case 'dibatalkan': return 'bg-gray-500';
            default: return 'bg-gray-500';
        }
    }
    ?>

    // Edit modal functions
    function openEditModal(id_order) {
        fetch("<?= site_url('pesanan/get_status/') ?>" + id_order)
            .then(response => {
                if (!response.ok) throw new Error("Gagal mengambil data");
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_id_order').value = id_order;
                document.getElementById('edit_status').value = data.stts_pemesanan;
                // Set payment status if available
                if (data.stts_pembayaran) {
                    document.getElementById('edit_payment_status').value = data.stts_pembayaran;
                }
                document.getElementById('modalEditPesanan').classList.remove('hidden');
            })
            .catch(error => {
                console.error("Error fetching order data:", error);
                showToast("Gagal memuat data pesanan", "error");
            });
    }

    function closeEditModal() {
        document.getElementById('modalEditPesanan').classList.add('hidden');
    }

    // Search and filter functionality
    document.getElementById('searchBtn').addEventListener('click', function() {
        const searchTerm = document.getElementById('searchInput').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        let url = '<?= site_url('pesanan') ?>';
        let params = [];
        
        if (searchTerm) {
            params.push('search=' + encodeURIComponent(searchTerm));
        }
        
        if (statusFilter) {
            params.push('status=' + encodeURIComponent(statusFilter));
        }
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        
        window.location.href = url;
    });

    // Allow search on Enter key
    document.getElementById('searchInput').addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            document.getElementById('searchBtn').click();
        }
    });

    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 z-50 bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 opacity-0 translate-y-[-20px]';
        
        const bgColor = type === 'success' ? 'bg-green-50 border-l-4 border-green-500' : 'bg-red-50 border-l-4 border-red-500';
        const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
        const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        toast.innerHTML = `
            <div class="flex items-center p-4 ${bgColor}">
                <div class="flex-shrink-0 mr-3">
                    <i class="fas ${icon} ${iconColor}"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium ${textColor}">${message}</p>
                </div>
                <div class="ml-3">
                    <button onclick="this.parentElement.parentElement.parentElement.classList.add('opacity-0', 'translate-y-[-20px]')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Trigger animation
        setTimeout(() => {
            toast.classList.remove('opacity-0', 'translate-y-[-20px]');
            toast.classList.add('opacity-100', 'translate-y-0');
        }, 10);
        
        // Auto dismiss
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-[-20px]');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }
</script>

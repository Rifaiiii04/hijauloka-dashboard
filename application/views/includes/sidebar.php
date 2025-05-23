<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('assets/') ;?>src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>
<body class="h-screen bg-gray-50">
<style>
.sidebar {
    box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar-item {
    position: relative;
    transition: all 0.3s ease;
}

.sidebar-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: rgba(255, 255, 255, 0.1);
    transition: width 0.3s ease;
}

.sidebar-item:hover::before {
    width: 100%;
}

.sidebar-item.active {
    background: rgba(255, 255, 255, 0.1);
    border-left: 4px solid #fff;
}

.sidebar-item.active::before {
    width: 100%;
}

.sidebar-icon {
    transition: transform 0.3s ease;
}

.sidebar-item:hover .sidebar-icon {
    transform: scale(1.1);
}

.logo-text {
    background: linear-gradient(90deg, #fff 0%, #e2e8f0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.menu-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.1) 50%, transparent 100%);
}
</style>

<aside class="sidebar bg-green-800 text-white fixed h-full w-64 p-6 flex flex-col z-50">
    <!-- Logo Section -->
    <div class="mb-10 px-2">
        <h1 class="text-3xl font-extrabold tracking-wide text-white">HijauLoka</h1>
        <p class="text-green-100 text-sm mt-1 opacity-75">Admin Dashboard</p>
    </div>

    <!-- Menu Divider -->
    <div class="menu-divider my-4"></div>

    <!-- Menu Items -->
    <nav class="flex-1">
        <ul class="space-y-2">
            <li>
                <a href="<?= base_url('dashboard'); ?>" 
                   class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
                    <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('produk'); ?>" 
                   class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white <?= ($this->uri->segment(1) == 'produk') ? 'active' : '' ?>">
                    <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <span class="text-sm font-medium">Produk</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('kategori'); ?>" 
                   class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white <?= ($this->uri->segment(1) == 'kategori') ? 'active' : '' ?>">
                    <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <span class="text-sm font-medium">Kategori</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('pesanan'); ?>" 
                   class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white <?= ($this->uri->segment(1) == 'pesanan') ? 'active' : '' ?>">
                    <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <span class="text-sm font-medium">Pesanan</span>
                    <?php 
                    $pending_count = $this->session->userdata('pending_orders_count');
                    if ($pending_count > 0): 
                    ?>
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">
                        <?= $pending_count ?>
                    </span>
                    <?php endif; ?>
                </a>
            </li>

            <li>
                <a href="<?= base_url('user'); ?>" 
                   class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white <?= ($this->uri->segment(1) == 'user') ? 'active' : '' ?>">
                    <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="text-sm font-medium">User</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('transaksi'); ?>" 
                   class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white <?= ($this->uri->segment(1) == 'transaksi') ? 'active' : '' ?>">
                    <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                        <i class="fa-solid fa-money-bills"></i>
                    </div>
                    <span class="text-sm font-medium">Transaksi</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('blog'); ?>" 
                   class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white <?= ($this->uri->segment(1) == 'blog') ? 'active' : '' ?>">
                    <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <span class="text-sm font-medium">Blog</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('review'); ?>" 
                   class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white <?= ($this->uri->segment(1) == 'review') ? 'active' : '' ?>">
                    <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <span class="text-sm font-medium">Review & Rating</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Menu Divider -->
    <div class="menu-divider my-4"></div>

    <!-- Logout Button -->
    <div class="mt-auto">
        <a href="<?= base_url('auth/logout'); ?>" 
           class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-white/90 hover:text-white hover:bg-red-500/10">
            <div class="sidebar-icon w-6 h-6 flex items-center justify-center">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <span class="text-sm font-medium">Logout</span>
        </a>
    </div>
</aside>

<script>
// Function to update pending orders count
function updatePendingCount() {
    fetch('<?= base_url('pesanan/get_pending_count') ?>')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.sidebar-item[href*="pesanan"] .rounded-full');
            if (data.count > 0) {
                if (badge) {
                    badge.textContent = data.count;
                } else {
                    const menuItem = document.querySelector('.sidebar-item[href*="pesanan"]');
                    const newBadge = document.createElement('span');
                    newBadge.className = 'ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse';
                    newBadge.textContent = data.count;
                    menuItem.appendChild(newBadge);
                }
            } else if (badge) {
                badge.remove();
            }
        });
}

// Update count every 30 seconds
setInterval(updatePendingCount, 30000);

// Initial update
document.addEventListener('DOMContentLoaded', updatePendingCount);
</script>

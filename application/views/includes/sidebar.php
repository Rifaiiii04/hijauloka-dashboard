<aside class="bg-slate-900 text-white fixed h-full w-64 p-5 flex flex-col shadow-xl border-r border-gray-700">
    <!-- Menu Sidebar -->
    <ul class="flex flex-col gap-4">
        <li>
            <a href="<?= base_url('dashboard'); ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 hover:text-white transition duration-300 <?= ($this->uri->segment(1) == 'dashboard') ? 'bg-green-600' : '' ?>">
                <i class="fa-solid fa-chart-line text-lg"></i>
                <span class="text-base">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('produk'); ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 hover:text-white transition duration-300 <?= ($this->uri->segment(1) == 'produk') ? 'bg-green-600' : '' ?>">
                <i class="fa-solid fa-seedling text-lg"></i>
                <span class="text-base">Produk</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('kategori'); ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 hover:text-white transition duration-300 <?= ($this->uri->segment(1) == 'kategori') ? 'bg-green-600' : '' ?>">
                <i class="fa-solid fa-layer-group text-lg"></i>
                <span class="text-base">Kategori</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('pesanan'); ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 hover:text-white transition duration-300 <?= ($this->uri->segment(1) == 'pesanan') ? 'bg-green-600' : '' ?>">
                <i class="fa-solid fa-receipt text-lg"></i>
                <span class="text-base">Pesanan</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('user'); ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 hover:text-white transition duration-300 <?= ($this->uri->segment(1) == 'user') ? 'bg-green-600' : '' ?>">
                <i class="fa-solid fa-user text-lg"></i>
                <span class="text-base">User</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('transaksi'); ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-700 hover:text-white transition duration-300 <?= ($this->uri->segment(1) == 'transaksi') ? 'bg-green-600' : '' ?>">
            <i class="fa-solid fa-money-bills"></i>
                <span class="text-base">Transaksi</span>
            </a>
        </li>
    </ul>
</aside>

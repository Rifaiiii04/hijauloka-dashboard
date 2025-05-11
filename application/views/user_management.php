<?php $this->load->view('includes/sidebar'); ?>

<main class="flex-1 ml-64 p-6 overflow-auto">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
        <p class="text-gray-600">Kelola data pengguna HijauLoka</p>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Cari pengguna..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar Profil</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $no = 1; foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $no++; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?= $user->nama; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500"><?= $user->email; ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500"><?= $user->alamat; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500"><?= $user->no_tlp; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($user->profile_image): ?>
                                <img src="<?= base_url('uploads/profile/' . $user->profile_image); ?>" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                            <?php else: ?>
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button onclick="hapusUser(<?= $user->id_user; ?>)" 
                                    class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="mt-6 flex justify-center">
            <nav class="flex items-center gap-2">
                <?php if ($current_page > 1): ?>
                    <a href="<?= site_url('user?page=' . ($current_page - 1)) ?>" 
                       class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-chevron-left mr-1"></i>
                        Previous
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="<?= site_url('user?page=' . $i) ?>" 
                       class="px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                              <?= ($i == $current_page) 
                                  ? 'bg-green-600 text-white' 
                                  : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="<?= site_url('user?page=' . ($current_page + 1)) ?>" 
                       class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Next
                        <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</main>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        let visibleRowIndex = 1;

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            const nama = cells[1].textContent.toLowerCase();
            const email = cells[2].textContent.toLowerCase();
            const alamat = cells[3].textContent.toLowerCase();
            const noTlp = cells[4].textContent.toLowerCase();
            
            const matches = nama.includes(searchTerm) || 
                          email.includes(searchTerm) || 
                          alamat.includes(searchTerm) || 
                          noTlp.includes(searchTerm);

            row.style.display = matches ? 'table-row' : 'none';
            
            if (matches) {
                cells[0].textContent = visibleRowIndex++;
            }
        });
    });

    function hapusUser(id) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            window.location.href = `<?= base_url('user/delete/') ?>${id}`;
        }
    }
</script>
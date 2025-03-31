<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<style>
    .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination ul {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination li a {
    display: block;
    padding: 8px 12px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #08644C;
    text-decoration: none;
    border-radius: 4px;
}

.pagination li.active a {
    background-color: #08644C;
    color: white;
    border-color: #08644C;
}

.pagination li a:hover {
    background-color: #e9ecef;
}
</style>

<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">User Management</h2>
        
        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Cari pengguna..." 
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full max-h-64 border-collapse border border-gray-300 text-center">
                <thead style="background-color: #08644C;">
                    <tr>
                        <th class="border border-gray-300 p-2 text-white">No</th>
                        <th class="border border-gray-300 p-2 text-white">Nama</th>
                        <th class="border border-gray-300 p-2 text-white">Email</th>
                        <th class="border border-gray-300 p-2 text-white">Alamat</th>
                        <th class="border border-gray-300 p-2 text-white">No. Telepon</th>
                        <th class="border border-gray-300 p-2 text-white">Gambar Profil</th>
                        <th class="border border-gray-300 p-2 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-100 max-h-14">
                        <td class="border border-gray-300 p-2"><?= $no++; ?></td>
                        <td class="border border-gray-300 p-2"><?= $user->nama; ?></td>
                        <td class="border border-gray-300 p-2"><?= $user->email; ?></td>
                        <td class="border border-gray-300 p-2"><?= $user->alamat; ?></td>
                        <td class="border border-gray-300 p-2"><?= $user->no_tlp; ?></td>
                        <td class="border border-gray-300 p-2">
                            <?php if ($user->profile_image): ?>
                                <img src="<?= base_url('uploads/profile/' . $user->profile_image); ?>" class="w-16 h-16 rounded-full">
                            <?php else: ?>
                                <span class="text-gray-500">Tidak ada gambar</span>
                            <?php endif; ?>
                        </td>
                        <td class="border border-gray-300 p-2">
                            <button onclick="hapusUser(<?= $user->id_user; ?>)" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
<div class="mt-4 flex justify-between items-center">
    <div class="text-sm text-gray-600">
        Menampilkan <?= count($users) ?> dari <?= $total_rows ?> pengguna
    </div>
    <div class="pagination">
        <?= $pagination ?>
    </div>
</div>
        </div>
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
        if (confirm('Yakin ingin menghapus user ini?')) {
            window.location.href = `<?= base_url('user/delete/') ?>${id}`;
        }
    }
</script>
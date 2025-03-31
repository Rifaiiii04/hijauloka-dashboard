<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">User Management</h2>
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
        </div>
    </div>
</main>

<script>
    function hapusUser(id) {
        if (confirm('Yakin ingin menghapus user ini?')) {
            window.location.href = `<?= base_url('user/delete/') ?>${id}`;
        }
    }
</script>
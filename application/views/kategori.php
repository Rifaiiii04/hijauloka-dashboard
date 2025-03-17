<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Kategori</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
                <thead class="bg-green-500">
                    <tr>
                        <th class="border border-gray-300 p-2 text-white">No</th>
                        <th class="border border-gray-300 p-2 text-white">Nama Kategori</th>
                        <th class="border border-gray-300 p-2 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($kategori as $k): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 p-2"><?= $no++; ?></td>
                        <td class="border border-gray-300 p-2"><?= $k->nama_kategori; ?></td>
                        <td class="border border-gray-300 p-2">
                            <button onclick="editKategori(<?= $k->id_kategori; ?>)" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">Edit</button>
                            <button onclick="hapusKategori(<?= $k->id_kategori; ?>)" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 ml-2">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-10 text-right">
            <button onclick="tambahKategori()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">+ Tambah Kategori</button>
        </div>
    </div>
</main>

<!-- Modal Pop-up -->
<div id="modalKategori" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Tambah Kategori</h2>
        <form id="kategoriForm" method="POST" action="<?= base_url('kategori/store'); ?>">
            <input type="hidden" name="id_kategori" id="id_kategori">
            <div class="mb-4">
                <label class="block">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="w-full border p-2 rounded-lg" required>
            </div>
            <div class="text-right">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function tambahKategori() {
        document.getElementById('kategoriForm').reset();
        document.getElementById('modalTitle').innerText = 'Tambah Kategori';
        document.getElementById('modalKategori').classList.remove('hidden');
    }

    function editKategori(id) {
        fetch(`<?= base_url('kategori/edit/') ?>${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id_kategori').value = data.id_kategori;
                document.getElementById('nama_kategori').value = data.nama_kategori;
                document.getElementById('modalTitle').innerText = 'Edit Kategori';
                document.getElementById('modalKategori').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('modalKategori').classList.add('hidden');
    }

    function hapusKategori(id) {
        if (confirm('Yakin ingin menghapus kategori ini?')) {
            window.location.href = `<?= base_url('kategori/delete/') ?>${id}`;
        }
    }
</script>

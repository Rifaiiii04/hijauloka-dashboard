<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<main class="flex-1 ml-64 p-6 overflow-auto">
    <div class="mt-10 bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
            
            <!-- Search Bar -->
            <div class="flex gap-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari produk..." 
                           class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 ease-in-out">
                    <!-- <i class="fas fa-search absolute top-56  text-gray-400"></i> -->
                </div>
                <button onclick="tambahProduk()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200 ease-in-out">
                    <i class="fa-solid fa-plus"></i> Tambah Produk
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full max-h-64 border-collapse border border-gray-300 text-center">
                <thead style="background-color: #08644C;">
                    <tr>
                        <th class="border border-gray-300 p-2 text-white">No</th>
                        <th class="border border-gray-300 p-2 text-white">Nama</th>
                        <!-- <th class="border border-gray-300 p-2 text-white">Deskripsi</th> -->
                        <th class="border border-gray-300 p-2 text-white">Kategori</th>
                        <th class="border border-gray-300 p-2 text-white">Harga</th>
                        <th class="border border-gray-300 p-2 text-white">Stok</th>
                        <th class="border border-gray-300 p-2 text-white">Gambar</th>
                        <th class="border border-gray-300 p-2 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <?php $no = 1; foreach ($produk as $p): ?>
                    <tr class="hover:bg-gray-100 max-h-14">
                        <td class="border border-gray-300 p-2"><?= $no++; ?></td>
                        <td class="border border-gray-300 p-2"><?= $p->nama_product; ?></td>
                        <!-- <td class="border border-gray-300 p-2 max-w-32 max-h-5 overflow-x-auto"><?= $p->desk_product; ?></td> -->
                        <td class="border border-gray-300 p-2"><?= $p->nama_kategori; ?></td>
                        <td class="border border-gray-300 p-2">Rp <?= number_format($p->harga, 2, ',', '.'); ?></td>
                        <td class="border border-gray-300 p-2"><?= $p->stok; ?></td>
                        <td class="border border-gray-300 p-2">
                        <?php 
$gambarArr = explode(',', $p->gambar);
foreach ($gambarArr as $gmbr): ?>
    <img src="<?= base_url('uploads/' . trim($gmbr)); ?>" class="w-16 h-16 inline-block mr-1">
<?php endforeach; ?>


                        </td>
                        <td class="border border-gray-300 p-2">
                            <button onclick="editProduk(<?= $p->id_product; ?>)" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button onclick="hapusProduk(<?= $p->id_product; ?>)" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 ml-2"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Tambah Produk -->
<div id="modalProduk" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-4 my-16">
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Tambah Produk</h2>
        <form id="produkForm" action="<?= base_url('produk/store') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_product" id="id_product">
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block">Nama Produk</label>
                    <input type="text" name="nama_product" id="nama_product" class="w-full border p-2 rounded-lg" required>
                </div>
                <div>
                    <label class="block">Harga</label>
                    <input type="number" name="harga" id="harga" class="w-full border p-2 rounded-lg" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block">Deskripsi</label>
                <textarea name="desk_product" id="desk_product" class="w-full border p-2 rounded-lg" required></textarea>
            </div>
            <dib class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                <label class="block">Kategori</label>
    <?php foreach ($kategori as $k): ?>
        <label class="inline-flex items-center mr-4">
            <input type="checkbox" name="id_kategori[]" value="<?= $k->id_kategori; ?>" class="form-checkbox">
            <span class="ml-2"><?= $k->nama_kategori; ?></span>
        </label>
    <?php endforeach; ?>
                </div>
                <div>
                    <label class="block">Stok</label>
                    <input type="number" name="stok" id="stok" class="w-full border p-2 rounded-lg" required>
                </div>
            </dib>
            <div class="mb-4">
                <label class="block">Gambar (minimal 1, maksimal 5)</label>
                <input type="file" name="gambar[]" class="w-full border p-2 rounded-lg" multiple required>
            </div>
            <div class="text-right">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Produk -->
<div id="modalEditProduk" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-4 my-16">
        <h2 class="text-xl font-bold mb-4">Edit Produk</h2>
        <form id="editProdukForm" action="<?= base_url('produk/update') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_product" id="edit_id_product">
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block">Nama Produk</label>
                    <input type="text" name="nama_product" id="edit_nama_product" class="w-full border p-2 rounded-lg" required>
                </div>
                <div>
                    <label class="block">Harga</label>
                    <input type="number" name="harga" id="edit_harga" class="w-full border p-2 rounded-lg" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block">Deskripsi</label>
                <textarea name="desk_product" id="edit_desk_product" class="w-full border p-2 rounded-lg" required></textarea>
            </div>
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                <label class="block">Kategori</label>
    <?php foreach ($kategori as $k): ?>
        <label class="inline-flex items-center mr-4">
            <input type="checkbox" name="id_kategori[]" value="<?= $k->id_kategori; ?>" class="form-checkbox">
            <span class="ml-2"><?= $k->nama_kategori; ?></span>
        </label>
    <?php endforeach; ?>
                </div>
                <div>
                    <label class="block">Stok</label>
                    <input type="number" name="stok" id="edit_stok" class="w-full border p-2 rounded-lg" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block">Gambar (minimal 1, maksimal 5)</label>
                <input type="file" name="gambar[]" class="w-full border p-2 rounded-lg" multiple>
                <!-- Simpan nama file lama dalam format comma separated -->
                <input type="hidden" name="gambar_lama" id="edit_gambar_lama">
            </div>
            <div class="text-right">
                <button type="button" onclick="closeModalEdit()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function tambahProduk() {
        document.getElementById('produkForm').reset();
        document.getElementById('modalTitle').innerText = "Tambah Produk";
        document.getElementById('produkForm').action = "<?= base_url('produk/store') ?>";
        document.getElementById('modalProduk').classList.remove('hidden');
    }

    function editProduk(id) {
    console.log("Memanggil editProduk dengan ID:", id);
    fetch("<?= base_url('produk/edit/') ?>" + id)
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error! Status: " + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log("Data dari server:", data);
            if (!data.produk) {
                alert("Data produk tidak ditemukan!");
                return;
            }
            document.getElementById('edit_id_product').value = data.produk.id_product;
            document.getElementById('edit_nama_product').value = data.produk.nama_product;
            document.getElementById('edit_desk_product').value = data.produk.desk_product;
            document.getElementById('edit_harga').value = data.produk.harga;
            document.getElementById('edit_stok').value = data.produk.stok;
            document.getElementById('edit_gambar_lama').value = data.produk.gambar;

            let kategoriCheckboxes = document.querySelectorAll('input[name="id_kategori[]"]');
            kategoriCheckboxes.forEach(checkbox => {
                checkbox.checked = data.selected_categories.includes(checkbox.value);
            });

            document.getElementById('modalEditProduk').classList.remove('hidden');
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            alert("Terjadi kesalahan saat mengambil data produk.");
        });
}


    function hapusProduk(id) {
        if (confirm('Yakin ingin menghapus produk ini?')) {
            window.location.href = "<?= base_url('produk/delete/') ?>" + id;
        }
    }

    function closeModal() {
        document.getElementById('modalProduk').classList.add('hidden');
    }

    function closeModalEdit() {
        document.getElementById('modalEditProduk').classList.add('hidden');
    }


// Add this new search function
document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const tableBody = document.getElementById('productTableBody');
    const rows = tableBody.getElementsByTagName('tr');

    for (let row of rows) {
        const namaProduk = row.getElementsByTagName('td')[1].textContent.toLowerCase();
        const kategori = row.getElementsByTagName('td')[2].textContent.toLowerCase();
        
        if (namaProduk.includes(searchValue) || kategori.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});
</script>


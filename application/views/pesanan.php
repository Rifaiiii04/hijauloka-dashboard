<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Konten Utama -->
<main class="flex-1 ml-64 p-6 overflow-auto">
    <!-- Tabel Pesanan -->
    <div class="mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Pesanan</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
                <thead class="bg-green-500">
                    <tr>
                        <th class="border border-gray-300 p-2 text-white">No</th>
                        <th class="border border-gray-300 p-2 text-white">Nama Pelanggan</th>
                        <th class="border border-gray-300 p-2 text-white">Tanggal Pesan</th>
                        <th class="border border-gray-300 p-2 text-white">Total Harga</th>
                        <th class="border border-gray-300 p-2 text-white">Status</th>
                        <th class="border border-gray-300 p-2 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh Data Statis -->
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 p-2">1</td>
                        <td class="border border-gray-300 p-2">John Doe</td>
                        <td class="border border-gray-300 p-2">2023-10-01</td>
                        <td class="border border-gray-300 p-2">Rp 250.000</td>
                        <td class="border border-gray-300 p-2">
                            <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-sm">Pending</span>
                        </td>
                        <td class="border border-gray-300 p-2">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">Detail</button>
                            <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 ml-2">Hapus</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 p-2">2</td>
                        <td class="border border-gray-300 p-2">Jane Smith</td>
                        <td class="border border-gray-300 p-2">2023-10-02</td>
                        <td class="border border-gray-300 p-2">Rp 150.000</td>
                        <td class="border border-gray-300 p-2">
                            <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-sm">Selesai</span>
                        </td>
                        <td class="border border-gray-300 p-2">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">Detail</button>
                            <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 ml-2">Hapus</button>
                        </td>
                    </tr>
                    <!-- Tambahkan baris lain sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
    </div>
</main>

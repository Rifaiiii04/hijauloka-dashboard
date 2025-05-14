
<?php $this->load->view('includes/sidebar'); ?>

<div class="ml-64 p-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Review & Rating</h1>
            
            <div class="flex space-x-2">
                <a href="<?= base_url('review?status=pending'); ?>" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                    <i class="fas fa-clock mr-2"></i> Pending
                </a>
                <a href="<?= base_url('review?status=disetujui'); ?>" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                    <i class="fas fa-check mr-2"></i> Disetujui
                </a>
                <a href="<?= base_url('review?status=ditolak'); ?>" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-times mr-2"></i> Ditolak
                </a>
                <a href="<?= base_url('review'); ?>" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i> Semua
                </a>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <form action="<?= base_url('review'); ?>" method="get" class="flex flex-wrap gap-4">
                <div class="w-64">
                    <label for="product" class="block text-sm font-medium text-gray-700 mb-1">Filter Produk</label>
                    <select name="product" id="product" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Semua Produk</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product->id_product ?>" <?= $this->input->get('product') == $product->id_product ? 'selected' : '' ?>>
                                <?= $product->nama_product ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="w-64">
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Filter Rating</label>
                    <select name="rating" id="rating" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Semua Rating</option>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <option value="<?= $i ?>" <?= $this->input->get('rating') == $i ? 'selected' : '' ?>>
                                <?= $i ?> Bintang
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="w-64 flex items-end">
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p><?= $this->session->flashdata('success'); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?= $this->session->flashdata('error'); ?></p>
            </div>
        <?php endif; ?>
        
        <!-- Reviews Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ulasan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($reviews)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada review yang ditemukan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $review->nama_product ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $review->nama_user ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $review->rating): ?>
                                                <i class="fas fa-star text-yellow-400"></i>
                                            <?php else: ?>
                                                <i class="far fa-star text-yellow-400"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 truncate max-w-xs"><?= substr($review->ulasan, 0, 50) . (strlen($review->ulasan) > 50 ? '...' : '') ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= date('d M Y', strtotime($review->tgl_review)) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($review->stts_review == 'pending'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    <?php elseif ($review->stts_review == 'disetujui'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="<?= base_url('review/view/' . $review->id_review) ?>" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($review->stts_review == 'pending'): ?>
                                            <a href="<?= base_url('review/approve/' . $review->id_review) ?>" class="text-green-600 hover:text-green-900" onclick="return confirm('Apakah Anda yakin ingin menyetujui review ini?')">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="<?= base_url('review/reject/' . $review->id_review) ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menolak review ini?')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('review/delete/' . $review->id_review) ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
</div>


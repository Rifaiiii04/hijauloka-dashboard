
<?php $this->load->view('includes/sidebar'); ?>

<div class="ml-64 p-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Review</h1>
            
            <div class="flex space-x-2">
                <a href="<?= base_url('review'); ?>" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                
                <?php if ($review->stts_review == 'pending'): ?>
                    <a href="<?= base_url('review/approve/' . $review->id_review); ?>" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menyetujui review ini?')">
                        <i class="fas fa-check mr-2"></i> Setujui
                    </a>
                    <a href="<?= base_url('review/reject/' . $review->id_review); ?>" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menolak review ini?')">
                        <i class="fas fa-times mr-2"></i> Tolak
                    </a>
                <?php endif; ?>
                
                <a href="<?= base_url('review/delete/' . $review->id_review); ?>" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </a>
            </div>
        </div>
        
        <!-- Review Details -->
        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Review</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Status:</span>
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
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Tanggal Review:</span>
                            <span class="text-gray-900"><?= date('d M Y H:i', strtotime($review->tgl_review)) ?></span>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Rating:</span>
                            <div class="flex items-center">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $review->rating): ?>
                                        <i class="fas fa-star text-yellow-400"></i>
                                    <?php else: ?>
                                        <i class="far fa-star text-yellow-400"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span class="ml-2 text-gray-900">(<?= $review->rating ?> dari 5)</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Produk</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Nama Produk:</span>
                            <span class="text-gray-900"><?= $review->nama_product ?></span>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">ID Produk:</span>
                            <span class="text-gray-900"><?= $review->id_product ?></span>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">ID Order:</span>
                            <span class="text-gray-900"><?= $review->id_order ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi User</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Nama User:</span>
                        <span class="text-gray-900"><?= $review->nama_user ?></span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">ID User:</span>
                        <span class="text-gray-900"><?= $review->id_user ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 p-6 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Ulasan</h2>
            
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <p class="text-gray-800"><?= nl2br($review->ulasan) ?></p>
            </div>
        </div>
    </div>
</div>


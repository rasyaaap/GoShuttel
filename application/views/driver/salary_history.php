<?php $this->load->view('layout/header', ['title' => 'Riwayat Gaji']); ?>

<div class="bg-gray-100 min-h-screen pb-20">
    <div class="bg-white px-4 py-4 shadow-sm flex items-center sticky top-0 z-50">
        <a href="<?= base_url('driver/account') ?>" class="mr-4 text-gray-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-lg font-bold text-gray-800">Riwayat Gaji</h1>
    </div>

    <div class="p-6">
        <?php if(empty($salary)): ?>
            <div class="text-center py-10">
                <div class="bg-gray-50 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-gray-500">Belum ada riwayat gaji.</p>
            </div>
        <?php else: ?>
            <?php foreach($salary as $s): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-4 relative overflow-hidden">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="text-xs text-gray-400 font-mono mb-1">#INV-<?= str_pad($s->id, 5, '0', STR_PAD_LEFT) ?></p>
                        <h4 class="font-bold text-gray-800 text-lg"><?= $s->note ?: 'Pembayaran Gaji' ?></h4>
                        <p class="text-xs text-gray-500 mt-1">
                            <?= date('d M Y, H:i', strtotime($s->payment_date)) ?> 
                            &bull; Oleh: <?= $s->admin_name ?: 'System' ?>
                        </p>
                    </div>
                </div>
                
                <div class="flex justify-between items-end mt-4 pt-4 border-t border-dashed border-gray-200">
                    <div>
                         <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase tracking-wide">Lunas</span>
                    </div>
                    <div class="text-right">
                        <span class="block text-xs text-gray-400">Total Terima</span>
                        <span class="text-xl font-bold text-green-600 font-mono">
                            Rp <?= number_format($s->amount, 0, ',', '.') ?>
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 text-right">
                    <!-- Target hidden iframe for direct download -->
                    <a href="<?= base_url('driver/salary_slip/' . $s->id) ?>" target="hidden_downloader" class="inline-block px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2-4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Download Struk
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Hidden Iframe for background processing -->
    <iframe name="hidden_downloader" style="width:1000px; height:2000px; position:fixed; top:-9999px; left:-9999px; visibility:hidden;"></iframe>
</div>

<?php $this->load->view('layout/footer'); ?>

<div class="max-w-3xl mx-auto px-4 py-8 min-h-screen">
    <div class="flex items-center mb-8">
        <a href="<?= base_url('customer/dashboard') ?>" class="bg-white p-2 rounded-full shadow-sm border border-gray-100 mr-4 text-gray-500 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Riwayat Perjalanan</h1>
    </div>

    <?php if(empty($bookings)): ?>
        <div class="bg-white rounded-2xl p-10 text-center shadow-sm border border-gray-100">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-gray-900 font-bold mb-1">Belum ada riwayat</h3>
            <p class="text-gray-500 text-sm">Anda belum melakukan perjalanan sebelumnya.</p>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach($bookings as $b): ?>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 opacity-90 hover:opacity-100 transition-opacity">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1"><?= date('d M Y', strtotime($b->tanggal)) ?></p>
                            <h4 class="font-bold text-lg text-gray-600"><?= date('H:i', strtotime($b->jam_berangkat)) ?> WIB</h4>
                        </div>
                        <?php if($b->is_picked_up): ?>
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase bg-green-100 text-green-600 border border-green-200">
                                Sudah Dijemput
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase bg-gray-100 text-gray-500">
                                Selesai
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="flex items-center space-x-3 mb-4 relative">
                        <!-- Origin -->
                        <div class="relative z-10 flex items-center">
                            <div class="w-2 h-2 rounded-full bg-gray-300 mr-3"></div>
                            <span class="text-sm font-medium text-gray-500"><?= $b->kota_asal ?></span>
                        </div>
                        
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>

                        <!-- Destination -->
                        <div class="relative z-10 flex items-center">
                             <span class="text-sm font-bold text-gray-700"><?= $b->kota_tujuan ?></span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-50 flex justify-between items-center text-xs text-gray-500">
                        <div>
                            Order ID: <span class="font-mono"><?= $b->id ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <?php if($b->status_pembayaran == 'lunas'): ?>
                                <a href="<?= base_url('booking/ticket/'.$b->id) ?>" class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-md font-bold hover:bg-indigo-100 transition-colors">
                                    Lihat Tiket
                                </a>
                            <?php elseif($b->status_pembayaran == 'pending'): ?>
                                <a href="<?= base_url('booking/payment/'.$b->id) ?>" class="px-3 py-1 bg-orange-50 text-orange-600 rounded-md font-bold hover:bg-orange-100 transition-colors">
                                    Bayar
                                </a>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-md font-bold">
                                    <?= ucfirst($b->status_pembayaran) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

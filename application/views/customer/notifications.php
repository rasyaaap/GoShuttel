<div class="max-w-3xl mx-auto px-4 py-8 min-h-screen">
    <div class="flex items-center mb-8">
        <a href="<?= base_url('customer/dashboard') ?>" class="bg-white p-2 rounded-full shadow-sm border border-gray-100 mr-4 text-gray-500 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
    </div>

    <div class="space-y-4">
        <?php if(empty($notifications)): ?>
            <div class="bg-white rounded-2xl p-10 text-center shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h3 class="text-gray-900 font-bold mb-1">Tidak ada notifikasi</h3>
                <p class="text-gray-500 text-sm">Anda belum memiliki pesan atau pemberitahuan baru.</p>
            </div>
        <?php else: ?>
            <?php foreach($notifications as $n): ?>
                <a href="<?= base_url('customer/notification_detail/'.$n->id) ?>" class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-start hover:shadow-md transition-shadow relative block group">
                    <!-- Icon based on sender/content -->
                    <div class="flex-shrink-0 mr-4">
                        <?php if($n->sender_role == 'driver'): ?>
                            <!-- Driver Icon -->
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            </div>
                        <?php else: // Admin or System ?>
                            <?php if(stripos($n->message, 'DITERIMA') !== false || stripos($n->message, 'Lunas') !== false || stripos($n->message, 'DIJEMPUT') !== false): ?>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            <?php elseif(stripos($n->message, 'DITOLAK') !== false): ?>
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                            <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex-1 w-full min-w-0"> <!-- min-w-0 required for flex child textual truncation -->
                        <h4 class="text-sm font-bold text-gray-900 mb-1 flex justify-between items-center">
                            <span>
                                <?php 
                                    if($n->sender_role == 'driver') {
                                        echo "Pesan dari " . ucwords($n->sender_name);
                                    } else {
                                        if(stripos($n->message, 'DITERIMA') !== false) { echo "Pembayaran Berhasil"; }
                                        elseif(stripos($n->message, 'DITOLAK') !== false) { echo "Pembayaran Gagal"; }
                                        elseif(stripos($n->message, 'DIJEMPUT') !== false) { echo "Status Penjemputan"; }
                                        else { echo "Info dari Admin"; }
                                    }
                                ?>
                            </span>
                            <?php if(isset($n->is_read) && $n->is_read == 0): ?>
                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                            <?php endif; ?>
                        </h4>
                        <!-- Multi-line clamp for better preview -->
                        <p class="text-sm text-gray-600 leading-relaxed mb-3 line-clamp-2"><?= $n->message ?></p>
                        
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-[10px] text-gray-400 font-medium"><?= date('d M Y H:i', strtotime($n->created_at)) ?></p>
                            <span class="text-xs font-bold text-indigo-600 group-hover:underline flex items-center">
                                Lihat Detail 
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

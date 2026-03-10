<div class="max-w-xl mx-auto px-4 py-8 min-h-screen">
    <!-- Header Back -->
    <div class="flex items-center mb-6">
        <a href="<?= base_url('customer/notifications') ?>" class="bg-white p-2 rounded-full shadow-sm border border-gray-100 mr-4 text-gray-500 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-900">Detail Notifikasi</h1>
    </div>

    <!-- Notification Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header Section -->
        <div class="px-6 py-6 border-b border-gray-50 flex items-start">
            <div class="flex-shrink-0 mr-4">
                 <?php if($n->sender_role == 'driver'): ?>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                <?php else: ?>
                     <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                 <h2 class="text-lg font-bold text-gray-900">
                    <?php 
                        if($n->sender_role == 'driver') echo "Pesan dari " . $n->sender_name;
                        else echo "Info dari Admin"; 
                    ?>
                </h2>
                <p class="text-sm text-gray-500"><?= date('l, d F Y - H:i', strtotime($n->created_at)) ?></p>
            </div>
        </div>

        <!-- Body Content -->
        <div class="px-6 py-8">
            <div class="prose prose-indigo max-w-none text-gray-700">
                <?= nl2br($n->message) ?>
            </div>
        </div>

        <!-- Actions -->
        <?php if($n->sender_role == 'driver'): ?>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                 <a href="<?= base_url('chat/with_driver/'.$n->sender_id) ?>" class="block w-full text-center bg-indigo-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-xl transition-all">
                    Balas Pesan
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

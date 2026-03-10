<div class="max-w-3xl mx-auto px-4 py-6 min-h-screen pb-20">
    <div class="flex items-center mb-6">
        <a href="<?= base_url('driver/dashboard') ?>" class="mr-4 text-gray-500 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-900">Pesan & Chat</h1>
    </div>

    <!-- Conversations List -->
    <div class="space-y-3">
        <?php foreach($conversations as $c): ?>
            <?php 
                // Determine Link
                if($c->role == 'admin') {
                    // Assuming ID 1 is the main admin or the chat/index handles it
                    // Actually Chat controller logic needs a specific route for admin or just uses ID
                    $url = base_url('chat/with_customer/' . $c->partner_id); // Wait, with_customer uses the ID passed as partner. 
                    // But if I am driver, and he is admin... 
                    // Let's check Chat::with_customer method. 
                    // It loads chat/index with $partner_id. 
                    // It's generic enough.
                    // Ideally we should have chat/with_admin but let's see. 
                    // The Chat Controller has `with_customer` (Driver -> Customer) and `with_driver` (Admin -> Driver).
                    // Driver -> Admin logic was `get_admin_messages` (AJAX). 
                    // The `chat/index` auto-detects if partner_id is set or not.
                    // If I treat Admin as a partner with ID, I need to make sure `chat/index` handles it.
                    // Currently `chat/index` says: if(partner_id) fetchUrl = get_messages/id.
                    // If NOT partner_id, fetchUrl = get_admin_messages.
                    
                    if($c->role == 'admin') {
                         // Link to page WITHOUT ID, so it defaults to Admin mode in JS
                         $url = base_url('chat'); 
                         $subtitle = "Administrator";
                         $bg = "bg-indigo-100 text-indigo-600";
                    } else {
                         // Customer
                         $url = base_url('chat/with_customer/' . $c->partner_id);
                         $subtitle = "Penumpang";
                         $bg = "bg-yellow-100 text-yellow-600";
                    }
                } else {
                     // Default fallback (e.g. other driver?)
                     $url = base_url('chat/with_customer/' . $c->partner_id);
                     $subtitle = ucfirst($c->role);
                     $bg = "bg-gray-100 text-gray-600";
                }
            ?>
            
            <a href="<?= $url ?>" class="block bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 transition flex items-center">
                <div class="w-12 h-12 rounded-full <?= $bg ?> flex items-center justify-center font-bold text-lg mr-4 shrink-0">
                    <?= strtoupper(substr($c->name, 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-center mb-1">
                        <h3 class="font-bold text-gray-900 truncate"><?= $c->name ?></h3>
                        <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-500"><?= $subtitle ?></span>
                    </div>
                    <p class="text-sm text-gray-500 truncate">Klik untuk melihat riwayat chat...</p>
                </div>
                <div class="ml-2">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
        <?php endforeach; ?>

        <?php if(empty($conversations)): ?>
            <div class="text-center py-10 text-gray-400">
                <p>Belum ada riwayat chat.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

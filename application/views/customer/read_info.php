<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 pb-20">
    <!-- Header / Cover Area -->
    <div class="relative bg-indigo-600 h-48 md:h-64 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute -top-16 -left-16 w-64 h-64 bg-indigo-300 opacity-10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 text-center px-4">
            <?php 
                $badgeColor = 'bg-white/20 text-white';
                if($info->info_type == 'promo') $badgeColor = 'bg-pink-500/20 text-pink-50 border border-pink-400/30';
                if($info->info_type == 'warning') $badgeColor = 'bg-amber-500/20 text-amber-50 border border-amber-400/30';
            ?>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3 backdrop-blur-sm <?= $badgeColor ?>">
                <?= $info->tag_text ?: ucfirst($info->info_type) ?>
            </span>
            <h1 class="text-2xl md:text-4xl font-bold text-white max-w-2xl mx-auto leading-tight">
                <?= $info->title ?>
            </h1>
            <p class="text-indigo-100 text-sm mt-2">Diposting pada <?= date('d M Y', strtotime($info->created_at)) ?></p>
        </div>
    </div>

    <!-- Content Area -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 relative -mt-10 z-20">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-10">
            <div class="prose prose-indigo max-w-none text-gray-700">
                <?= nl2br($info->content) ?>
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
                <a href="<?= base_url('customer/dashboard') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Dashboard
                </a>
                
                <!-- Share Button (Optional Visual) -->
                <button type="button" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</main>

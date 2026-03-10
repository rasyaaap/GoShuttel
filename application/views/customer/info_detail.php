<div class="max-w-2xl mx-auto px-4 py-8 min-h-screen">
    <!-- Header Back -->
    <div class="flex items-center mb-6 absolute top-8 left-4 z-20">
        <a href="<?= base_url('customer/dashboard') ?>" class="bg-white/80 backdrop-blur p-2 rounded-full shadow-sm border border-gray-100 mr-4 text-gray-800 hover:text-black transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
    </div>

    <!-- Hero Image -->
    <div class="rounded-3xl overflow-hidden shadow-2xl mb-8 relative bg-gray-200 aspect-video flex items-center justify-center">
        <!-- Placeholder Pattern if image missing -->
        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-600 to-purple-600 opacity-90"></div>
        <div class="relative z-10 text-center text-white px-6">
             <h1 class="text-3xl font-bold mb-2"><?= $title ?></h1>
             <p class="text-white/80"><?= $content['subtitle'] ?></p>
        </div>
        <!-- Actual Image Tag (Commented out until real assets exist) -->
        <!-- <img src="<?= base_url($content['image']) ?>" alt="<?= $title ?>" class="absolute inset-0 w-full h-full object-cover"> -->
    </div>

    <!-- Content -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4"><?= $content['subtitle'] ?></h2>
        
        <div class="prose prose-lg prose-indigo text-gray-600">
            <?= $content['body'] ?>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100">
             <a href="<?= base_url('booking') ?>" class="block w-full text-center bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-xl transition-all">
                Mulai Pesan Tiket Sekarang
            </a>
        </div>
    </div>
</div>

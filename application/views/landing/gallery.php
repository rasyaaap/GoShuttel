<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto - Raaster Shuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

<!-- Navbar -->
<!-- Navbar -->
<nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="<?= base_url() ?>" class="flex items-center gap-2 group">
                    <span class="text-xl font-bold text-gray-900 tracking-tighter group-hover:text-indigo-700 transition">Raaster<span class="text-indigo-500">.</span></span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?= base_url('#home') ?>" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors relative group">
                    Beranda
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="<?= base_url('#features') ?>" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors relative group">
                    Layanan
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="<?= base_url('#routes') ?>" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors relative group">
                    Rute & Harga
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                 <a href="<?= base_url('landing/gallery') ?>" class="text-sm font-medium text-indigo-600 transition-colors relative group">
                    Galeri
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-600 transform scale-x-100 transition-transform origin-left"></span>
                </a>
            </div>

            <!-- Desktop Actions -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="<?= base_url('auth/login') ?>" class="text-sm font-bold text-gray-600 hover:text-indigo-600 transition px-4 py-2">Masuk</a>
                <a href="<?= base_url('auth/register') ?>" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-200 transition-all hover:scale-105">
                    Daftar Sekarang
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex md:hidden">
                <button type="button" id="mobile-menu-btn" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg class="block h-6 w-6" id="menu-icon-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg class="hidden h-6 w-6" id="menu-icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Panel -->
    <div class="hidden md:hidden bg-white border-t border-gray-100" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="<?= base_url('#home') ?>" class="block pl-3 pr-4 py-3 border-l-4 border-indigo-500 text-base font-medium text-indigo-700 bg-indigo-50 rounded-r-md">Beranda</a>
            <a href="<?= base_url('#features') ?>" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 rounded-r-md">Layanan</a>
            <a href="<?= base_url('#routes') ?>" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 rounded-r-md">Rute & Harga</a>
             <a href="<?= base_url('landing/gallery') ?>" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-indigo-600 bg-indigo-50 rounded-r-md">Galeri</a>
        </div>
        <div class="pt-4 pb-6 border-t border-gray-200 px-4">
            <div class="flex items-center gap-3">
                <a href="<?= base_url('auth/login') ?>" class="flex-1 w-full justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                    Masuk
                </a>
                <a href="<?= base_url('auth/register') ?>" class="flex-1 w-full justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-md">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900">Galeri Kami</h1>
        <p class="mt-4 text-gray-500">Momen terbaik dan dokumentasi layanan Raaster Shuttle.</p>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap justify-center gap-4 mb-12" id="gallery-filters">
        <button onclick="filterGallery('semua')" class="filter-btn active px-6 py-2 rounded-full border transition font-bold text-sm bg-indigo-600 text-white border-indigo-600 shadow-lg shadow-indigo-200" data-filter="semua">Semua</button>
        <button onclick="filterGallery('armada')" class="filter-btn px-6 py-2 rounded-full border border-gray-200 bg-white text-gray-600 hover:border-indigo-600 hover:text-indigo-600 transition font-bold text-sm" data-filter="armada">Armada</button>
        <button onclick="filterGallery('fasilitas')" class="filter-btn px-6 py-2 rounded-full border border-gray-200 bg-white text-gray-600 hover:border-indigo-600 hover:text-indigo-600 transition font-bold text-sm" data-filter="fasilitas">Fasilitas</button>
        <button onclick="filterGallery('kegiatan')" class="filter-btn px-6 py-2 rounded-full border border-gray-200 bg-white text-gray-600 hover:border-indigo-600 hover:text-indigo-600 transition font-bold text-sm" data-filter="kegiatan">Kegiatan</button>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6" id="gallery-grid">
        <?php if(!empty($gallery)): ?>
            <?php foreach($gallery as $g): ?>
                <?php 
                    // Normalize category for filtering (lowercase)
                    $cat = strtolower($g->category); 
                ?>
                <div class="gallery-item group relative aspect-square rounded-2xl overflow-hidden bg-white shadow-sm border border-gray-100 cursor-pointer hover:shadow-xl transition-all duration-300" data-category="<?= $cat ?>">
                    <img src="<?= $g->image ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <div class="text-center p-4">
                            <span class="inline-block px-2 py-1 bg-indigo-600 text-[10px] font-bold uppercase tracking-widest text-white rounded mb-2"><?= $g->category ?></span>
                            <h4 class="text-white font-bold text-lg"><?= $g->title ?></h4>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-20 text-gray-400">
                Belum ada foto.
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function filterGallery(category) {
        // Update Buttons
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            if (btn.dataset.filter === category) {
                btn.className = 'filter-btn active px-6 py-2 rounded-full border transition font-bold text-sm bg-indigo-600 text-white border-indigo-600 shadow-lg shadow-indigo-200';
            } else {
                btn.className = 'filter-btn px-6 py-2 rounded-full border border-gray-200 bg-white text-gray-600 hover:border-indigo-600 hover:text-indigo-600 transition font-bold text-sm';
            }
        });

        // Filter Items
        const items = document.querySelectorAll('.gallery-item');
        items.forEach(item => {
            const itemCat = item.dataset.category;
            if (category === 'semua' || itemCat.includes(category)) {
                item.style.display = 'block';
                // Optional: Add Animation
                item.classList.remove('opacity-0', 'scale-95');
                item.classList.add('opacity-100', 'scale-100');
            } else {
                item.style.display = 'none';
                item.classList.remove('opacity-100', 'scale-100');
                item.classList.add('opacity-0', 'scale-95');
            }
        });
    }
</script>

<footer class="bg-white border-t border-gray-100 py-12 mt-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-gray-400 text-sm">© <?= date('Y') ?> Raaster Shuttle. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

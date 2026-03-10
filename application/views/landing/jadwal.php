<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Perjalanan - Raaster Shuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

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
                 <a href="<?= base_url('landing/gallery') ?>" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors relative group">
                    Galeri
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
             <a href="<?= base_url('landing/gallery') ?>" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 rounded-r-md">Galeri</a>
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

    <div class="py-16 bg-white border-b border-gray-100">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-4">Jadwal Perjalanan</h1>
            <p class="text-lg text-gray-500">Temukan jadwal keberangkatan yang sesuai dengan kebutuhan Anda.</p>
         </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if(empty($jadwal)): ?>
            <div class="text-center py-20 text-gray-500 bg-white rounded-xl shadow-sm">
                Belum ada jadwal yang tersedia saat ini.
            </div>
        <?php else: ?>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Using Card Layout for Better Mobile Experience -->
                <?php foreach($jadwal as $j): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-1 rounded">RUTE #<?= $j->rute_id ?></span>
                                <span class="flex items-center text-gray-500 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <?= date('H:i', strtotime($j->jam_berangkat)) ?> WIB
                                </span>
                            </div>
                            
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="flex-1">
                                    <p class="text-xs text-gray-400 uppercase font-bold">Dari</p>
                                    <h3 class="text-lg font-bold text-gray-900 truncate"><?= $j->kota_asal ?></h3>
                                </div>
                                <div class="text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>
                                <div class="flex-1 text-right">
                                    <p class="text-xs text-gray-400 uppercase font-bold">Ke</p>
                                    <h3 class="text-lg font-bold text-gray-900 truncate"><?= $j->kota_tujuan ?></h3>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                             <div class="text-sm text-gray-500">
                                 Harian
                             </div>
                             <a href="<?= base_url('auth/login') ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition">
                                 Pesan
                             </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raaster Shuttle - Perjalanan Premium</title>
    <!-- Tailwind CSS (CDN for simplicity, ensure you have it or stylesheet linked in header view) -->
    <script src="https://cdn.tailwindcss.com"></script> 
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .hero-gradient { background: linear-gradient(135deg, #4F46E5 0%, #312E81 100%); }
        
        /* Wave Animation */
        .waves {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100px;
            min-height: 100px;
            max-height: 150px;
        }
        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        .parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }
        .parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; }
        .parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; }
        .parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; }
        @keyframes move-forever {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Navigation -->
<!-- Navigation -->
<nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="#" class="flex items-center gap-2 group">
                    <span class="text-xl font-bold text-gray-900 tracking-tighter group-hover:text-indigo-700 transition">Raaster<span class="text-indigo-500">.</span></span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors relative group">
                    Beranda
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="#features" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors relative group">
                    Layanan
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="#routes" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors relative group">
                    Rute & Harga
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
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
            <a href="#home" class="block pl-3 pr-4 py-3 border-l-4 border-indigo-500 text-base font-medium text-indigo-700 bg-indigo-50 rounded-r-md">Beranda</a>
            <a href="#features" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 rounded-r-md">Layanan</a>
            <a href="#routes" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 rounded-r-md">Rute & Harga</a>
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

<!-- Hero Section -->
<section id="home" class="relative pt-20 pb-28 lg:pt-28 lg:pb-40 overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="<?= isset($hero['hero_image']) ? $hero['hero_image'] : 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80' ?>" 
             class="w-full h-full object-cover object-center" 
             alt="Background">
        <!-- Blue/Indigo Overlay to match brand -->
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/95 via-blue-900/90 to-indigo-900/80 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900 via-transparent to-transparent opacity-90"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl">
            <!-- Pill Badge -->
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-indigo-100 font-medium text-xs mb-5">
                <span class="flex h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span><?= isset($hero['hero_tagline']) ? $hero['hero_tagline'] : 'Mitra Perjalanan Terpercaya' ?></span>
            </div>
            
            <!-- Headline -->
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-3 drop-shadow-lg">
                <?= isset($hero['hero_title']) ? $hero['hero_title'] : 'Jelajahi Kenyamanan <br><span class="text-blue-300">Perjalanan Antar Kota</span>' ?>
            </h1>
            
            <!-- Subheadline -->
            <p class="text-sm text-gray-100 mb-8 leading-relaxed max-w-lg drop-shadow-md font-light">
                <?= isset($hero['hero_subtitle']) ? $hero['hero_subtitle'] : 'Akses jadwal perjalanan dengan mudah. Temukan rute terbaik, armada premium, dan tarif transparan dalam satu platform digital yang interaktif.' ?>
            </p>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="#routes" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 text-white rounded-md font-bold text-sm hover:bg-blue-700 transition shadow-lg hover:shadow-blue-600/30 flex items-center justify-center">
                    Cek Jadwal
                </a>
                <a href="<?= base_url('faq') ?>" class="w-full sm:w-auto px-6 py-2.5 bg-white/10 border border-white/20 text-white rounded-md font-bold text-sm hover:bg-white/20 transition flex items-center justify-center backdrop-blur-sm">
                    Cara Booking
                </a>
            </div>
        </div>
    </div>
    
    <!-- WAVE SVG (Animated) -->
    <div class="absolute bottom-0 w-full leading-none z-20">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
            </g>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">Kenapa Memilih Raaster?</h2>
            <p class="text-gray-500 text-lg">Kami mengutamakan kenyamanan dan keamanan Anda di setiap kilometer perjalanan.</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-gray-100 group">
                <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Door to Door Service</h3>
                <p class="text-gray-500">Dijemput di depan rumah, diantar sampai tujuan. Tidak perlu repot ke terminal atau pool.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-gray-100 group">
                <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">On Time Guarantee</h3>
                <p class="text-gray-500">Jadwal keberangkatan yang pasti. Kami menghargai waktu Anda sangat berharga.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-gray-100 group">
                <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Armada Premium</h3>
                <p class="text-gray-500">Unit mobil terbaru (Toyota Hiace / Innova Reborn) yang bersih, wangi, dan full AC.</p>
            </div>
        </div>
    </div>
</section>

<!-- Routes Section -->
<section id="routes" class="py-24 bg-gray-50 relative overflow-hidden">
    <!-- Decorative blobs -->
    <div class="absolute top-0 left-0 -ml-20 -mt-20 w-80 h-80 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-80 h-80 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-2xl">
                <span class="text-indigo-600 font-bold tracking-wider uppercase text-sm mb-2 block">Pilihan Terbaik</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-4">Rute Populer Kami</h2>
                <p class="text-gray-500 text-lg">Temukan perjalanan favorit pelanggan dengan harga terbaik dan kenyamanan maksimal.</p>
            </div>
            
            <a href="<?= base_url('jadwal') ?>" class="group hidden md:inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-full text-indigo-600 font-bold text-sm hover:border-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-indigo-200">
                Lihat Semua Jadwal
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(empty($rute)): ?>
                <div class="col-span-3 py-16 text-center">
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 inline-block">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 7m0 13V7"/></svg>
                        <p class="text-gray-500 font-medium">Belum ada rute tersedia saat ini.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach(array_slice($rute, 0, 6) as $r): ?>
                <div class="group bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full hover:-translate-y-1">
                    <!-- Top Gradient stripe -->
                    <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 to-blue-500"></div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 uppercase tracking-wide">
                                Premium Route
                            </span>
                            <div class="flex items-center text-gray-400 text-xs font-medium bg-gray-50 px-2 py-1 rounded-md">
                                <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <?= $r->jarak_km ?> km
                            </div>
                        </div>
                        
                        <!-- Route Visual -->
                        <div class="flex items-center justify-between mb-8 relative">
                            <!-- Line Connector -->
                            <div class="absolute left-0 right-0 top-1/2 h-0.5 bg-gray-100 -z-10"></div>
                            
                            <div class="bg-white pr-2">
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Dari</p>
                                <h4 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors"><?= $r->kota_asal ?></h4>
                            </div>
                            
                            <div class="bg-white px-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center transform group-hover:rotate-180 transition-transform duration-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </div>
                            </div>
                            
                            <div class="bg-white pl-2 text-right">
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Ke</p>
                                <h4 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors"><?= $r->kota_tujuan ?></h4>
                            </div>
                        </div>
                        
                        <!-- Features / Divider -->
                        <div class="mt-auto border-t border-dashed border-gray-200 pt-6">
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    AC &amp; Music
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Reclining Seat
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-400 mb-0.5">Mulai dari</p>
                                    <p class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-700 to-blue-600">
                                        Rp <?= number_format($r->harga, 0, ',', '.') ?>
                                    </p>
                                </div>
                                <a href="<?= base_url('auth/login') ?>" class="inline-flex justify-center items-center px-5 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-indigo-600 hover:shadow-indigo-500/30 transition-all duration-300 shadow-lg">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Mobile View All Button -->
         <div class="mt-12 text-center md:hidden">
            <a href="<?= base_url('jadwal') ?>" class="inline-flex w-full justify-center items-center px-6 py-3 bg-white border border-gray-200 rounded-xl text-indigo-600 font-bold shadow-sm active:bg-gray-50">
                Lihat Semua Jadwal
            </a>
        </div>
    </div>
</section>

<!-- Gallery Preview Section -->
<section class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold tracking-widest uppercase mb-4">Galeri Kami</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Eksplorasi Raaster<span class="text-indigo-600">.</span></h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Dokumentasi armada, fasilitas, dan momen perjalanan terbaik bersama kami.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if(!empty($gallery)): ?>
                <?php foreach($gallery as $g): ?>
                    <div class="group relative aspect-square rounded-2xl overflow-hidden bg-gray-100 cursor-pointer" onclick="window.location.href='<?= base_url('landing/gallery') ?>'">
                        <img src="<?= $g->image ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-out" loading="lazy">
                        
                        <!-- Minimal Overlay -->
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition duration-300"></div>
                        
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                             <div class="bg-white/90 backdrop-blur px-4 py-2 rounded-full shadow-lg transform translate-y-2 group-hover:translate-y-0 transition">
                                <span class="text-gray-900 text-xs font-bold">Lihat Foto</span>
                             </div>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">
                            <h4 class="text-white font-bold text-sm truncate drop-shadow-md"><?= $g->title ?></h4>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-16 text-center bg-gray-50 rounded-2xl border border-gray-100">
                    <p class="text-gray-400">Belum ada foto galeri.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-12 text-center">
             <a href="<?= base_url('landing/gallery') ?>" class="inline-flex items-center text-sm font-bold text-gray-900 hover:text-indigo-600 transition">
                Lihat Semua Galeri <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- News Section -->
<section id="news" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold tracking-widest uppercase mb-4">Kabar Terbaru</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Berita Terkini</h2>
            <p class="mt-4 text-lg text-gray-500">Informasi terbaru seputar kegiatan dan perkembangan Raaster Shuttle.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php if(!empty($news)): ?>
                <?php foreach($news as $n): ?>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden flex flex-col h-full">
                    <div class="h-56 relative overflow-hidden">
                        <img src="<?= $n->image ? $n->image : 'https://via.placeholder.com/400x300?text=No+Image' ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4 bg-indigo-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                            <?= date('d M Y', strtotime($n->created_at)) ?>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 leading-snug group-hover:text-indigo-600 transition">
                            <a href="<?= base_url('landing/news_detail/'.$n->id) ?>">
                                <?= $n->title ?>
                            </a>
                        </h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed flex-1">
                             <?php 
                                $clean_content = strip_tags($n->content);
                                echo $clean_content ? $clean_content : 'Klik untuk membaca selengkapnya...';
                            ?>
                        </p>
                        <a href="<?= base_url('landing/news_detail/'.$n->id) ?>" class="inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                            Baca Selengkapnya 
                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border border-gray-100 text-gray-400">
                    Belum ada berita yang diterbitkan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Contact / Complaint Section -->
<section id="contact" class="py-20 bg-indigo-900 text-white relative overflow-hidden">
    <!-- Decorative -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-3xl font-bold mb-6">Pusat Bantuan & Layanan Pelanggan</h2>
                <p class="text-indigo-200 text-lg mb-8 leading-relaxed">
                    Kami menghargai setiap masukan Anda. Jika Anda memiliki keluhan, saran, atau pertanyaan seputar layanan kami, jangan ragu untuk menghubungi kami. Tim kami siap membantu 24/7.
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-indigo-800 text-indigo-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h5 class="text-lg font-bold">Layanan Telepon</h5>
                            <p class="text-indigo-300 mt-1">(0291) 488 1234</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                         <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-indigo-800 text-indigo-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h5 class="text-lg font-bold">Email Suport</h5>
                            <p class="text-indigo-300 mt-1">support@raaster.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-2xl text-gray-800">
                <h3 class="text-2xl font-bold mb-6 text-gray-900">Formulir Keluhan</h3>
                 <?php if($this->session->flashdata('success')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded text-sm"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded text-sm"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <form action="<?= base_url('landing/submit_complaint') ?>" method="POST" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">No. WhatsApp</label>
                            <input type="text" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Subjek</label>
                        <select name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm transition">
                            <option value="Kendala Pemesanan">Kendala Pemesanan</option>
                            <option value="Keluhan Driver/Armada">Keluhan Driver/Armada</option>
                            <option value="Pertanyaan Umum">Pertanyaan Umum</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Pesan</label>
                        <textarea name="message" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm transition"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg transform hover:-translate-y-0.5">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-white border-t border-gray-100 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-2">
                <span class="text-2xl font-bold text-indigo-700 tracking-tighter mb-4 block">Raaster<span class="text-indigo-400">.</span></span>
                <p class="text-gray-500 max-w-sm">Mitra perjalanan terbaik Anda. Kami berkomitmen memberikan pelayanan transportasi yang aman, nyaman, dan terjangkau untuk semua kalangan.</p>
            </div>
            
            <div>
                <h4 class="font-bold text-gray-900 mb-6">Tautan Cepat</h4>
                <ul class="space-y-4">
                    <li><a href="#home" class="text-gray-500 hover:text-indigo-600 transition">Beranda</a></li>
                    <li><a href="#features" class="text-gray-500 hover:text-indigo-600 transition">Layanan</a></li>
                    <li><a href="#routes" class="text-gray-500 hover:text-indigo-600 transition">Rute</a></li>
                    <li><a href="<?= base_url('auth/login') ?>" class="text-gray-500 hover:text-indigo-600 transition">Login</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-bold text-gray-900 mb-6">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3 text-gray-500">
                        <svg class="w-6 h-6 mt-0.5 text-indigo-500 text-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Jalan Raya Utama No. 123, <br>Jepara, Jawa Tengah</span>
                    </li>
                    <li class="flex items-center space-x-3 text-gray-500">
                         <svg class="w-6 h-6 text-indigo-500 text-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>support@raaster.com</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm mb-4 md:mb-0">&copy; <?= date('Y') ?> Raaster Shuttle. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="text-gray-400 hover:text-indigo-600"><span class="sr-only">Facebook</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg></a>
                <a href="#" class="text-gray-400 hover:text-indigo-600"><span class="sr-only">Instagram</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.48 2h.16zM12 7a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6zm5.338-3.205a1.2 1.2 0 110-2.4 1.2 1.2 0 010 2.4z" clip-rule="evenodd" /></svg></a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Navbar Scroll Effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            navbar.classList.add('shadow-md');
            navbar.classList.replace('bg-white/80', 'bg-white/95');
        } else {
            navbar.classList.remove('shadow-md');
            navbar.classList.replace('bg-white/95', 'bg-white/80');
        }
    });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIconOpen = document.getElementById('menu-icon-open');
    const menuIconClose = document.getElementById('menu-icon-close');

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            menuIconOpen.classList.toggle('hidden');
            menuIconClose.classList.toggle('hidden');
        });
    }

    // Close mobile menu when clicking a link
    document.querySelectorAll('#mobile-menu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            menuIconOpen.classList.remove('hidden');
            menuIconClose.classList.add('hidden');
        });
    });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $news->title ?> - Raaster Shuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

<!-- Navbar -->
<!-- Navbar -->
<nav class="fixed w-full z-50 transition-all duration-300 bg-gray-900 border-b border-white/10" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?= base_url() ?>" class="font-bold text-2xl tracking-tighter text-white">
                    Raaster<span class="text-indigo-400">.</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="<?= base_url() ?>" class="text-white hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Beranda</a>
                    <a href="<?= base_url('#about') ?>" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Tentang</a>
                    <a href="<?= base_url('#services') ?>" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Layanan</a>
                    <a href="<?= base_url('#fleet') ?>" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Armada</a>
                    <a href="<?= base_url('landing/gallery') ?>" class="text-indigo-400 font-bold px-3 py-2 rounded-md text-sm transition duration-300">Galeri</a>
                    <a href="<?= base_url('#contact') ?>" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-300">Kontak</a>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="hidden md:block">
                <a href="https://wa.me/6281234567890" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-full text-sm font-bold transition duration-300 shadow-lg shadow-indigo-500/30 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    WhatsApp
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-gray-300 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-gray-900 border-b border-gray-800">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="<?= base_url() ?>" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
            <a href="<?= base_url('#about') ?>" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Tentang</a>
            <a href="<?= base_url('#services') ?>" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Layanan</a>
            <a href="<?= base_url('#fleet') ?>" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Armada</a>
            <a href="<?= base_url('landing/gallery') ?>" class="text-indigo-400 font-bold block px-3 py-2 rounded-md text-base">Galeri</a>
            <a href="<?= base_url('#contact') ?>" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <div class="mb-6 text-sm text-gray-400 flex items-center overflow-hidden">
        <a href="<?= base_url() ?>" class="hover:text-indigo-600 whitespace-nowrap">Home</a>
        <span class="mx-2">/</span>
        <span class="text-gray-600 truncate"><?= (strlen($news->title) > 50) ? substr($news->title, 0, 50) . '...' : $news->title ?></span>
    </div>

    <div class="grid lg:grid-cols-3 gap-10">
        <!-- Main Content (Left) -->
        <main class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-md text-xs font-bold uppercase tracking-wide border border-indigo-100">Berita</span>
                        <span class="text-gray-400 text-xs font-medium"><?= date('d F Y', strtotime($news->created_at)) ?></span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight"><?= $news->title ?></h1>
                </div>

                <!-- Hero Image -->
                <?php if($news->image): ?>
                    <div class="rounded-xl overflow-hidden mb-8">
                        <img src="<?= $news->image ?>" class="w-full h-auto object-cover max-h-[400px]" alt="<?= $news->title ?>">
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="prose prose-lg prose-indigo max-w-none text-gray-600 leading-relaxed">
                     <?php 
                        if (!empty($news->content)) {
                            echo nl2br($news->content); 
                        } else {
                            echo '<p class="text-gray-400 italic">Konten artikel ini belum tersedia.</p>';
                        }
                    ?>
                </div>

                <!-- Footer / Back Link -->
                <div class="mt-10 pt-6 border-t border-gray-100">
                    <a href="<?= base_url() ?>" class="inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </main>

        <!-- Sidebar (Right) - Visible on Mobile now -->
        <aside class="mt-12 lg:mt-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <div class="flex items-center mb-6">
                    <div class="w-1 h-6 bg-indigo-500 rounded-full mr-3"></div>
                    <h3 class="text-lg font-bold text-gray-900">Berita Terbaru</h3>
                </div>

                <div class="space-y-6">
                    <?php if(!empty($recent_news)): ?>
                        <?php foreach($recent_news as $r): ?>
                        <a href="<?= base_url('landing/news_detail/'.$r->id) ?>" class="flex gap-4 group">
                            <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 relative">
                                <?php if($r->image): ?>
                                    <img src="<?= $r->image ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-2 leading-snug group-hover:text-indigo-600 transition mb-1"><?= $r->title ?></h4>
                                <span class="text-xs text-gray-400 block"><?= date('d M Y', strtotime($r->created_at)) ?></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-sm text-gray-400">Tidak ada berita terbaru.</p>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
</div>
</body>
</html>

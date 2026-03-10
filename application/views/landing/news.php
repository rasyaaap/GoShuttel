<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Informasi - Raaster Shuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Nav Placeholder (Simplified for subpage) -->
<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="<?= base_url() ?>" class="flex items-center gap-2 font-bold text-xl text-indigo-700">Raaster.</a>
        <a href="<?= base_url() ?>" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Kembali ke Beranda</a>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Berita & Informasi</h1>
    
    <div class="grid md:grid-cols-3 gap-8">
        <?php foreach($news as $n): ?>
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition group cursor-pointer border border-gray-100" onclick="window.location.href='<?= base_url('landing/news_detail/'.$n->id) ?>'">
            <div class="h-56 overflow-hidden relative">
                <?php if($n->image): ?>
                    <img src="<?= $n->image ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <?php else: ?>
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                <?php endif; ?>
            </div>
            <div class="p-6">
                <span class="text-xs font-bold text-indigo-600 mb-2 block"><?= date('d F Y', strtotime($n->created_at)) ?></span>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition"><?= $n->title ?></h3>
                <p class="text-gray-600 text-sm line-clamp-3">
                    <?php 
                        $clean_content = strip_tags($n->content);
                        echo $clean_content ? $clean_content : 'Klik untuk membaca selengkapnya...';
                    ?>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>

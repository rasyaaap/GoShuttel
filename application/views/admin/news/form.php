<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <h3 class="text-2xl font-bold text-gray-800 mb-6"><?= isset($news) ? 'Edit Berita' : 'Tambah Berita' ?></h3>
        
        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100 p-8">
            <form action="<?= base_url('admin/news_save') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= isset($news) ? $news->id : '' ?>">
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Judul Berita</label>
                    <input type="text" name="title" value="<?= isset($news) ? $news->title : '' ?>" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none" required placeholder="Masukkan judul...">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Konten</label>
                    <textarea name="content" rows="10" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none" required placeholder="Tulis konten berita..."><?= isset($news) ? $news->content : '' ?></textarea>
                </div>

                <div class="mb-8">
        <label class="block text-gray-700 text-sm font-bold mb-2">Gambar</label>
        
        <!-- File Upload -->
        <input type="file" name="image_file" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none mb-3">
        
        <!-- URL Fallback -->
        <label class="text-xs text-gray-500 font-bold mb-1 block">Atau gunakan URL Link (Opsional):</label>
        <input type="text" name="image_url" value="<?= isset($news) ? $news->image : '' ?>" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none placeholder-gray-400 text-sm" placeholder="https://example.com/image.jpg">
        
        <?php if(isset($news) && $news->image): ?>
            <div class="mt-4">
                <p class="text-xs text-gray-500 mb-2">Gambar Saat Ini:</p>
                <img src="<?= $news->image ?>" class="h-32 rounded-lg shadow-sm border border-gray-200">
            </div>
        <?php endif; ?>
    </div>

                <div class="flex justify-end space-x-4">
                    <a href="<?= base_url('admin/news') ?>" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 font-medium">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</main>

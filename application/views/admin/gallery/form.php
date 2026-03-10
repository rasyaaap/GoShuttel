<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <h3 class="text-2xl font-bold text-gray-800 mb-6"><?= isset($gallery) ? 'Edit Foto' : 'Tambah Foto' ?></h3>
        
        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100 p-8">
            <form action="<?= base_url('admin/gallery_save') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= isset($gallery) ? $gallery->id : '' ?>">
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Judul Foto</label>
                    <input type="text" name="title" value="<?= isset($gallery) ? $gallery->title : '' ?>" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none" required placeholder="Contoh: Armada Hiace Premio Terbaru">
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                        <select name="category" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none">
                            <option value="armada" <?= (isset($gallery) && $gallery->category == 'armada') ? 'selected' : '' ?>>Armada</option>
                            <option value="fasilitas" <?= (isset($gallery) && $gallery->category == 'fasilitas') ? 'selected' : '' ?>>Fasilitas</option>
                            <option value="kegiatan" <?= (isset($gallery) && $gallery->category == 'kegiatan') ? 'selected' : '' ?>>Kegiatan</option>
                            <option value="lainnya" <?= (isset($gallery) && $gallery->category == 'lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Gambar</label>
                    <input type="file" name="image_file" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none mb-3">
                    
                    <label class="text-xs text-gray-500 font-bold mb-1 block">Atau gunakan URL Link:</label>
                    <input type="text" name="image_url" value="<?= isset($gallery) ? $gallery->image : '' ?>" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none placeholder-gray-400 text-sm" placeholder="https://example.com/image.jpg">
                    
                     <?php if(isset($gallery) && $gallery->image): ?>
                        <div class="mt-4">
                            <p class="text-xs text-gray-500 mb-2">Gambar Saat Ini:</p>
                            <img src="<?= $gallery->image ?>" class="h-32 rounded-lg shadow-sm border border-gray-200">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 outline-none"><?= isset($gallery) ? $gallery->description : '' ?></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="<?= base_url('admin/gallery') ?>" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 font-medium">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</main>

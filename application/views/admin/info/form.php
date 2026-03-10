<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800"><?= isset($info) ? 'Edit' : 'Tambah' ?> Info Terkini</h1>
            <p class="text-gray-500 mt-1">Isi formulir berikut untuk menampilkan info di dashboard customer.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="<?= base_url('admin/info_save') ?>" method="POST">
                <?php if(isset($info)): ?>
                    <input type="hidden" name="id" value="<?= $info->id ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" value="<?= $info->title ?? '' ?>" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Info</label>
                        <select name="info_type" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="info" <?= (isset($info) && $info->info_type == 'info') ? 'selected' : '' ?>>Info Umum (Putih)</option>
                            <option value="promo" <?= (isset($info) && $info->info_type == 'promo') ? 'selected' : '' ?>>Promo (Pink - Rose)</option>
                            <option value="rute" <?= (isset($info) && $info->info_type == 'rute') ? 'selected' : '' ?>>Rute Baru (Biru - Indigo)</option>
                            <option value="news" <?= (isset($info) && $info->info_type == 'news') ? 'selected' : '' ?>>Berita (Ungu - Violet)</option>
                            <option value="warning" <?= (isset($info) && $info->info_type == 'warning') ? 'selected' : '' ?>>Penting (Oranye - Amber)</option>
                            <option value="success" <?= (isset($info) && $info->info_type == 'success') ? 'selected' : '' ?>>Sukses (Hijau - Emerald)</option>
                            <option value="dark" <?= (isset($info) && $info->info_type == 'dark') ? 'selected' : '' ?>>Elegan (Hitam - Dark)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Tipe menentukan warna background kartu di dashboard user.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Label Tag (Opsional)</label>
                        <input type="text" name="tag_text" value="<?= $info->tag_text ?? '' ?>" placeholder="Contoh: BARU, PROMO, HOT" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konten / Deskripsi Singkat</label>
                        <textarea name="content" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"><?= $info->content ?? '' ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Tujuan (Opsional)</label>
                        <input type="text" name="link_url" value="<?= $info->link_url ?? '' ?>" placeholder="Contoh: booking?origin=Jepara" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika ingin otomatis dibuatkan halaman detail (untuk Berita/Promo).</p>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="<?= base_url('admin/info') ?>" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

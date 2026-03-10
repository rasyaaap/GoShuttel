<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <h3 class="text-3xl font-bold text-gray-800 mb-6"><?= isset($rute) ? 'Edit Rute' : 'Tambah Rute' ?></h3>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-8">
                <?php $url = isset($rute) ? 'admin/rute_update' : 'admin/rute_add'; ?>
                <form action="<?= base_url($url) ?>" method="POST" class="space-y-6">
                    <?php if(isset($rute)): ?>
                        <input type="hidden" name="id" value="<?= $rute->id ?>">
                    <?php endif; ?>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kota Asal</label>
                            <input type="text" name="kota_asal" value="<?= isset($rute) ? $rute->kota_asal : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kota Tujuan</label>
                            <input type="text" name="kota_tujuan" value="<?= isset($rute) ? $rute->kota_tujuan : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                            <input type="number" name="harga" value="<?= isset($rute) ? $rute->harga : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jarak (KM)</label>
                            <input type="number" step="0.1" name="jarak_km" value="<?= isset($rute) ? $rute->jarak_km : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Waktu (Contoh: 3 Jam 30 Menit)</label>
                        <input type="text" name="estimasi_waktu" value="<?= isset($rute) ? $rute->estimasi_waktu : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                         <a href="<?= base_url('admin/rute') ?>" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            <?= isset($rute) ? 'Update Rute' : 'Simpan Rute' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <h3 class="text-3xl font-bold text-gray-800 mb-6"><?= isset($armada) ? 'Edit Armada' : 'Tambah Armada' ?></h3>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-8">
                <?php $url = isset($armada) ? 'admin/armada_update' : 'admin/armada_add'; ?>
                <form action="<?= base_url($url) ?>" method="POST" class="space-y-6">
                    <?php if(isset($armada)): ?>
                        <input type="hidden" name="id" value="<?= $armada->id ?>">
                    <?php endif; ?>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Armada (Jenis)</label>
                            <input type="text" name="nama_armada" value="<?= isset($armada) ? $armada->nama_armada : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Toyota HiAce">
                        </div>
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Plat Nomor</label>
                            <input type="text" name="plat_nomor" value="<?= isset($armada) ? $armada->plat_nomor : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="K 1234 XY">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (Jumlah Kursi)</label>
                             <input type="number" name="kapasitas" id="kapasitas" value="<?= isset($armada) ? $armada->kapasitas : 8 ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Layout Kursi (Baris-Baris)</label>
                             <input type="text" name="layout_kursi" id="layout_kursi" value="<?= isset($armada) ? $armada->layout_kursi : '1-3-4' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: 1-3-4">
                             <p class="text-xs text-gray-500 mt-1">Format: Jumlah kursi per baris dipisah tanda strip (-).</p>
                        </div>
                    </div>

                    <!-- Presets -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template Cepat:</label>
                        <div class="flex flex-wrap gap-2">
                             <button type="button" onclick="setPreset(8, '1-3-4')" class="px-3 py-1 bg-white border border-gray-300 rounded text-xs hover:bg-indigo-50 hover:border-indigo-300">HiAce 8 (1-3-4)</button>
                             <button type="button" onclick="setPreset(10, '1-3-3-3')" class="px-3 py-1 bg-white border border-gray-300 rounded text-xs hover:bg-indigo-50 hover:border-indigo-300">HiAce 10 (1-3-3-3)</button>
                             <button type="button" onclick="setPreset(14, '2-3-3-3-3')" class="px-3 py-1 bg-white border border-gray-300 rounded text-xs hover:bg-indigo-50 hover:border-indigo-300">Elf Short 14 (2-3...)</button>
                             <button type="button" onclick="setPreset(21, '3-3-3-3-3-3-3')" class="px-3 py-1 bg-white border border-gray-300 rounded text-xs hover:bg-indigo-50 hover:border-indigo-300">Elf Long 21 (3x7)</button>
                        </div>
                    </div>

                    <?php if(isset($armada)): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                         <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                             <option value="tersedia" <?= $armada->status == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                             <option value="jalan" <?= $armada->status == 'jalan' ? 'selected' : '' ?>>Sedang Jalan</option>
                             <option value="maintenance" <?= $armada->status == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                         </select>
                    </div>
                    <?php endif; ?>

                    <script>
                        function setPreset(cap, layout) {
                            document.getElementById('kapasitas').value = cap;
                            document.getElementById('layout_kursi').value = layout;
                        }
                    </script>

                    <div class="pt-4 flex justify-end space-x-3">
                         <a href="<?= base_url('admin/armada') ?>" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            <?= isset($armada) ? 'Update Armada' : 'Simpan Armada' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

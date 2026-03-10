<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <h3 class="text-3xl font-bold text-gray-800 mb-6">Buat Jadwal Perjalanan</h3>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-8">
                <form action="<?= base_url('admin/perjalanan_add') ?>" method="POST" class="space-y-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Rute & Jadwal Master</label>
                        <select name="jadwal_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Jadwal --</option>
                            <?php foreach($jadwal_list as $j): ?>
                                <option value="<?= $j->id ?>">
                                    <?= $j->kota_asal ?> - <?= $j->kota_tujuan ?> (<?= date('H:i', strtotime($j->jam_berangkat)) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Mengambil data dari Master Jadwal.</p>
                    </div>

                    <div>
                         <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Keberangkatan</label>
                         <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Assign Driver (Opsional)</label>
                            <select name="driver_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Driver --</option>
                                <?php foreach($driver_list as $d): ?>
                                    <option value="<?= $d->id ?>"><?= $d->name ?> (<?= $d->phone ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Assign Armada (Opsional)</label>
                            <select name="armada_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Armada --</option>
                                <?php foreach($armada_list as $a): ?>
                                    <option value="<?= $a->id ?>"><?= $a->nama_armada ?> - <?= $a->plat_nomor ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                         <a href="<?= base_url('admin/perjalanan') ?>" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Jadwalkan Perjalanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

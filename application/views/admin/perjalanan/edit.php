<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-3xl font-bold text-gray-800">Edit Perjalanan</h3>
            <a href="<?= base_url('admin/perjalanan') ?>" class="text-indigo-600 hover:text-indigo-900 border border-indigo-200 px-4 py-2 rounded-lg bg-white">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <form action="<?= base_url('admin/perjalanan_update') ?>" method="POST">
                <input type="hidden" name="id" value="<?= $perjalanan->id ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Route Info (Read Only) -->
                    <div class="col-span-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-bold text-gray-700 mb-2">Informasi Rute</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-400 uppercase font-bold">Asal</label>
                                <p class="text-gray-900 font-medium"><?= $perjalanan->kota_asal ?></p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-400 uppercase font-bold">Tujuan</label>
                                <p class="text-gray-900 font-medium"><?= $perjalanan->kota_tujuan ?></p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-400 uppercase font-bold">Tanggal</label>
                                <p class="text-gray-900 font-medium"><?= date('d M Y', strtotime($perjalanan->tanggal)) ?></p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-400 uppercase font-bold">Jam</label>
                                <p class="text-gray-900 font-medium"><?= date('H:i', strtotime($perjalanan->jam_berangkat)) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Assignments -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Driver</label>
                        <select name="driver_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                            <option value="">-- Pilih Driver --</option>
                            <?php foreach($drivers as $d): ?>
                                <option value="<?= $d->id ?>" <?= $perjalanan->driver_id == $d->id ? 'selected' : '' ?>>
                                    <?= $d->name ?> 
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Armada</label>
                        <select name="armada_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                            <option value="">-- Pilih Armada --</option>
                            <?php foreach($armada_list as $a): ?>
                                <option value="<?= $a->id ?>" <?= $perjalanan->armada_id == $a->id ? 'selected' : '' ?>>
                                    <?= $a->nama_armada ?> - <?= $a->plat_nomor ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Perjalanan</label>
                        <select name="status" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                            <option value="dijadwalkan" <?= $perjalanan->status == 'dijadwalkan' ? 'selected' : '' ?>>Dijadwalkan</option>
                            <option value="berjalan" <?= $perjalanan->status == 'berjalan' ? 'selected' : '' ?>>Berjalan</option>
                            <option value="selesai" <?= $perjalanan->status == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="batal" <?= $perjalanan->status == 'batal' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-lg shadow-indigo-500/50">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

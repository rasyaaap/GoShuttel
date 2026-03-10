<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <h3 class="text-3xl font-bold text-gray-800 mb-6"><?= isset($jadwal) ? 'Edit Jadwal' : 'Tambah Jadwal' ?></h3>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-8">
                <?php $url = isset($jadwal) ? 'admin/jadwal_update' : 'admin/jadwal_add'; ?>
                <form action="<?= base_url($url) ?>" method="POST" class="space-y-6">
                    <?php if(isset($jadwal)): ?>
                        <input type="hidden" name="id" value="<?= $jadwal->id ?>">
                    <?php endif; ?>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rute</label>
                        <select name="rute_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <?php foreach($rute as $r): ?>
                                <option value="<?= $r->id ?>" <?= (isset($jadwal) && $jadwal->rute_id == $r->id) ? 'selected' : '' ?>>
                                    <?= $r->kota_asal ?> - <?= $r->kota_tujuan ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Berangkat</label>
                            <input type="time" name="jam_berangkat" value="<?= isset($jadwal) ? $jadwal->jam_berangkat : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <?php if(isset($jadwal)): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="aktif" <?= $jadwal->status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="non-aktif" <?= $jadwal->status == 'non-aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                            </select>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-2 gap-6 pt-2">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Armada Default (Opsional)</label>
                            <select name="armada_id" id="armadaSelect" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Armada --</option>
                                <?php foreach($armada_list as $a): ?>
                                    <option value="<?= $a->id ?>" data-current-driver-id="<?= $a->current_driver_id ?>" <?= (isset($jadwal) && $jadwal->armada_id == $a->id) ? 'selected' : '' ?>>
                                        <?= $a->nama_armada ?> (<?= $a->plat_nomor ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Armada yang akan otomatis diassign.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Driver Default (Opsional)</label>
                            <select name="driver_id" id="driverSelect" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Driver --</option>
                                <?php foreach($driver_list as $d): ?>
                                    <option value="<?= $d->id ?>" data-current-armada-id="<?= $d->current_armada_id ?>" <?= (isset($jadwal) && $jadwal->driver_id == $d->id) ? 'selected' : '' ?>>
                                        <?= $d->name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Driver yang akan otomatis diassign.</p>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const armadaSelect = document.getElementById('armadaSelect');
                            const driverSelect = document.getElementById('driverSelect');

                            // When Driver changes -> Auto select associated Armada
                            driverSelect.addEventListener('change', function() {
                                const selectedOption = this.options[this.selectedIndex];
                                const armadaId = selectedOption.getAttribute('data-current-armada-id');
                                if (armadaId) {
                                    armadaSelect.value = armadaId;
                                }
                            });

                            // When Armada changes -> Auto select associated Driver
                            armadaSelect.addEventListener('change', function() {
                                const selectedOption = this.options[this.selectedIndex];
                                const driverId = selectedOption.getAttribute('data-current-driver-id');
                                if (driverId) {
                                    driverSelect.value = driverId;
                                }
                            });
                        });
                    </script>
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                         <a href="<?= base_url('admin/jadwal') ?>" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            <?= isset($jadwal) ? 'Update Jadwal' : 'Simpan Jadwal' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

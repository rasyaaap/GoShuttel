<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h3 class="text-3xl font-bold text-gray-800">Manajemen Jadwal</h3>
                <p class="text-gray-500 mt-1">Atur jam keberangkatan untuk setiap rute.</p>
            </div>
            <div class="flex space-x-3 w-full md:w-auto">
                <!-- Auto Update Toggle -->
                 <form action="<?= base_url('admin/schedule_settings') ?>" method="POST" class="inline">
                    <input type="hidden" name="auto_update" value="<?= $auto_update == '1' ? '0' : '1' ?>">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border <?= $auto_update == '1' ? 'border-green-600 text-green-600 bg-green-50' : 'border-gray-300 text-gray-700 bg-white' ?> rounded-lg shadow-sm text-sm font-medium hover:bg-gray-50 focus:outline-none w-full md:w-auto justify-center" title="<?= $auto_update == '1' ? 'Matikan Auto Update' : 'Aktifkan Auto Update' ?>">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <?= $auto_update == '1' ? 'Auto Update: ON' : 'Auto Update: OFF' ?>
                    </button>
                 </form>

                <a href="<?= base_url('admin/jadwal_add') ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full md:w-auto justify-center">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Jadwal
                </a>
            </div>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                 <p class="text-sm text-green-700"><?= $this->session->flashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <!-- ACTIONS BAR: SEARCH & BULK DELETE -->
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <!-- Search Form -->
            <form action="<?= base_url('admin/jadwal') ?>" method="GET" class="w-full md:w-1/3 flex">
                <input type="text" name="search" value="<?= isset($search) ? $search : '' ?>" placeholder="Cari Rute atau Jam..." class="flex-1 rounded-l-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                 <button type="submit" class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-lg bg-gray-50 text-gray-700 hover:bg-gray-100 font-medium">
                    Cari
                </button>
            </form>

            <!-- Bulk Delete Button -->
            <button type="button" onclick="submitBulkDelete()" id="btnBulkDelete" class="hidden items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Terpilih
            </button>
        </div>

        <!-- BULK DELETE FORM -->
        <form id="bulkDeleteForm" action="<?= base_url('admin/jadwal_bulk_delete') ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">

        <!-- DESKTOP TABLE VIEW -->
        <div class="hidden md:block bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rute</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Berangkat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Armada & Driver (Default)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(empty($jadwal)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data jadwal.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($jadwal as $j): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="ids[]" value="<?= $j->id ?>" class="item-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $j->kota_asal ?> &rarr; <?= $j->kota_tujuan ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        <?= date('H:i', strtotime($j->jam_berangkat)) ?> WIB
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php if($j->nama_armada): ?>
                                        <div class="text-xs font-bold text-gray-700"><?= $j->nama_armada ?></div>
                                    <?php endif; ?>
                                    <?php if($j->nama_driver): ?>
                                        <div class="text-xs text-gray-500"><?= $j->nama_driver ?></div>
                                    <?php endif; ?>
                                    <?php if(!$j->nama_armada && !$j->nama_driver): ?>
                                        <span class="text-xs text-gray-400 italic">Belum diset</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $j->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= ucfirst($j->status) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?= base_url('admin/jadwal_edit/'.$j->id) ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-full text-xs mr-2">Edit</a>
                                    <a href="<?= base_url('admin/jadwal_delete/'.$j->id) ?>" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-full text-xs">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </form>

        <script>
            // Select All Checkbox Logic
            const selectAll = document.getElementById('selectAll');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const btnBulkDelete = document.getElementById('btnBulkDelete');

            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    toggleBulkDeleteButton();
                });
            }

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleBulkDeleteButton);
            });

            function toggleBulkDeleteButton() {
                const anyChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
                if (anyChecked) {
                    btnBulkDelete.classList.remove('hidden');
                    btnBulkDelete.classList.add('inline-flex');
                } else {
                    btnBulkDelete.classList.add('hidden');
                    btnBulkDelete.classList.remove('inline-flex');
                }
            }

            function submitBulkDelete() {
                document.getElementById('bulkDeleteForm').submit();
            }
        </script>

        <!-- MOBILE CARD VIEW -->
        <div class="md:hidden grid grid-cols-1 gap-4">
            <?php if(empty($jadwal)): ?>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center text-gray-500">
                    Belum ada data jadwal.
                </div>
            <?php else: ?>
                <?php foreach($jadwal as $j): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                             <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Rute</p>
                             <div class="flex items-center space-x-1 mt-1">
                                <span class="font-bold text-gray-900"><?= $j->kota_asal ?></span>
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                <span class="font-bold text-gray-900"><?= $j->kota_tujuan ?></span>
                            </div>
                        </div>
                         <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $j->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= ucfirst($j->status) ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 p-3 rounded-lg text-center">
                            <span class="block text-xs text-gray-500 mb-1">Jam Berangkat</span>
                            <span class="text-lg font-bold text-indigo-600"><?= date('H:i', strtotime($j->jam_berangkat)) ?></span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg text-center">
                            <span class="block text-xs text-gray-500 mb-1">Operasional</span>
                            <span class="text-sm font-medium text-gray-700">Setiap Hari</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex justify-end">
                         <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Jadwal
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</main>

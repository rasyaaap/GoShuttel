<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h3 class="text-3xl font-bold text-gray-800">Manajemen Perjalanan</h3>
                <p class="text-gray-500 mt-1">Jadwalkan keberangkatan aktual untuk driver.</p>
            </div>
            <a href="<?= base_url('admin/perjalanan_add') ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full md:w-auto justify-center">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Buat Jadwal Perjalanan
            </a>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                 <p class="text-sm text-green-700"><?= $this->session->flashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <!-- ACTIONS BAR: SEARCH & BULK DELETE -->
         <div class="mb-4 flex flex-col md:flex-row justify-end items-center space-y-4 md:space-y-0">
            <!-- Bulk Delete Button -->
            <button type="button" onclick="submitBulkDelete()" id="btnBulkDelete" class="hidden items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Terpilih
            </button>
        </div>

        <form id="bulkDeleteForm" action="<?= base_url('admin/perjalanan_bulk_delete') ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">
        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rute</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver & Armada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penumpang (Dijemput)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(empty($perjalanan)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada perjalanan yang dijadwalkan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($perjalanan as $p): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="ids[]" value="<?= $p->id ?>" class="item-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900"><?= date('d M Y', strtotime($p->tanggal)) ?></div>
                                    <div class="text-sm text-gray-500"><?= date('H:i', strtotime($p->jam_berangkat)) ?> WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $p->kota_asal ?> &rarr; <?= $p->kota_tujuan ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $p->nama_driver ?: '<span class="text-red-400">Belum assign</span>' ?></div>
                                    <div class="text-xs text-gray-500"><?= $p->nama_armada ?: '-' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900"><?= $p->picked_up_count ?></span>
                                    <span class="text-sm text-gray-400">/</span>
                                    <span class="text-sm font-medium text-gray-600"><?= $p->total_passengers ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                     <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?= $p->status == 'selesai' ? 'bg-green-100 text-green-800' : ($p->status == 'dijadwalkan' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') ?>">
                                        <?= ucfirst(str_replace('_', ' ', $p->status)) ?>
                                     </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="<?= base_url('admin/perjalanan_detail/'.$p->id) ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-2 py-1 rounded" title="Laporan / Manifest">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </a>
                                        <a href="<?= base_url('admin/perjalanan_edit/'.$p->id) ?>" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-2 py-1 rounded" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <a href="<?= base_url('admin/perjalanan_delete/'.$p->id) ?>" onclick="return confirm('Hapus perjalanan ini?')" class="text-red-600 hover:text-red-900 bg-red-50 px-2 py-1 rounded" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </a>
                                    </div>
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
    </div>
</main>

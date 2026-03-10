<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h3 class="text-3xl font-bold text-gray-800">Manajemen Rute</h3>
                <p class="text-gray-500 mt-1">Daftar rute perjalanan dan harga.</p>
            </div>
            <a href="<?= base_url('admin/rute_add') ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full md:w-auto justify-center">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Rute
            </a>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700"><?= $this->session->flashdata('success') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ACTIONS BAR: SEARCH & BULK DELETE -->
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <!-- Search Form -->
            <form action="<?= base_url('admin/rute') ?>" method="GET" class="w-full md:w-1/3 flex">
                <input type="text" name="search" value="<?= isset($search) ? $search : '' ?>" placeholder="Cari Asal atau Tujuan..." class="flex-1 rounded-l-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
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
        <form id="bulkDeleteForm" action="<?= base_url('admin/rute_bulk_delete') ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">
        
        <!-- DESKTOP TABLE VIEW -->
        <div class="hidden md:block bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimasi Waktu</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak (KM)</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(empty($rute)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data rute.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($rute as $r): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="ids[]" value="<?= $r->id ?>" class="item-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $r->kota_asal ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $r->kota_tujuan ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 font-bold">Rp <?= number_format($r->harga, 0, ',', '.') ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $r->estimasi_waktu ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $r->jarak_km ?> km</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?= base_url('admin/rute_edit/'.$r->id) ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-full transition-colors mr-2">Edit</a>
                                    <a href="<?= base_url('admin/rute_delete/'.$r->id) ?>" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-full transition-colors">Hapus</a>
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
            <?php if(empty($rute)): ?>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center text-gray-500">
                    Belum ada data rute.
                </div>
            <?php else: ?>
                <?php foreach($rute as $r): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-gray-900 text-lg"><?= $r->kota_asal ?></span>
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                <span class="font-bold text-gray-900 text-lg"><?= $r->kota_tujuan ?></span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1"><?= $r->jarak_km ?> km • <?= $r->estimasi_waktu ?></p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                             Rp <?= number_format($r->harga, 0, ',', '.') ?>
                        </span>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <a href="<?= base_url('admin/rute_delete/'.$r->id) ?>" onclick="return confirm('Yakin hapus?')" class="flex items-center text-red-600 hover:text-red-900 text-sm font-medium">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Rute
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</main>

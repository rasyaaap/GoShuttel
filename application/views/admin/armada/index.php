<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h3 class="text-3xl font-bold text-gray-800">Manajemen Armada</h3>
                <p class="text-gray-500 mt-1">Kelola data kendaraan dan layout kursi.</p>
            </div>
            <a href="<?= base_url('admin/armada_add') ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full md:w-auto justify-center">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Armada
            </a>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                 <p class="text-sm text-green-700"><?= $this->session->flashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <!-- ACTIONS BAR: SEARCH & BULK DELETE -->
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <!-- Search Form -->
            <form action="<?= base_url('admin/armada') ?>" method="GET" class="w-full md:w-1/3 flex">
                <input type="text" name="search" value="<?= isset($search) ? $search : '' ?>" placeholder="Cari Armada, Plat, atau Status..." class="flex-1 rounded-l-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
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
        <form id="bulkDeleteForm" action="<?= base_url('admin/armada_bulk_delete') ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">

        <!-- Header Checkbox (for Cards view, put it outside or use a toolbar) -->
        <div class="mb-2 flex items-center bg-white p-3 rounded-lg shadow-sm w-fit border border-gray-200">
            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2">
            <label for="selectAll" class="text-xs text-gray-700 font-medium">Pilih Semua</label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
             <?php if(empty($armada)): ?>
                <div class="col-span-3 text-center py-10 text-gray-500 bg-white rounded-lg border border-dashed border-gray-300">
                    Belum ada data armada.
                </div>
            <?php else: ?>
                <?php foreach($armada as $a): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow relative">
                    <!-- Checkbox absolute positioned -->
                     <div class="absolute top-4 right-4 z-10">
                        <input type="checkbox" name="ids[]" value="<?= $a->id ?>" class="item-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-5 w-5">
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start">
                             <div>
                                <h4 class="text-lg font-bold text-gray-900 pr-8"><?= $a->nama_armada ?></h4>
                                <p class="text-sm text-gray-500 mt-1"><?= $a->plat_nomor ?></p>
                            </div>
                            <!-- Status badge moved slightly or kept same, checkbox is overlay -->
                        </div>
                         <div class="mt-2 text-xs">
                             <span class="px-2 py-1 inline-flex font-semibold rounded-full bg-green-100 text-green-800">
                                <?= ucfirst($a->status) ?>
                            </span>
                         </div>
                        
                        <div class="mt-4 flex flex-col space-y-2 text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Kapasitas: <strong><?= $a->kapasitas ?> Kursi</strong>
                            </span>
                             <span class="flex items-center">
                                <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Layout: <strong><?= $a->layout_kursi ?></strong>
                            </span>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end space-x-2">
                         <a href="<?= base_url('admin/armada_edit/'.$a->id) ?>" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                         <span class="text-gray-300">|</span>
                         <a href="<?= base_url('admin/armada_delete/'.$a->id) ?>" onclick="return confirm('Yakin hapus armada ini?')" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
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

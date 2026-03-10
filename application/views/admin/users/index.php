<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h3 class="text-3xl font-bold text-gray-800">Manajemen User</h3>
                <p class="text-gray-500 mt-1">Kelola data pengguna, driver, dan admin.</p>
            </div>
            <a href="<?= base_url('admin/user_add') ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full md:w-auto justify-center">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Tambah User
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
            <form action="<?= base_url('admin/users') ?>" method="GET" class="w-full md:w-1/3 flex">
                <input type="text" name="search" value="<?= isset($search) ? $search : '' ?>" placeholder="Cari Nama, Email, atau Role..." class="flex-1 rounded-l-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-lg bg-gray-50 text-gray-700 hover:bg-gray-100 font-medium">
                    Cari
                </button>
            </form>

            <!-- Bulk Delete Button (Hidden by default, toggled via JS) -->
             <button type="button" onclick="submitBulkDelete()" id="btnBulkDelete" class="hidden items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Terpilih
            </button>
        </div>

        <!-- BULK DELETE FORM WRAPPER -->
        <form id="bulkDeleteForm" action="<?= base_url('admin/users_bulk_delete') ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">

        <!-- DESKTOP TABLE VIEW -->
        <div class="hidden md:block bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach($users as $u): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="ids[]" value="<?= $u->id ?>" class="item-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full bg-gray-200 object-cover" src="https://ui-avatars.com/api/?name=<?= urlencode($u->name) ?>&background=random" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= $u->name ?></div>
                                        <div class="text-sm text-gray-500">Join: <?= date('M Y', strtotime($u->created_at)) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= $u->email ?></div>
                                <div class="text-sm text-gray-500"><?= $u->phone ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $u->role == 'admin' ? 'bg-red-100 text-red-800' : ($u->role == 'driver' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                                    <?= ucfirst($u->role) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?= base_url('admin/user_edit/'.$u->id) ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-full text-xs mr-1">Edit</a>
                                <a href="<?= base_url('admin/user_reset_password/'.$u->id) ?>" onclick="return confirm('Reset password user ini menjadi \'raaster123\'?')" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 hover:bg-yellow-100 px-3 py-1 rounded-full text-xs mr-1">Reset Pass</a>
                                <a href="<?= base_url('admin/user_delete/'.$u->id) ?>" onclick="return confirm('Yakin hapus user ini?')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-full text-xs">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
            <?php foreach($users as $u): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center space-x-4 mb-4">
                     <img class="h-12 w-12 rounded-full bg-gray-200 object-cover" src="https://ui-avatars.com/api/?name=<?= urlencode($u->name) ?>&background=random" alt="">
                     <div>
                         <h4 class="text-lg font-bold text-gray-900"><?= $u->name ?></h4>
                         <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?= $u->role == 'admin' ? 'bg-red-100 text-red-800' : ($u->role == 'driver' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                            <?= ucfirst($u->role) ?>
                        </span>
                     </div>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <?= $u->email ?>
                    </div>
                     <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <?= $u->phone ?>
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-100 flex justify-end">
                    <a href="<?= base_url('admin/user_reset_password/'.$u->id) ?>" onclick="return confirm('Reset password user ini menjadi \'raaster123\'?')" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 hover:bg-yellow-100 px-3 py-1 rounded-full text-xs font-semibold">
                        Reset Password
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</main>

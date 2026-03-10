<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="<?= base_url('admin/users') ?>" class="text-gray-400 hover:text-gray-600 mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h3 class="text-3xl font-bold text-gray-800"><?= isset($user) ? 'Edit User' : 'Tambah User Baru' ?></h3>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-8">
                <?= validation_errors('<div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm">', '</div>') ?>

                <?php $url = isset($user) ? 'admin/user_update' : 'admin/user_add'; ?>
                <form action="<?= base_url($url) ?>" method="POST" class="space-y-6">
                    <?php if(isset($user)): ?>
                        <input type="hidden" name="id" value="<?= $user->id ?>">
                    <?php endif; ?>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="<?= isset($user) ? $user->name : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nama Lengkap">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="<?= isset($user) ? $user->email : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                            <input type="text" name="phone" value="<?= isset($user) ? $user->phone : '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="08xxxxxxxx">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password <?= isset($user) ? '(Biarkan kosong jika tidak diubah)' : '' ?></label>
                        <input type="password" name="password" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="*******">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role / Peran</label>
                        <select name="role" id="role-select" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                             <option value="customer" <?= (isset($user) && $user->role == 'customer') ? 'selected' : '' ?>>Customer (Penumpang)</option>
                             <option value="driver" <?= (isset($user) && $user->role == 'driver') ? 'selected' : ((isset($preselected_role) && $preselected_role == 'driver') ? 'selected' : '') ?>>Driver (Supir)</option>
                             <option value="admin" <?= (isset($user) && $user->role == 'admin') ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <!-- Armada Selection (Initially Hidden) -->
                    <!-- Only show on Create, hide on Edit per user request -->
                    <?php if(!isset($user)): ?>
                    <div id="armada-field" class="hidden bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                        <label class="block text-sm font-medium text-indigo-900 mb-1">Pilih Armada (Khusus Driver)</label>
                        <select name="armada_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                             <option value="">-- Pilih Armada --</option>
                             <?php if(!empty($armada_list)): ?>
                                <?php foreach($armada_list as $a): ?>
                                    <?php 
                                        $is_taken = !empty($a->current_driver_name);
                                        // "My" armada if I am the one using it (when editing)
                                        $is_mine = (isset($current_armada_id) && $current_armada_id == $a->id);
                                        
                                        // Disable if taken AND not mine
                                        $disabled = ($is_taken && !$is_mine) ? 'disabled' : '';
                                        
                                        // Text suffix
                                        $suffix = '';
                                        if ($is_taken) {
                                            $suffix = $is_mine ? ' (Saat ini dipakai user ini)' : ' (Dipakai: ' . $a->current_driver_name . ')';
                                        }
                                        
                                        // Selected state
                                        $selected = (isset($current_armada_id) && $current_armada_id == $a->id) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $a->id ?>" <?= $disabled ?> <?= $selected ?> class="<?= $disabled ? 'text-gray-400 bg-gray-50' : '' ?>">
                                        <?= $a->nama_armada ?> (<?= $a->plat_nomor ?>) <?= $suffix ?>
                                    </option>
                                <?php endforeach; ?>
                             <?php endif; ?>
                        </select>
                        <p class="text-xs text-indigo-500 mt-1">Driver akan ditugaskan ke armada ini.</p>
                    </div>
                    <?php endif; ?>

                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="<?= base_url('admin/users') ?>" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <?= isset($user) ? 'Simpan Perubahan' : 'Simpan User' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    const roleSelect = document.getElementById('role-select');
    const armadaField = document.getElementById('armada-field');

    function toggleArmada() {
        if (!armadaField) return; // Exit if field doesn't exist (e.g. edit mode)
        if (roleSelect.value === 'driver') {
            armadaField.classList.remove('hidden');
        } else {
            armadaField.classList.add('hidden');
        }
    }

    roleSelect.addEventListener('change', toggleArmada);
    // Init
    toggleArmada();
</script>

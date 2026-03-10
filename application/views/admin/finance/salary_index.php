<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-3xl font-bold text-gray-800">Manajemen Gaji Driver</h3>
            <a href="<?= base_url('admin/payment_history') ?>" class="text-indigo-600 hover:text-indigo-900 border border-indigo-200 px-4 py-2 rounded-lg bg-white">
                Lihat Riwayat Pembayaran
            </a>
        </div>

        <!-- Global Settings -->
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 mb-6">
            <form action="<?= base_url('admin/payments_bulk_update') ?>" method="POST" class="flex items-center space-x-4">
                <label class="text-indigo-800 font-bold">Atur Tarif Global (Semua Driver):</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="global_rate" value="100000" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="100000">
                </div>
                <button type="submit" onclick="return confirm('Ini akan mengubah tarif untuk SEMUA driver. Lanjutkan?')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-indigo-700">
                    Update Semua
                </button>
            </form>
        </div>
        
        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                 <p class="text-sm text-green-700"><?= $this->session->flashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total PP (Selesai)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Per PP (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Est. Total Gaji</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(empty($drivers)): ?>
                        <tr><td colspan="5" class="px-6 py-4 text-center">Belum ada driver.</td></tr>
                    <?php else: ?>
                        <?php foreach($drivers as $d): 
                            $rate = $d->gaji_per_trip ?: 100000; // Default 100k
                            $total_gaji = $rate * $d->total_pp;
                        ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900"><?= $d->name ?></div>
                                <div class="text-xs text-gray-500"><?= $d->phone ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs font-bold">
                                    <?= $d->total_pp ?> PP
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="<?= base_url('admin/update_salary_rate') ?>" method="POST" class="flex items-center space-x-2">
                                    <input type="hidden" name="user_id" value="<?= $d->id ?>">
                                    <input type="number" name="rate" value="<?= $rate ?>" class="w-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block px-2 py-1">
                                    <button type="submit" class="text-blue-600 hover:text-blue-900" title="Simpan Tarif">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-gray-700">
                                Rp <?= number_format($total_gaji, 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?= base_url('admin/payment_add?driver_id=' . $d->id . '&amount=' . $total_gaji) ?>" class="text-indigo-600 hover:text-indigo-900 font-bold" title="Bayar Gaji">
                                    Bayar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-3xl font-bold text-gray-800">Riwayat Pembayaran Driver</h3>
            <a href="<?= base_url('admin/payment_add') ?>" class="bg-indigo-600 px-5 py-2.5 rounded-lg text-white font-medium hover:bg-indigo-700 shadow-lg flex items-center transition-all transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Buat Pembayaran
            </a>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p><?= $this->session->flashdata('success'); ?></p>
            </div>
        <?php endif; ?>

        <!-- Table (Desktop) -->
        <div class="hidden md:block bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Driver</th>
                            <th class="px-6 py-4">Jumlah</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4">Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($payments as $p): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-500 font-mono">
                                <?= date('d M Y', strtotime($p->payment_date)) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs mr-3">
                                        <?= substr($p->driver_name, 0, 1) ?>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900"><?= $p->driver_name ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-green-600">
                                Rp <?= number_format($p->amount, 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?= $p->note ?: '-' ?>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-400 italic">
                                <?= $p->admin_name ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($payments)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada data pembayaran.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cards (Mobile) -->
        <div class="md:hidden space-y-4">
             <?php if(empty($payments)): ?>
                <div class="text-center text-gray-500 py-10">Belum ada data pembayaran.</div>
            <?php else: ?>
                <?php foreach($payments as $p): ?>
                <div class="bg-white shadow rounded-lg p-5 border border-gray-100">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs mr-3">
                                <?= substr($p->driver_name, 0, 1) ?>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900"><?= $p->driver_name ?></h4>
                                <p class="text-xs text-gray-500"><?= date('d M Y', strtotime($p->payment_date)) ?></p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-green-600">Rp <?= number_format($p->amount, 0, ',', '.') ?></span>
                    </div>
                    <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-50">
                        <?= $p->note ?: 'Tidak ada keterangan' ?>
                    </div>
                    <div class="mt-2 text-right">
                         <span class="text-xs text-gray-400 italic">Oleh: <?= $p->admin_name ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<div class="px-4 py-6 sm:px-0">
    <!-- Header -->
    <h3 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate mb-6">Manajemen Pemesanan</h3>

    <?php if($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= $this->session->flashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <!-- Table (Desktop) -->
    <div class="hidden md:block bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID / Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rute & Armada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Bayar</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(empty($bookings)): ?>
                        <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data pemesanan.</td></tr>
                    <?php else: ?>
                        <?php foreach($bookings as $b): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-indigo-600 block"><?= $b->id ?></span>
                                <span class="text-xs text-gray-500"><?= date('d M Y H:i', strtotime($b->tanggal_pemesanan)) ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= $b->nama_pemesan ?></div>
                                <div class="text-xs text-gray-500"><?= $b->phone ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-bold"><?= $b->kota_asal ?> &rarr; <?= $b->kota_tujuan ?></div>
                                <div class="text-xs text-gray-500"><?= $b->nama_armada ?? '-' ?> • <?= date('d M', strtotime($b->tanggal)) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                Rp <?= number_format($b->total_harga, 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $b->status_pembayaran == 'lunas' ? 'bg-green-100 text-green-800' : 
                                       ($b->status_pembayaran == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= ucfirst($b->status_pembayaran) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($b->bukti_bayar): ?>
                                    <button onclick="openModal('<?= base_url('uploads/bukti_bayar/'.$b->bukti_bayar) ?>')" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium underline">
                                        Lihat Bukti
                                    </button>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400 italic">Belum upload</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <?php if($b->status_pembayaran == 'pending' && $b->bukti_bayar): ?>
                                    <a href="<?= base_url('admin/booking_verify/'.$b->id.'/approve') ?>" onclick="return confirm('Verifikasi Lunas?')" class="text-green-600 hover:text-green-900 bg-green-50 px-3 py-1 rounded-full">Terima</a>
                                    <a href="<?= base_url('admin/booking_verify/'.$b->id.'/reject') ?>" onclick="return confirm('Tolak Pembayaran?')" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-full">Tolak</a>
                                <?php elseif($b->status_pembayaran == 'lunas'): ?>
                                    <span class="text-gray-400 text-xs">Verified</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cards (Mobile) -->
    <div class="md:hidden space-y-4">
        <?php if(empty($bookings)): ?>
            <div class="text-center text-gray-500 py-10">Belum ada data pemesanan.</div>
        <?php else: ?>
            <?php foreach($bookings as $b): ?>
            <div class="bg-white shadow rounded-lg p-4 border border-gray-100 relative">
                 <div class="absolute top-4 right-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        <?= $b->status_pembayaran == 'lunas' ? 'bg-green-100 text-green-800' : 
                           ($b->status_pembayaran == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                        <?= ucfirst($b->status_pembayaran) ?>
                    </span>
                 </div>
                 
                 <div class="mb-2">
                     <span class="text-xs text-gray-500">ID: <?= $b->id ?></span>
                     <h4 class="text-sm font-bold text-gray-900"><?= $b->nama_pemesan ?></h4>
                     <p class="text-xs text-gray-500"><?= $b->phone ?></p>
                 </div>
                 
                 <div class="mb-3 border-t border-b border-gray-50 py-2">
                     <div class="flex justify-between items-center text-sm">
                         <div>
                             <span class="block text-xs text-gray-400">Rute</span>
                             <span class="font-semibold text-gray-800"><?= $b->kota_asal ?> &rarr; <?= $b->kota_tujuan ?></span>
                         </div>
                         <div class="text-right">
                              <span class="block text-xs text-gray-400">Jadwal</span>
                              <span class="font-medium text-gray-800"><?= date('d M', strtotime($b->tanggal)) ?></span>
                         </div>
                     </div>
                 </div>

                 <div class="flex justify-between items-center mb-3">
                     <div>
                         <span class="text-xs text-gray-400">Total</span>
                         <p class="font-bold text-indigo-600">Rp <?= number_format($b->total_harga, 0, ',', '.') ?></p>
                     </div>
                     <?php if($b->bukti_bayar): ?>
                        <button onclick="openModal('<?= base_url('uploads/bukti_bayar/'.$b->bukti_bayar) ?>')" class="text-indigo-600 text-xs font-medium underline">
                            Lihat Bukti
                        </button>
                     <?php endif; ?>
                 </div>

                 <!-- Actions -->
                 <?php if($b->status_pembayaran == 'pending' && $b->bukti_bayar): ?>
                    <div class="flex space-x-2 mt-2">
                        <a href="<?= base_url('admin/booking_verify/'.$b->id.'/approve') ?>" onclick="return confirm('Verifikasi Lunas?')" class="flex-1 bg-green-600 text-white text-center py-2 rounded text-xs font-bold">Terima</a>
                        <a href="<?= base_url('admin/booking_verify/'.$b->id.'/reject') ?>" onclick="return confirm('Tolak Pembayaran?')" class="flex-1 bg-red-100 text-red-700 text-center py-2 rounded text-xs font-bold">Tolak</a>
                    </div>
                 <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start justify-center">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Bukti Pembayaran</h3>
                        <div class="mt-2 flex justify-center bg-gray-100 rounded-lg p-2">
                            <img id="modalImage" src="" alt="Bukti Bayar" class="max-h-96 object-contain rounded">
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }
</script>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8 print:bg-white print:p-0">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6 print:hidden">
            <h3 class="text-3xl font-bold text-gray-800">Laporan Perjalanan</h3>
            <div class="flex space-x-2">
                <a href="<?= base_url('admin/perjalanan') ?>" class="text-indigo-600 hover:text-indigo-900 border border-indigo-200 px-4 py-2 rounded-lg bg-white">
                    &larr; Kembali
                </a>
                <button onclick="window.print()" class="text-white bg-gray-800 hover:bg-gray-900 px-4 py-2 rounded-lg shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 print:shadow-none print:border-0">
            <!-- Header Report -->
            <div class="border-b border-gray-200 pb-6 mb-6">
                <div class="flex justify-between items-end">
                    <div>
                        <h1 class="text-2xl font-bold text-indigo-900 uppercase tracking-wide">Raaster Shuttle</h1>
                        <p class="text-sm text-gray-500">Bukti Laporan & Manifest Perjalanan</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400">ID Perjalanan</p>
                        <p class="font-mono font-bold text-lg text-gray-900">#<?= $perjalanan->id ?></p>
                    </div>
                </div>
            </div>

            <!-- Trip Info -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <div>
                    <h5 class="text-xs font-bold text-gray-400 uppercase mb-1">Jadwal Keberangkatan</h5>
                    <p class="text-lg font-bold text-gray-800"><?= date('d M Y', strtotime($perjalanan->tanggal)) ?></p>
                    <p class="text-gray-600"><?= date('H:i', strtotime($perjalanan->jam_berangkat)) ?> WIB</p>
                </div>
                <div>
                    <h5 class="text-xs font-bold text-gray-400 uppercase mb-1">Rute</h5>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-900"><?= $perjalanan->kota_asal ?></span>
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        <span class="font-medium text-gray-900"><?= $perjalanan->kota_tujuan ?></span>
                    </div>
                </div>
                 <div>
                    <h5 class="text-xs font-bold text-gray-400 uppercase mb-1">Driver & Armada</h5>
                    <p class="text-gray-800 font-bold"><?= $perjalanan->nama_driver ?: '-' ?></p>
                    <p class="text-sm text-gray-600"><?= $perjalanan->nama_armada ?> (<?= $perjalanan->plat_nomor ?>)</p>
                </div>
            </div>

            <!-- Passengers Table -->
            <h4 class="font-bold text-gray-800 mb-4 border-l-4 border-indigo-500 pl-3">Manifest Penumpang</h4>
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. Kursi</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Penumpang</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status Jemput</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Tarif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php 
                        $total_omzet = 0;
                        foreach($passengers as $p): 
                            $total_omzet += $p->total_harga; // Assuming total_harga is per booking (could be sum if seats split, but here simpler)
                        ?>
                        <tr>
                            <td class="px-4 py-2 text-sm font-bold text-gray-800"><?= $p->nomor_kursi_list ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                <?= $p->nama_customer ?> <br>
                                <span class="text-xs text-gray-400"><?= $p->id ?></span>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <?php if($p->is_picked_up): ?>
                                    <span class="text-green-600 font-bold text-xs uppercase">Sudah Dijemput</span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">Belum Jemput</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-sm text-right font-mono">
                                Rp <?= number_format($p->total_harga, 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-800 uppercase">Total Pendapatan</td>
                            <td class="px-4 py-3 text-right font-bold text-indigo-700 font-mono text-lg">
                                Rp <?= number_format($total_omzet, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Footer Report -->
             <div class="flex justify-between mt-12 pt-8 border-t border-gray-200 text-sm text-gray-500">
                <div>
                    <p>Dicetak pada: <?= date('d M Y H:i') ?></p>
                    <p>Oleh: <?= $this->session->userdata('name') ?> (Admin)</p>
                </div>
                 <div class="text-right">
                    <p>Bangsri,Jepara</p>
                    <p>Telp: (021) 555-0199</p>
                </div>
             </div>
        </div>
    </div>
</main>
<style>
    @media print {
        header, nav, aside, .print\:hidden { display: none !important; }
        .print\:border-0 { border: none !important; }
        .print\:shadow-none { box-shadow: none !important; }
        .print\:bg-white { background: white !important; }
        .print\:p-0 { padding: 0 !important; }
        body { background: white; }
    }
</style>

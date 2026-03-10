<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <h3 class="text-3xl font-bold text-gray-800 mb-8">Keluhan Pelanggan</h3>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase">
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Nama / Email</th>
                            <th class="px-6 py-4">Subjek & Pesan</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($complaints as $c): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <?php if($c->status == 'pending'): ?>
                                    <span class="px-2 py-1 text-xs font-bold bg-yellow-100 text-yellow-800 rounded-full">PENDING</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-bold bg-green-100 text-green-800 rounded-full">SELESAI</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 font-mono">
                                <?= date('d M Y', strtotime($c->created_at)) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800"><?= $c->name ?></div>
                                <div class="text-xs text-blue-500"><?= $c->email ?></div>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate">
                                <div class="text-sm font-bold text-gray-800 truncate"><?= $c->subject ?></div>
                                <div class="text-xs text-gray-500 truncate"><?= $c->message ?></div>
                            </td>
                            <td class="px-6 py-4 flex space-x-2">
                                <?php if($c->status == 'pending'): ?>
                                <a href="<?= base_url('admin/complaint_resolve/'.$c->id) ?>" class="text-green-600 hover:text-green-900 text-xs font-bold uppercase border border-green-200 bg-green-50 px-2 py-1 rounded">Selesaikan</a>
                                <?php endif; ?>
                                <a href="<?= base_url('admin/complaint_delete/'.$c->id) ?>" onclick="return confirm('Hapus?')" class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($complaints)): ?>
                        <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada keluhan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4">
            <?php foreach($complaints as $c): ?>
            <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-xs text-gray-400 font-mono block mb-1"><?= date('d M Y, H:i', strtotime($c->created_at)) ?></span>
                        <h4 class="font-bold text-gray-900"><?= $c->subject ?></h4>
                    </div>
                    <?php if($c->status == 'pending'): ?>
                        <span class="px-2 py-1 text-[10px] font-bold bg-yellow-100 text-yellow-800 rounded-full">PENDING</span>
                    <?php else: ?>
                        <span class="px-2 py-1 text-[10px] font-bold bg-green-100 text-green-800 rounded-full">SELESAI</span>
                    <?php endif; ?>
                </div>
                
                <div class="mb-4">
                    <p class="text-gray-600 text-sm bg-gray-50 p-3 rounded-lg border border-gray-100 leading-relaxed">
                        <?= nl2br($c->message) ?>
                    </p>
                </div>

                <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs uppercase">
                            <?= substr($c->name, 0, 1) ?>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-800"><?= $c->name ?></div>
                            <div class="text-[10px] text-gray-500"><?= $c->email ?></div>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                         <?php if($c->status == 'pending'): ?>
                            <a href="<?= base_url('admin/complaint_resolve/'.$c->id) ?>" class="p-2 bg-green-50 text-green-600 rounded-lg border border-green-200 hover:bg-green-100 transition" title="Selesaikan">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/complaint_delete/'.$c->id) ?>" onclick="return confirm('Hapus keluhan ini?')" class="p-2 bg-red-50 text-red-600 rounded-lg border border-red-200 hover:bg-red-100 transition" title="Hapus">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($complaints)): ?>
                <div class="text-center py-10 text-gray-400 bg-white rounded-xl border border-dashed border-gray-300">
                    <p>Belum ada keluhan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

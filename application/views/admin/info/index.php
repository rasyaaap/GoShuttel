<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-3xl font-bold text-gray-800">Manajemen Info Terkini</h3>
                <p class="text-gray-500 mt-1">Kelola konten promo, rute, dan info untuk dashboard customer.</p>
            </div>
            <a href="<?= base_url('admin/info_add') ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Info
            </a>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                 <p class="text-sm text-green-700"><?= $this->session->flashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Konten</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach($infos as $info): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900"><?= $info->title ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $bg = 'bg-gray-100 text-gray-800';
                                    if($info->info_type == 'promo') $bg = 'bg-pink-100 text-pink-800';
                                    if($info->info_type == 'rute') $bg = 'bg-indigo-100 text-indigo-800';
                                    if($info->info_type == 'news') $bg = 'bg-purple-100 text-purple-800';
                                    if($info->info_type == 'warning') $bg = 'bg-amber-100 text-amber-800';
                                    if($info->info_type == 'success') $bg = 'bg-emerald-100 text-emerald-800';
                                    if($info->info_type == 'dark') $bg = 'bg-gray-800 text-gray-100';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $bg ?>">
                                    <?= ucfirst($info->info_type) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $info->tag_text ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs"><?= $info->content ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?= base_url('admin/info_edit/'.$info->id) ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-full text-xs mr-1">Edit</a>
                                <a href="<?= base_url('admin/info_delete/'.$info->id) ?>" onclick="return confirm('Yakin hapus info ini?')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-full text-xs">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(empty($infos)): ?>
                    <p class="text-center py-8 text-gray-500">Belum ada info terkini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

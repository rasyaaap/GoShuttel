<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-3xl font-bold text-gray-800">Galeri Foto</h3>
            <a href="<?= base_url('admin/gallery_add') ?>" class="bg-indigo-600 px-5 py-2.5 rounded-lg text-white font-medium hover:bg-indigo-700 shadow-lg flex items-center transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                Tambah Foto
            </a>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach($gallery as $g): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="h-48 overflow-hidden relative">
                    <?php if($g->image): ?>
                        <img src="<?= $g->image ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <?php else: ?>
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    <?php endif; ?>
                    <div class="absolute top-2 right-2">
                        <span class="bg-black/50 backdrop-blur text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase"><?= $g->category ?></span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h4 class="font-bold text-gray-800 mb-1 truncate"><?= $g->title ?></h4>
                    <p class="text-xs text-gray-500 mb-3 line-clamp-2"><?= $g->description ?></p>
                    <div class="flex justify-end space-x-2 pt-2 border-t border-gray-50">
                            <a href="<?= base_url('admin/gallery_edit/'.$g->id) ?>" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold uppercase">Edit</a>
                            <a href="<?= base_url('admin/gallery_delete/'.$g->id) ?>" onclick="return confirm('Hapus foto ini?')" class="text-red-600 hover:text-red-800 text-xs font-bold uppercase">Hapus</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($gallery)): ?>
                <div class="col-span-full text-center py-10 text-gray-400">Belum ada foto di galeri.</div>
            <?php endif; ?>
        </div>
    </div>
</main>

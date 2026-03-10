<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <h3 class="text-3xl font-bold text-gray-800 mb-6">Pengaturan Landing Page</h3>

        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700"><?= $this->session->flashdata('success'); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-8">
                <form action="<?= base_url('admin/update_landing_settings') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    
                    <!-- Tagline -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero Badge / Tagline</label>
                        <input type="text" name="hero_tagline" value="<?= $settings['hero_tagline'] ?? '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Mitra Perjalanan Terpercaya">
                        <p class="mt-1 text-xs text-gray-500">Teks kecil di atas judul utama.</p>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero Title</label>
                        <textarea name="hero_title" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm" required><?= $settings['hero_title'] ?? '' ?></textarea>
                        <div class="mt-1 text-xs text-gray-500">
                             Mendukung HTML & Tailwind. Contoh: <code>&lt;span class="text-blue-600"&gt;Teks Biru&lt;/span&gt;</code>
                        </div>
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero Subtitle</label>
                        <textarea name="hero_subtitle" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Deskripsi singkat..."><?= $settings['hero_subtitle'] ?? '' ?></textarea>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
                        
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0">
                                <?php if(!empty($settings['hero_image'])): ?>
                                    <img class="h-24 w-40 object-cover rounded-lg shadow-sm border border-gray-200" src="<?= $settings['hero_image'] ?>" alt="Current background">
                                <?php else: ?>
                                    <div class="h-24 w-40 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                <?php endif; ?>
                            </div>
                            <label class="block w-full">
                                <span class="sr-only">Choose profile photo</span>
                                <input type="file" name="hero_image_file" class="block w-full text-sm text-slate-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100
                                "/>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Atau gunakan URL Link (Opsional)</label>
                            <input type="text" name="hero_image" value="<?= $settings['hero_image'] ?? '' ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="https://example.com/image.jpg">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                             <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

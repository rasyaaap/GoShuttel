<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <ol class="list-reset flex">
                <li><a href="<?= base_url('admin/payments') ?>" class="text-indigo-600 hover:text-indigo-800">Keuangan</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Buat Pembayaran</li>
            </ol>
        </nav>

        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Form Pembayaran Driver</h3>
            </div>
            
            <form action="<?= base_url('admin/payment_add') ?>" method="POST" class="p-8">
                
                <!-- Driver Selection -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Driver Penerima</label>
                    <div class="relative">
                        <select name="user_id" class="block appearance-none w-full bg-gray-50 border border-gray-300 hover:border-indigo-500 px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all cursor-pointer">
                            <option value="">-- Pilih Driver --</option>
                            <?php foreach($drivers as $d): ?>
                                <option value="<?= $d->id ?>" <?= (isset($pre_driver_id) && $pre_driver_id == $d->id) ? 'selected' : '' ?>>
                                    <?= $d->name ?> (<?= $d->email ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                             <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Amount -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah (Rp)</label>
                        <input type="number" name="amount" value="<?= isset($pre_amount) ? $pre_amount : '' ?>" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition-all outline-none" placeholder="Contoh: 500000" min="0">
                    </div>
                    <!-- Date -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Waktu Pembayaran</label>
                        <input type="datetime-local" name="payment_date" value="<?= date('Y-m-d\TH:i') ?>" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition-all outline-none">
                    </div>
                </div>

                <!-- Note -->
                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan / Catatan</label>
                    <textarea name="note" rows="3" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition-all outline-none" placeholder="Misal: Gaji Minggu 1 Desember + Bonus Trip"></textarea>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="<?= base_url('admin/payments') ?>" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition-colors">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        Simpan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

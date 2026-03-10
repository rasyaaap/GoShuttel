<div class="bg-indigo-600 pb-32">
    <header class="py-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="<?= base_url('customer/dashboard') ?>" class="absolute top-10 left-4 sm:left-6 text-indigo-200 hover:text-white p-2 rounded-full hover:bg-indigo-500 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div class="pl-12"> <!-- Indent for back button -->
                <h1 class="text-3xl font-bold text-white">
                    Hasil Pencarian
                </h1>
                <p class="text-indigo-200 mt-2">
                    <?= $search_meta['asal'] ?> <span class="mx-2">&rarr;</span> <?= $search_meta['tujuan'] ?> &bullet; <?= date('d M Y', strtotime($search_meta['tanggal'])) ?>
                </p>
            </div>
        </div>
    </header>
</div>

<main class="-mt-32">
    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
            <!-- Search Form (Mini) -->
            <form action="<?= base_url('booking/search') ?>" method="GET" class="mb-8 border-b border-gray-200 pb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="kota_asal" value="<?= $search_meta['asal'] ?>" placeholder="Kota Asal" class="border border-gray-300 rounded-md px-3 py-2 w-full">
                    <input type="text" name="kota_tujuan" value="<?= $search_meta['tujuan'] ?>" placeholder="Kota Tujuan" class="border border-gray-300 rounded-md px-3 py-2 w-full">
                    <input type="date" name="tanggal" value="<?= $search_meta['tanggal'] ?>" class="border border-gray-300 rounded-md px-3 py-2 w-full">
                    <button type="submit" class="bg-indigo-600 text-white rounded-md px-4 py-2 hover:bg-indigo-700">Cari Ulang</button>
                </div>
            </form>

            <?php if(empty($jadwal)): ?>
                <div class="text-center py-10">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Jadwal tidak ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba cari rute atau tanggal lain.</p>
                </div>
            <?php else: ?>
                <div class="grid gap-6">
                    <?php foreach($jadwal as $j): ?>
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition flex flex-col md:flex-row justify-between items-center">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded mr-3">Shuttle</span>
                                    <h3 class="text-lg font-bold text-gray-900"><?= date('H:i', strtotime($j->jam_berangkat)) ?> WIB</h3>
                                </div>
                                <div class="flex items-center text-gray-600 mt-2">
                                    <div class="flex flex-col">
                                        <span class="font-medium"><?= $j->kota_asal ?></span>
                                    </div>
                                    <svg class="h-5 w-5 mx-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="font-medium"><?= $j->kota_tujuan ?></span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-3">
                                    Armada: <?= $j->nama_armada ?? 'HiAce Executive' ?> <br>
                                    Estimasi: <?= $j->estimasi_waktu ?>
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0 text-right">
                                <div class="text-2xl font-bold text-indigo-600 mb-2">
                                    Rp <?= number_format($j->harga, 0, ',', '.') ?>
                                </div>
                                <a href="<?= base_url('booking/select_seat/'.$j->id.'?tanggal='.$search_meta['tanggal']) ?>" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-md font-medium hover:bg-indigo-700 transition">
                                    Pilih Kursi
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

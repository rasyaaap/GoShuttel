<?php $this->load->view('layout/header', ['title' => 'Manifest Penumpang']); ?>

<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Manifest Penumpang
            </h1>
            <a href="<?= base_url('driver/dashboard') ?>" class="text-indigo-600 hover:text-indigo-900">Kembali</a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    <?= $trip->kota_asal ?> &rarr; <?= $trip->kota_tujuan ?>
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Jadwal: <?= date('H:i', strtotime($trip->jam_berangkat)) ?> WIB | Status: <span class="uppercase font-bold"><?= str_replace('_', ' ', $trip->status) ?></span>
                </p>
            </div>
            <?php if($trip->status != 'selesai'): ?>
                <a href="<?= base_url('driver/finish_trip/'.$trip->id) ?>" onclick="return confirm('Apakah Anda yakin tugas perjalanan ini sudah selesai?')" class="w-full sm:w-auto bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-center">
                    Selesai Tugas
                </a>
            <?php else: ?>
                <span class="w-full sm:w-auto text-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold border border-green-200">
                    TUGAS SELESAI
                </span>
            <?php endif; ?>
        </div>
        <ul class="divide-y divide-gray-200">
            <?php if(empty($passengers)): ?>
                <li class="px-4 py-4 text-center text-gray-500">Belum ada penumpang untuk perjalanan ini.</li>
            <?php else: ?>
                <?php foreach($passengers as $p): ?>
                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-indigo-600 truncate">
                                <?= $p->id ?> - <?= $p->nama_customer ?>
                            </p>
                            <div class="mt-2 flex">
                                <div class="flex items-start sm:items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 mt-0.5 sm:mt-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p class="break-words w-full sm:w-auto"><?= $p->alamat_jemput ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center space-x-2 sm:space-x-0 sm:space-y-2 w-full sm:w-auto border-t sm:border-t-0 border-gray-100 pt-3 sm:pt-0">
                             <!-- Chat Button -->
                            <a href="<?= base_url('chat/with_customer/'.$p->customer_id) ?>" class="flex-1 sm:flex-none flex justify-center items-center text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-2 sm:py-1 rounded-lg text-xs font-bold transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Chat
                            </a>
                            
                            <!-- Pickup Status/Button -->
                            <?php if(isset($p->is_picked_up) && $p->is_picked_up): ?>
                                <span class="flex-1 sm:flex-none flex justify-center items-center text-green-600 bg-green-50 px-3 py-2 sm:py-1 rounded-lg text-xs font-bold cursor-default border border-green-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Sudah Dijemput
                                </span>
                            <?php else: ?>
                                <a href="<?= base_url('driver/pickup_passenger/'.$p->id) ?>" onclick="return confirm('Konfirmasi penumpang sudah dijemput?')" class="flex-1 sm:flex-none flex justify-center items-center text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-2 sm:py-1 rounded-lg text-xs font-bold transition shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    Jemput
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>

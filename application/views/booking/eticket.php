<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden border-t-8 border-indigo-600 relative">
        <!-- Punch holes visual (CSS) -->
        <div class="absolute -left-3 top-1/2 w-6 h-6 rounded-full bg-gray-100"></div>
        <div class="absolute -right-3 top-1/2 w-6 h-6 rounded-full bg-gray-100"></div>

        <div class="px-8 py-8 text-center pt-12">
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-wider">E-TICKET</h1>
            <p class="text-sm text-gray-500 mt-1">Raaster Shuttel</p>
            
            <div class="mt-8 flex justify-center">
                <!-- Generate QR Code using Google Chart API or similar -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $booking->id ?>" alt="QR Code" class="border p-2 rounded-lg">
            </div>
            
            <div class="mt-4">
                <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full font-mono"><?= $booking->id ?></span>
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-6 border-t border-dashed border-gray-300">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <span class="block text-xs text-gray-500 uppercase">Penumpang</span>
                    <span class="block text-lg font-bold text-gray-800"><?= $this->session->userdata('name') ?></span>
                </div>
                 <div>
                    <span class="block text-xs text-gray-500 uppercase">Kursi</span>
                    <span class="block text-lg font-bold text-gray-800">
                        <?php foreach($booking->seats as $seat) echo $seat->nomor_kursi . ' '; ?>
                    </span>
                </div>
                 <div>
                    <span class="block text-xs text-gray-500 uppercase">Keberangkatan</span>
                    <span class="block text-lg font-bold text-gray-800"><?= $booking->kota_asal ?></span>
                    <span class="text-sm text-gray-600"><?= date('H:i', strtotime($booking->jam_berangkat)) ?></span>
                </div>
                 <div>
                    <span class="block text-xs text-gray-500 uppercase">Tujuan</span>
                    <span class="block text-lg font-bold text-gray-800"><?= $booking->kota_tujuan ?></span>
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-xs text-gray-500 uppercase mb-2">Lokasi Jemput</span>
                <p class="text-sm text-gray-700"><?= $booking->alamat_jemput ?></p>
            </div>
        </div>

        <div class="bg-indigo-600 px-8 py-4 text-center">
             <p class="text-indigo-200 text-sm">Tunjukkan QR Code ini kepada driver saat penjemputan.</p>
        </div>
    </div>
    
    <div class="mt-8 text-center">
        <a href="<?= base_url('customer/dashboard') ?>" class="text-indigo-600 hover:text-indigo-800 font-medium">Kembali ke Dashboard</a>
    </div>
</div>

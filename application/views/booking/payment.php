<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Order Summary Card -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-8 py-6 text-white flex justify-between items-center">
                    <div>
                        <p class="text-indigo-200 text-sm font-medium uppercase tracking-wider">Total Tagihan</p>
                        <h1 class="text-3xl font-bold mt-1">Rp <?= number_format($booking->total_harga, 0, ',', '.') ?></h1>
                    </div>
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="flex items-center space-x-4 mb-8 pb-8 border-b border-gray-100">
                         <div class="flex-1">
                             <p class="text-sm text-gray-500 mb-1">Kode Booking</p>
                             <p class="text-lg font-bold text-gray-900 tracking-wide font-mono bg-gray-50 inline-block px-3 py-1 rounded border border-gray-200 select-all"><?= $booking->id ?></p>
                         </div>
                         <div class="text-right">
                             <?php if($booking->status_pembayaran == 'lunas'): ?>
                                 <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Pembayaran Lunas
                                 </span>
                             <?php elseif($booking->status_pembayaran == 'pending' || $booking->bukti_bayar): ?>
                                 <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                    Menunggu Verifikasi
                                 </span>
                             <?php else: ?>
                                 <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Belum Dibayar
                                 </span>
                             <?php endif; ?>
                         </div>
                    </div>

                    <h3 class="text-gray-900 font-bold text-lg mb-4">Detail Perjalanan</h3>
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                     <div class="flex flex-col items-center">
                                         <div class="w-3 h-3 bg-indigo-600 rounded-full ring-2 ring-indigo-200"></div>
                                         <div class="w-0.5 h-10 bg-gray-300 my-1"></div>
                                         <div class="w-3 h-3 bg-red-500 rounded-full ring-2 ring-red-200"></div>
                                     </div>
                                     <div class="flex flex-col justify-between h-16">
                                         <div>
                                             <p class="text-sm text-gray-500">Keberangkatan</p>
                                             <p class="font-bold text-gray-900"><?= $booking->kota_asal ?></p>
                                         </div>
                                         <div>
                                             <p class="text-sm text-gray-500">Tujuan</p>
                                             <p class="font-bold text-gray-900"><?= $booking->kota_tujuan ?></p>
                                         </div>
                                     </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Jadwal</p>
                                <p class="font-bold text-gray-900 text-lg"><?= date('H:i', strtotime($booking->jam_berangkat)) ?></p>
                                <p class="text-sm text-gray-600"><?= date('d M Y', strtotime($booking->tanggal)) ?></p>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Kursi</p>
                                <div class="flex space-x-1 mt-1">
                                    <?php foreach($booking->seats as $seat): ?>
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 font-bold text-sm">
                                            <?= $seat->nomor_kursi ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold text-right">Armada</p>
                                <p class="text-sm font-medium text-gray-900 text-right"><?= $booking->nama_armada ?: 'Raaster Executive' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h3 class="text-gray-900 font-bold text-lg mb-6 flex items-center">
                    <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Transfer Bank
                </h3>
                
                <div class="space-y-4">
                    <!-- BCA -->
                    <div class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-indigo-300 transition-colors group">
                        <div class="w-16 h-10 bg-white border border-gray-100 rounded flex items-center justify-center p-1 mr-4 shadow-sm">
                             <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" class="h-full object-contain" alt="BCA">
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-1">Bank BCA</p>
                            <div class="flex items-center">
                                <p class="font-mono font-bold text-lg text-gray-800 mr-2" id="bca-num">8190234567</p>
                                <button onclick="copyToClipboard('bca-num')" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium opacity-0 group-hover:opacity-100 transition-opacity">Salin</button>
                            </div>
                            <p class="text-xs text-gray-400">a.n PT Raaster Shuttel</p>
                        </div>
                    </div>

                    <!-- BRI -->
                    <div class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-indigo-300 transition-colors group">
                        <div class="w-16 h-10 bg-white border border-gray-100 rounded flex items-center justify-center p-1 mr-4 shadow-sm">
                             <img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg" class="h-full object-contain" alt="BRI">
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-1">Bank BRI</p>
                            <div class="flex items-center">
                                <p class="font-mono font-bold text-lg text-gray-800 mr-2" id="bri-num">123401000001503</p>
                                <button onclick="copyToClipboard('bri-num')" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium opacity-0 group-hover:opacity-100 transition-opacity">Salin</button>
                            </div>
                            <p class="text-xs text-gray-400">a.n PT Raaster Shuttel</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Confirm Action -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-6">
                <!-- LOGIC: If 'lunas', show Ticket. If proof exists, show Waiting. Else, show Upload Form -->
                <?php if($booking->status_pembayaran == 'lunas'): ?>
                    <div class="text-center py-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h3>
                        <p class="text-sm text-gray-600 mb-6">Tiket Anda telah terbit. Silakan tunjukkan QR Code atau ID Booking kepada driver saat keberangkatan.</p>
                        
                        <a href="<?= base_url('booking/ticket/'.$booking->id) ?>" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-colors text-sm mb-3">
                            Download E-Tiket
                        </a>
                        <a href="<?= base_url('customer/dashboard') ?>" class="block w-full bg-white border border-gray-200 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition-colors text-sm">
                            Kembali ke Dashboard
                        </a>
                    </div>
                
                <?php elseif($booking->bukti_bayar): ?>
                    <div class="text-center py-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Menunggu Verifikasi</h3>
                        <p class="text-sm text-gray-600 mb-6">Bukti pembayaran Anda sedang kami verifikasi. Tiket akan terbit otomatis setelah disetujui.</p>
                        
                        <a href="<?= base_url('customer/dashboard') ?>" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-colors text-sm">
                            Kembali ke Dashboard
                        </a>
                         <p class="mt-4 text-xs text-gray-400">Hubungi admin jika verifikasi > 1 jam.</p>
                    </div>

                <?php else: ?>

                <h3 class="text-gray-900 font-bold mb-4">Instruksi</h3>
                <ol class="list-decimal list-inside space-y-3 text-sm text-gray-600 mb-8">
                    <li>Selesaikan pembayaran ke salah satu rekening di samping.</li>
                    <li>Pastikan nominal transfer sesuai hingga 3 digit terakhir.</li>
                    <li>Upload bukti transfer pada form di bawah ini.</li>
                </ol>

                <form action="<?= base_url('booking/process_payment') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="booking_id" value="<?= $booking->id ?>">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition-colors cursor-pointer" onclick="document.getElementById('bukti_bayar').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload file</span>
                                        <input id="bukti_bayar" name="bukti_bayar" type="file" class="sr-only" required onchange="previewFile()">
                                    </span>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                <p id="file-name" class="text-sm text-indigo-600 font-bold mt-2"></p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all text-sm mb-4">
                        Kirim Bukti Pembayaran
                    </button>
                    <a href="<?= base_url('customer/dashboard') ?>" class="block text-center w-full bg-white border border-gray-200 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition-colors text-sm">
                        Bayar Nanti
                    </a>
                </form>
                <?php endif; ?>

                <script>
                function previewFile() {
                    const fileInput = document.getElementById('bukti_bayar');
                    const fileNameDisplay = document.getElementById('file-name');
                    if (fileInput.files.length > 0) {
                        fileNameDisplay.textContent = fileInput.files[0].name;
                    }
                }
                </script>
                
                <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                     <p class="text-xs text-gray-400">Butuh bantuan? <a href="#" class="text-indigo-600 hover:underline">Hubungi CS kami</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(copyText).then(function() {
            alert("Nomor rekening disalin!");
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
        });
    }
</script>

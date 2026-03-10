<div class="max-w-xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden relative print:shadow-none print:border print:border-gray-300">
        <!-- Ticket Header -->
        <div class="bg-indigo-600 px-8 py-6 text-white text-center relative overflow-hidden">
             <!-- Dotted bottom border effect -->
            <div class="absolute bottom-0 left-0 w-full h-4 bg-white rounded-t-xl opacity-10"></div>
            
            <h2 class="text-2xl font-bold tracking-widest uppercase">E-Ticket</h2>
            <p class="text-indigo-200 text-sm mt-1">Raaster Shuttle</p>
        </div>

        <div class="p-8">
            <!-- QR Code Section -->
            <div class="flex justify-center mb-8">
                <div class="bg-white p-2 rounded-xl border-2 border-indigo-100 shadow-sm">
                    <!-- Placeholder QR (In real app, generate dynamic QR) -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $booking->id ?>" alt="QR Code" class="w-32 h-32 md:w-40 md:h-40">
                </div>
            </div>
            <p class="text-center text-gray-400 text-xs mb-6 uppercase tracking-wider">Scan Kode ini saat keberangkatan</p>
            
            <!-- Trip Details -->
            <div class="space-y-6">
                 <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-6">
                     <div class="text-left">
                         <p class="text-xs text-gray-400 font-bold uppercase">Berangkat</p>
                         <h3 class="text-xl font-bold text-gray-800"><?= $booking->kota_asal ?></h3>
                         <p class="text-sm text-indigo-600 font-medium"><?= date('H:i', strtotime($booking->jam_berangkat)) ?></p>
                     </div>
                     <div class="text-center px-4">
                         <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                     </div>
                     <div class="text-right">
                         <p class="text-xs text-gray-400 font-bold uppercase">Tujuan</p>
                         <h3 class="text-xl font-bold text-gray-800"><?= $booking->kota_tujuan ?></h3>
                         <p class="text-sm text-indigo-600 font-medium"><?= date('d M Y', strtotime($booking->tanggal)) ?></p>
                     </div>
                 </div>

                 <div class="flex justify-between items-end">
                     <div>
                         <p class="text-xs text-gray-400 font-bold uppercase mb-1">Penumpang</p>
                         <p class="text-sm font-bold text-gray-800"><?= $this->session->userdata('name') ?></p>
                         <p class="text-xs text-gray-500 mt-1">Kode Booking: <span class="text-indigo-600 font-mono font-bold"><?= $booking->id ?></span></p>
                     </div>
                     <div class="text-right">
                         <p class="text-xs text-gray-400 font-bold uppercase mb-1">Kursi</p>
                         <div class="flex justify-end space-x-1">
                             <?php foreach($booking->seats as $seat): ?>
                                <span class="bg-indigo-100 text-indigo-700 font-bold px-2 py-1 rounded text-sm"><?= $seat->nomor_kursi ?></span>
                             <?php endforeach; ?>
                         </div>
                     </div>
                 </div>
            </div>
        </div>

        <!-- Cutout Circles for Ticket Look -->
        <div class="absolute top-[35%] -left-3 w-6 h-6 bg-gray-50 rounded-full"></div>
        <div class="absolute top-[35%] -right-3 w-6 h-6 bg-gray-50 rounded-full"></div>
    </div>

    <!-- Footer Actions (Outside Ticket) -->
    <div class="mt-6 bg-white p-4 rounded-xl border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 print:hidden shadow-sm">
        <a href="<?= base_url('customer/dashboard') ?>" class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Dashboard
        </a>
        
        <div class="flex items-center space-x-3 w-full md:w-auto justify-end">
            <!-- Chat -->
            <?php if(!empty($booking->driver_id)): ?>
                <a href="<?= base_url('chat/with_driver/'.$booking->driver_id) ?>" class="bg-indigo-50 text-indigo-600 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-100 transition flex items-center border border-indigo-100">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Chat Driver
                </a>
            <?php endif; ?>

            <button id="download-btn" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Simpan Tiket
            </button>
        </div>
    </div>
    
    <div class="text-center mt-8 text-gray-400 text-xs print:hidden">
        <p>Tunjukkan e-ticket ini kepada petugas.</p>
        <p>&copy; 2025 Raaster Shuttle</p>
    </div>
</div>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    document.getElementById('download-btn').addEventListener('click', function() {
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Menyimpan...';
        btn.disabled = true;

        const ticketElement = document.querySelector('.max-w-xl > div.rounded-3xl'); // Select ONLY the ticket card
        
        html2canvas(ticketElement, {
            scale: 2, // High resolution
            useCORS: true, // Allow external images (QR)
            backgroundColor: null // Transparent background handling
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'Raaster-Ticket-<?= $booking->id ?>.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            btn.innerHTML = originalText;
            btn.disabled = false;
        }).catch(err => {
            console.error(err);
            alert('Gagal menyimpan tiket.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    });
</script>

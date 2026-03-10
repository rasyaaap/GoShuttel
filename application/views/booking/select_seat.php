<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Seat Selection -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Pilih Kursi</h2>
            
            <div class="flex justify-center mb-8 gap-4 text-sm">
                <div class="flex items-center"><div class="w-6 h-6 bg-gray-200 border rounded mr-2"></div> Tersedia</div>
                <div class="flex items-center"><div class="w-6 h-6 bg-red-500 rounded mr-2"></div> Terisi</div>
                <div class="flex items-center"><div class="w-6 h-6 bg-indigo-600 rounded mr-2"></div> Pilihanmu</div>
            </div>

            <!-- Seat Layout Visualization -->
            <div class="max-w-xs mx-auto bg-gray-100 p-8 rounded-xl border-2 border-gray-300 relative">
                <div class="absolute top-0 right-8 bg-gray-800 text-white px-2 py-1 text-xs rounded-b">Driver</div>
                
                <div class="mt-8 space-y-6">
                    <?php 
                    $rows = explode('-', $layout);
                    $rowNum = 1;
                    $letters = range('A', 'Z'); 

                    foreach($rows as $count): 
                        // If count is large (e.g. 4), we justify-between. If small (1), justify-end or start?
                        // Common patterns:
                        // 1: Driver side (right) or Single Left? Usually Single Left in 1-2 config.
                        // Let's assume standard right alignment for single seats in front, or center? 
                        // Based on previous code "1A" was "justify-end" (Right side).
                        
                        $justify = ($count == 1 || $rowNum == 1) ? 'justify-end' : 'justify-between';
                        if($count > 3) $justify = 'justify-between';
                    ?>
                    
                    <div class="flex <?= $justify ?>">
                        <?php for($i = 0; $i < $count; $i++): 
                            $seatCode = $rowNum . $letters[$i];
                            $status = in_array($seatCode, $booked_seats) ? 'disabled' : '';
                            $color = $status ? 'bg-red-500 cursor-not-allowed' : 'bg-white hover:bg-indigo-100 cursor-pointer seat-item';
                        ?>
                            <div data-seat="<?= $seatCode ?>" class="<?= $color ?> w-12 h-12 border-2 border-gray-300 rounded-lg flex items-center justify-center font-bold text-gray-600 shadow-sm transition">
                                <?= $seatCode ?>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <?php 
                    $rowNum++; 
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>

        <!-- Right: Booking Details & Map -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                <h3 class="text-xl font-bold mb-4">Detail Perjalanan</h3>
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <p class="text-gray-600">Rute</p>
                    <p class="font-bold"><?= $jadwal->kota_asal ?> - <?= $jadwal->kota_tujuan ?></p>
                    
                    <p class="text-gray-600 mt-2">Jadwal</p>
                    <p class="font-bold"><?= date('d M Y', strtotime($tanggal)) ?>, <?= date('H:i', strtotime($jadwal->jam_berangkat)) ?></p>
                    
                    <p class="text-gray-600 mt-2">Harga per Tiket</p>
                    <p class="font-bold text-indigo-600">Rp <?= number_format($jadwal->harga, 0, ',', '.') ?></p>
                </div>

                <form action="<?= base_url('booking/process_booking') ?>" method="POST" id="bookingForm">
                    <input type="hidden" name="jadwal_id" value="<?= $jadwal->id ?>">
                    <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                    <input type="hidden" name="harga" value="<?= $jadwal->harga ?>">
                    <input type="hidden" name="seats" id="selectedSeatsInput">
                    
                    <!-- Pickup Location -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Penjemputan</label>
                        <div id="map" class="h-48 w-full rounded-lg border border-gray-300 mb-2"></div>
                        <p class="text-xs text-gray-500">Geser pin ke lokasi penjemputan Anda.</p>
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="lng" id="lng">
                        <textarea name="alamat" placeholder="Detail alamat (cth: depan Alfamart)" class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm" rows="2" required></textarea>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-600">Total Bayar:</span>
                        <span class="text-2xl font-bold text-indigo-600" id="totalPrice">Rp 0</span>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition disabled:opacity-50" id="btnBook" disabled>
                        Lanjut Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // --- Seat Logic ---
    const seatItems = document.querySelectorAll('.seat-item');
    const seatsInput = document.getElementById('selectedSeatsInput');
    const totalPriceEl = document.getElementById('totalPrice');
    const btnBook = document.getElementById('btnBook');
    const pricePerSeat = <?= $jadwal->harga ?>;
    let selectedSeats = [];

    seatItems.forEach(item => {
        item.addEventListener('click', function() {
            if (this.classList.contains('disabled')) return;

            const seat = this.dataset.seat;
            if (selectedSeats.includes(seat)) {
                selectedSeats = selectedSeats.filter(s => s !== seat);
                this.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                this.classList.add('bg-white', 'text-gray-600', 'hover:bg-indigo-100');
            } else {
                selectedSeats.push(seat);
                this.classList.remove('bg-white', 'text-gray-600', 'hover:bg-indigo-100');
                this.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
            }

            seatsInput.value = selectedSeats.join(',');
            
            // Update UI
            const total = selectedSeats.length * pricePerSeat;
            totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
            btnBook.disabled = selectedSeats.length === 0;
        });
    });

    // --- Map Logic ---
    // Jepara default coord
    const defaultLat = -6.581768;
    const defaultLng = 110.668744; 

    var map = L.map('map').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

    function updateMarker(lat, lng) {
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
    }
    
    // Init
    updateMarker(defaultLat, defaultLng);

    marker.on('dragend', function(e) {
        var coord = e.target.getLatLng();
        updateMarker(coord.lat, coord.lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateMarker(e.latlng.lat, e.latlng.lng);
    });
</script>

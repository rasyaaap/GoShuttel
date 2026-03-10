<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 pb-24">
    <!-- Header -->
    <!-- Header -->
    <div class="bg-indigo-600 pb-12 pt-8 px-6 shadow-md rounded-b-[2.5rem] relative">
        <!-- Back Button -->
        <a href="<?= base_url('customer/dashboard') ?>" class="absolute top-8 left-4 sm:left-6 text-white/80 hover:text-white flex items-center transition-colors z-10">
            <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="hidden sm:inline text-sm font-medium">Kembali</span>
        </a>

        <div class="max-w-4xl mx-auto text-center text-white">
            <h1 class="text-3xl font-bold mb-2">Jadwal Operasional</h1>
            <p class="text-indigo-100 opacity-90">Cek rute dan jam keberangkatan armada kami.</p>
            
            <!-- Search Bar -->
            <div class="mt-8 relative max-w-lg mx-auto">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="routeSearch" placeholder="Cari kota asal atau tujuan..." class="block w-full pl-11 pr-4 py-4 bg-white rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 shadow-lg text-sm transition-all">
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 -mt-6">
        <!-- Group Schedules by Route Logic -->
        <?php 
        $grouped_schedules = [];
        foreach($schedules as $s) {
            $route_name = $s->kota_asal . ' - ' . $s->kota_tujuan;
            $grouped_schedules[$route_name]['meta'] = $s; // Store first item for meta
            $grouped_schedules[$route_name]['times'][] = $s;
        }
        ?>

        <?php if(empty($grouped_schedules)): ?>
            <div class="bg-white rounded-xl shadow p-8 text-center text-gray-500 mt-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Belum ada jadwal operasional tersedia saat ini.</p>
            </div>
        <?php else: ?>
            
            <div id="scheduleGrid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach($grouped_schedules as $route => $data): 
                    $meta = $data['meta']; 
                    $times = $data['times'];
                ?>
                <div class="schedule-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                    <!-- Route Header -->
                    <div class="p-5 border-b border-gray-50 relative bg-gradient-to-r from-white to-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <div class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2 py-1 rounded uppercase tracking-wider">
                                <?= $meta->nama_armada ?? 'Shuttle' ?>
                            </div>
                            <span class="font-bold text-green-600">Rp <?= number_format($meta->harga, 0, ',', '.') ?></span>
                        </div>
                        <h3 class="destination-text text-lg font-bold text-gray-900 flex items-center gap-2">
                            <?= $meta->kota_asal ?> 
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                            <?= $meta->kota_tujuan ?>
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Estimasi <?= $meta->estimasi_waktu ?> Jam
                        </p>
                    </div>

                    <!-- Time Grid -->
                    <div class="p-5 bg-white">
                        <p class="text-xs font-semibold text-gray-400 uppercase mb-3 tracking-wider">Waktu Keberangkatan</p>
                        <div class="grid grid-cols-3 gap-3">
                            <?php foreach($times as $time): ?>
                                <a href="<?= base_url('customer/dashboard?asal='.$time->kota_asal.'&tujuan='.$time->kota_tujuan) ?>" 
                                   class="flex flex-col items-center justify-center py-2 px-3 rounded-lg border border-gray-200 bg-gray-50 hover:bg-indigo-600 hover:border-indigo-600 hover:text-white transition-all group-item">
                                    <span class="text-sm font-bold"><?= date('H:i', strtotime($time->jam_berangkat)) ?></span>
                                    <span class="text-[10px] text-gray-500 group-hover:text-indigo-200">WIB</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="px-5 pb-5 pt-3 border-t border-gray-50 bg-gray-50/50 flex justify-between items-center">
                        <button type="button" onclick='showRouteDetail(<?= json_encode($data) ?>)' class="text-sm text-gray-500 hover:text-indigo-600 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Detail & Pesan
                        </button>
                        <button type="button" onclick='showRouteDetail(<?= json_encode($data) ?>)' class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5">
                            Pesan Tiket
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty State for Search -->
            <div id="noResults" class="hidden text-center py-12">
                <div class="inline-block p-4 rounded-full bg-gray-100 mb-3">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <p class="text-gray-500">Rute tidak ditemukan.</p>
            </div>

        <?php endif; ?>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-indigo-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Info & Pemesanan</h3>
                    <button type="button" onclick="closeModal()" class="text-indigo-200 hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Form Wrapper -->
                <form id="directBookingForm" onsubmit="proceedToBooking(event)">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mt-2">
                            <!-- Route Info -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="text-center w-5/12">
                                    <p class="text-sm text-gray-500">Dari</p>
                                    <h4 class="text-xl font-bold text-gray-900" id="modalAsal">Jepara</h4>
                                </div>
                                <div class="w-2/12 flex justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                                <div class="text-center w-5/12">
                                    <p class="text-sm text-gray-500">Ke</p>
                                    <h4 class="text-xl font-bold text-gray-900" id="modalTujuan">Semarang</h4>
                                </div>
                            </div>

                            <!-- Selection Area -->
                            <div class="bg-indigo-50 rounded-xl p-5 mb-6 border border-indigo-100">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Tanggal</label>
                                    <input type="date" id="bookDate" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Jam Keberangkatan</label>
                                    <div id="modalTimeSlots" class="grid grid-cols-3 gap-2">
                                        <!-- JS will populate this -->
                                    </div>
                                    <input type="hidden" id="selectedJadwalId" required>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                            <div class="grid grid-cols-2 gap-4 border-b border-gray-200 pb-2">
                                <div>
                                    <span class="text-xs text-gray-500 block">Armada</span>
                                    <span class="font-semibold text-gray-900 text-sm" id="modalArmada">Hiace Commuter</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">No. Polisi</span>
                                    <span class="font-semibold text-gray-900 text-sm" id="modalPlat">-</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 border-b border-gray-200 pb-2">
                                <div>
                                    <span class="text-xs text-gray-500 block">Driver</span>
                                    <span class="font-semibold text-gray-900 text-sm" id="modalDriver">-</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">Kapasitas</span>
                                    <span class="font-semibold text-gray-900 text-sm" id="modalKapasitas">-</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-1">
                                <span class="text-gray-600">Harga Tiket</span>
                                <span class="font-bold text-green-600 text-lg" id="modalHarga">Rp 85.000</span>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-3 bg-indigo-600 text-base font-bold text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Lanjut Pilih Kursi &rarr;
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ... (Keep existing search logic) ...

        // Modal Logic
        function showRouteDetail(data) {
            const meta = data.meta;
            const times = data.times;

            document.getElementById('modalAsal').innerText = meta.kota_asal;
            document.getElementById('modalTujuan').innerText = meta.kota_tujuan;
            
            // Default Values (Will be updated by AJAX)
            document.getElementById('modalArmada').innerText = meta.nama_armada || 'Shuttle Standard';
            document.getElementById('modalPlat').innerText = '-';
            document.getElementById('modalDriver').innerText = '-';
            document.getElementById('modalKapasitas').innerText = '-';
            
            document.getElementById('modalHarga').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(meta.harga);
            
            // Populate Time Slots
            const timeContainer = document.getElementById('modalTimeSlots');
            timeContainer.innerHTML = '';
            
            times.forEach((t, index) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'time-slot-btn py-2 px-1 text-sm font-medium rounded-lg border border-gray-200 bg-white hover:border-indigo-500 hover:text-indigo-600 focus:outline-none transition-colors w-full';
                
                // Format time H:i
                const timeParts = t.jam_berangkat.split(':');
                const timeStr = timeParts[0] + ':' + timeParts[1];
                
                btn.textContent = timeStr;
                btn.onclick = function() {
                    // UI Selection
                    document.querySelectorAll('.time-slot-btn').forEach(b => {
                        b.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                        b.classList.add('bg-white', 'text-gray-700');
                    });
                    btn.classList.remove('bg-white', 'text-gray-700');
                    btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                    
                    document.getElementById('selectedJadwalId').value = t.id;
                    
                    // Trigger Check
                    checkTripInfo();
                };

                // Auto select first but don't trigger heavy logic immediately unless needed
                // For now, let user interact
                timeContainer.appendChild(btn);
            });

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // AJAX Check Trip Info
        const bookDateInput = document.getElementById('bookDate');
        bookDateInput.addEventListener('change', checkTripInfo);

        async function checkTripInfo() {
            const jadwalId = document.getElementById('selectedJadwalId').value;
            const date = document.getElementById('bookDate').value;

            if(!jadwalId || !date) return;

            // Reset to Loading/Default
            document.getElementById('modalArmada').innerText = 'Memuat...';
            document.getElementById('modalPlat').innerText = '...';
            
            try {
                const response = await fetch(`<?= base_url('booking/check_trip_availability') ?>?jadwal_id=${jadwalId}&tanggal=${date}`);
                const result = await response.json();

                if(result.status && result.exists) {
                    document.getElementById('modalArmada').innerText = result.data.nama_armada || 'Shuttle Standard';
                    document.getElementById('modalPlat').innerText = result.data.no_plat || '-';
                    document.getElementById('modalDriver').innerText = result.data.driver_name || 'Belum Ditentukan';
                    document.getElementById('modalKapasitas').innerText = (result.data.kapasitas || '-') + ' Kursi';
                } else {
                    document.getElementById('modalArmada').innerText = 'Shuttle Standard (Default)';
                    document.getElementById('modalPlat').innerText = '-';
                    document.getElementById('modalDriver').innerText = 'Belum Ditentukan';
                    document.getElementById('modalKapasitas').innerText = '-';
                }
            } catch(e) {
                console.error('Error fetching trip info', e);
            }
        }

        function proceedToBooking(e) {
            e.preventDefault();
            const jadwalId = document.getElementById('selectedJadwalId').value;
            const date = document.getElementById('bookDate').value;
            
            if(!jadwalId) {
                alert('Silakan pilih jam keberangkatan terlebih dahulu.');
                return;
            }
            if(!date) {
                alert('Silakan pilih tanggal keberangkatan.');
                return;
            }

            // Direct Link
            const url = "<?= base_url('booking/select_seat/') ?>" + jadwalId + "?tanggal=" + date;
            window.location.href = url;
        }
    </script>
</main>

<?php $this->load->view('layout/header', ['title' => 'Driver Home']); ?>

<style>
    body { background-color: #F3F4F6; padding-bottom: 80px; } /* Space for bottom nav */
</style>

<!-- Top Header -->
<div class="bg-indigo-600 rounded-b-[30px] pt-8 pb-12 px-6 shadow-lg relative overflow-hidden">
    <div class="absolute top-0 right-0 -mr-10 -mt-10 opacity-20">
        <svg class="h-64 w-64 text-white" fill="currentColor" viewBox="0 0 200 200">
            <path d="M45,-76C58.3,-69.3,69.1,-58.3,77.3,-45.8C85.5,-33.3,91.1,-19.3,89.5,-5.8C87.9,7.7,79.1,20.7,68.9,31.2C58.7,41.7,47.1,49.7,35.1,54.8C23.1,59.9,10.7,62.1,-0.6,63C-11.9,64,-22.7,63.7,-33.4,59.2C-44.1,54.7,-54.7,46,-62.4,35.1C-70.1,24.2,-74.9,11.1,-73.9,-1.5C-72.9,-14.1,-66.1,-26.2,-56.9,-35.8C-47.7,-45.4,-36.1,-52.5,-23.9,-59.9C-11.7,-67.3,1.1,-75,14.5,-77.3" transform="translate(100 100)" />
        </svg>
    </div>
    
    <div class="flex justify-between items-center relative z-10">
        <div>
            <p class="text-indigo-100 text-sm">Selamat Datang,</p>
            <h1 class="text-2xl font-bold text-white"><?= $this->session->userdata('name') ?></h1>
        </div>
        <a href="<?= base_url('driver/notifications') ?>" class="relative p-2 bg-white/10 rounded-full hover:bg-white/20 transition-colors">
            <?php if(isset($unread_count) && $unread_count > 0): ?>
                <span class="absolute top-2 right-2 block h-2.5 w-2.5 rounded-full ring-2 ring-indigo-600 bg-red-400 animate-pulse"></span>
            <?php endif; ?>
            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </a>
    </div>
</div>

<main class="px-6 -mt-8 relative z-10">
    <!-- Tracking Warning (Toast) -->
    <div id="tracking-warning" class="hidden fixed top-24 right-4 left-4 z-50 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow-lg animate-bounce-in">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <span class="font-bold">Live Tracking Non-Aktif</span><br>
                    Fitur lokasi tidak bekerja di koneksi HTTP.
                </p>
            </div>
        </div>
    </div>
    <!-- Active Armada -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4 px-1">
             <h3 class="text-white font-bold text-lg text-shadow-sm">Armada Anda</h3>
             <?php if(empty($armada)): ?>
                 <span class="text-xs bg-red-100 text-red-600 font-bold px-3 py-1 rounded-full shadow-sm">Belum ditugaskan</span>
             <?php endif; ?>
        </div>

        <?php if(!empty($armada)): ?>
        <div class="bg-white rounded-2xl p-5 shadow-xl border border-indigo-50 flex items-center justify-between relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                 <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Kendaraan Aktif</p>
                 <h4 class="text-xl font-bold text-indigo-900"><?= $armada->nama_armada ?></h4>
                 <div class="mt-2 flex items-center">
                    <span class="bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm"><?= $armada->plat_nomor ?></span>
                 </div>
            </div>
            <div class="relative z-10 bg-indigo-50 p-3 rounded-xl border border-indigo-100 group-hover:bg-indigo-100 transition-colors">
                 <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
        </div>
        <?php else: ?>
        <div class="bg-white rounded-2xl p-6 text-center shadow-lg border border-gray-100">
            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <p class="text-gray-500 text-sm">Anda belum memiliki armada yang ditugaskan.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Todays Trips -->
    <div class="mb-6">
        <h3 class="text-gray-800 font-bold text-lg mb-3">Jadwal Hari Ini</h3>
        
        <?php if(empty($trips)): ?>
            <div class="bg-white rounded-2xl p-8 text-center shadow-sm">
                <p class="text-gray-400">Tidak ada jadwal perjalanan.</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach($trips as $t): ?>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-green-500"></div>
                    <div class="flex justify-between items-start mb-4 pl-3">
                        <div>
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-md mb-2 inline-block">BERANGKAT</span>
                            <div class="flex items-center space-x-2 text-gray-800 mt-1">
                                <span class="font-bold text-lg"><?= $t->kota_asal ?></span>
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                <span class="font-bold text-lg"><?= $t->kota_tujuan ?></span>
                            </div>
                        </div>
                        <div class="text-right">
                             <p class="text-2xl font-bold text-gray-800"><?= date('H:i', strtotime($t->jam_berangkat)) ?></p>
                             <p class="text-xs text-gray-400">WIB</p>
                        </div>
                    </div>
                    
                    <a href="<?= base_url('driver/trip_detail/'.$t->id) ?>" class="block text-center bg-gray-50 text-indigo-600 font-bold py-3 rounded-xl hover:bg-indigo-50 transition">
                        Lihat Penumpang
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    </div>
</main>

<script>
    function updateLocation() {
        // Check for Secure Context first
        if (!window.isSecureContext && window.location.hostname !== 'localhost') {
            document.getElementById('tracking-warning').classList.remove('hidden');
            return;
        }

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Send to server
                const formData = new FormData();
                formData.append('lat', lat);
                formData.append('lng', lng);

                fetch('<?= base_url('driver/update_location') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => console.log('Location updated:', data))
                .catch(error => console.error('Error updating location:', error));

            }, function(error) {
                console.error("Error getting location: ", error);
            });
        } else {
            console.log("Geolocation not available");
        }
    }

    // Update every 10 seconds if secure
    if (window.isSecureContext || window.location.hostname === 'localhost') {
        setInterval(updateLocation, 10000);
        updateLocation(); // Run immediately
    } else {
        // Show warning immediately
        document.addEventListener('DOMContentLoaded', function() {
            const warning = document.getElementById('tracking-warning');
            warning.classList.remove('hidden');
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                warning.classList.add('hidden');
            }, 3000);
        });
    }
</script>

<!-- Bottom Nav -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 rounded-t-2xl shadow-[0_-5px_20px_rgba(0,0,0,0.05)]">
    <a href="<?= base_url('driver/dashboard') ?>" class="flex flex-col items-center text-indigo-600">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="text-[10px] font-medium mt-1">Beranda</span>
    </a>

    <!-- Floating Scan Button -->
    <a href="<?= base_url('driver/scanner') ?>" class="-mt-8 bg-indigo-600 p-4 rounded-full text-white shadow-lg border-4 border-gray-100 flex items-center justify-center transform hover:scale-110 transition-transform">
        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    </a>
    
    <a href="<?= base_url('driver/chat') ?>" class="flex flex-col items-center text-gray-400 hover:text-gray-600">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <span class="text-[10px] font-medium mt-1">Chat</span>
    </a>

    <a href="<?= base_url('driver/account') ?>" class="flex flex-col items-center text-gray-400 hover:text-gray-600">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
         <span class="text-[10px] font-medium mt-1">Akun</span>
    </a>
</nav>

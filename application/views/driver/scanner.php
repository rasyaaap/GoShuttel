<div class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Header -->
    <div class="bg-indigo-600 px-6 py-4 rounded-b-[30px] shadow-lg mb-6">
        <div class="flex items-center text-white mb-2">
            <a href="<?= base_url('driver/dashboard') ?>" class="mr-3 p-1 rounded-full hover:bg-white/20 transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-bold">Scan Tiket</h1>
        </div>
        <p class="text-indigo-200 text-sm ml-9">Scan QR Code penumpang atau input kode manual.</p>
    </div>

    <div class="flex-1 px-4 pb-24" x-data="scannerLogic()">
        <!-- Loading Overlay -->
        <div x-show="isProcessing" class="fixed inset-0 z-50 bg-black/60 flex flex-col items-center justify-center text-white backdrop-blur-sm" style="display:none;">
            <svg class="animate-spin h-12 w-12 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="font-bold text-lg">Memproses QR Code...</p>
            <p class="text-sm opacity-80 mt-1">Mohon tunggu sebentar</p>
        </div>
        <!-- Tabs -->
        <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-100 flex mb-6">
            <button @click="switchTab('camera')" :class="activeTab === 'camera' ? 'bg-indigo-600 text-white shadow' : 'text-gray-500 hover:bg-gray-50'" class="flex-1 py-2 rounded-lg text-sm font-bold transition-all flex justify-center items-center">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Kamera
            </button>
            <button @click="switchTab('manual')" :class="activeTab === 'manual' ? 'bg-indigo-600 text-white shadow' : 'text-gray-500 hover:bg-gray-50'" class="flex-1 py-2 rounded-lg text-sm font-bold transition-all flex justify-center items-center">
                 <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Input Manual
            </button>
        </div>

        <!-- Camera Section -->
        <div x-show="activeTab === 'camera'" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden relative">
             <!-- Error Message Overlay (Only for unexpected errors on Secure context) -->
             <div x-show="errorMessage && isSecure" class="absolute inset-0 bg-white z-20 flex flex-col items-center justify-center p-6 text-center">
                 <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-3">
                     <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                 </div>
                 <p class="text-gray-800 font-bold mb-1">Kamera Tidak Dapat Diakses</p>
                 <p class="text-sm text-gray-500 mb-4" x-text="errorMessage"></p>
                 <button @click="startScanner()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold">Coba Lagi</button>
             </div>

             <!-- Live Camera (Only if Secure) -->
             <div x-show="isSecure" class="mx-auto max-w-[250px] relative">
                 <div id="reader" class="w-full bg-black rounded-lg overflow-hidden aspect-square relative" :class="{'is-mirrored': isMirrored}"></div>
                 
                 <button @click="isMirrored = !isMirrored" class="absolute top-2 right-2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 z-10" title="Balik Kamera (Mirror)">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                 </button>
             </div>
             
             <style>
                #reader video { object-fit: cover; transform: scaleX(1) !important; }
                #reader.is-mirrored video { transform: scaleX(-1) !important; }
             </style>
             
             <!-- HTTP / Fallback UI -->
             <div class="p-4 border-t border-gray-100">
                <div x-show="!isSecure" class="mb-4 text-center bg-yellow-50 p-3 rounded-lg border border-yellow-100">
                    <p class="text-xs text-yellow-700 font-medium">Anda menggunakan akses via IP (HTTP).</p>
                    <p class="text-[10px] text-yellow-600">Browser membatasi Kamera Live. Gunakan tombol di bawah ini:</p>
                </div>
                
                <p x-show="isSecure" class="text-xs text-gray-400 mb-3 text-center">Jika kamera tidak muncul, gunakan tombol dibawah:</p>
                
                <div class="relative">
                    <button class="w-full bg-indigo-50 text-indigo-700 font-bold py-3 rounded-xl border border-indigo-200 hover:bg-indigo-100 transition flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span x-text="isSecure ? 'Ambil Foto / Upload QR' : 'Buka Kamera HP'"></span>
                    </button>
                    <!-- capture="environment" forces rear camera on mobile -->
                    <input type="file" accept="image/*" capture="environment" @change="scanFromFile($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                </div>
             </div>
        </div>

        <!-- Manual Input Section -->
        <div x-show="activeTab === 'manual'">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 text-center">Input Kode Booking</h3>
                <form action="<?= base_url('driver/scan_qr') ?>" method="POST">
                    <input type="text" name="booking_id" placeholder="Contoh: TRx12345" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-4 text-center text-lg font-bold tracking-wider mb-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase">
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                        Validasi Tiket
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js for Tabs -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<!-- HTML5-QRCode Library -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('scannerLogic', () => ({
        activeTab: 'camera',
        html5QrCode: null,
        errorMessage: null,
        isMirrored: false,
        isSecure: true, // Default true
        isProcessing: false,
        
        init() {
            this.$nextTick(() => {
                // Check if secure (HTTPS or Localhost)
                this.isSecure = window.isSecureContext;

                if (!this.isSecure) {
                    return;
                }

                if (typeof Html5Qrcode === 'undefined') {
                    this.errorMessage = "Library Scanner tidak termuat. Periksa koneksi internet.";
                    return;
                }
                this.startScanner();
            });
        },
        
        // ... (existing switchTab) ...

        switchTab(tab) {
            this.activeTab = tab;
            if (tab === 'camera') {
                this.$nextTick(() => {
                    if(this.isSecure) {
                        this.startScanner();
                    }
                });
            } else {
                this.stopScanner();
            }
        },

        startScanner() {
            if(!this.isSecure) return; // Guard
            
            this.errorMessage = null;
            
            // Wait for DOM
            if (!document.getElementById('reader')) {
                 return;
            }

            if (this.html5QrCode === null) {
                try {
                    this.html5QrCode = new Html5Qrcode("reader");
                } catch (e) {
                    this.errorMessage = "Gagal inisialisasi kamera: " + e.message;
                    return;
                }
            }

            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                console.log(`Scan result: ${decodedText}`, decodedResult);
                this.stopScanner().then(() => {
                    this.submitScan(decodedText);
                });
            };

            // Ensure stopped
            this.stopScanner().then(() => {
                this.html5QrCode.start(
                    { facingMode: "environment" }, 
                    { fps: 10, qrbox: 200, aspectRatio: 1.0 }, 
                    qrCodeSuccessCallback
                )
                .catch(err => {
                    console.error("Error starting scanner:", err);
                    
                    // Check for HTTP issue specifically
                    const isSecure = window.isSecureContext;
                    
                    if (typeof err === 'string') {
                         this.errorMessage = err;
                    } else if (err.name === 'NotAllowedError') {
                         this.errorMessage = "Izin kamera ditolak. Mohon izinkan akses kamera di browser Anda.";
                    } else if (err.name === 'NotFoundError') {
                         this.errorMessage = "Kamera tidak ditemukan pada perangkat ini.";
                    } else if (err.name === 'NotReadableError') {
                         this.errorMessage = "Kamera sedang digunakan oleh aplikasi lain.";
                    } else if (!isSecure) {
                         this.errorMessage = "Akses Kamera Langsung (Live) memerlukan HTTPS. Namun Anda tetap bisa menggunakan tombol 'Ambil Foto / Upload QR' di bawah.";
                    } else {
                         this.errorMessage = "Gagal memulai kamera. (" + (err.name || err) + ")";
                    }
                });
            });
        },

        stopScanner() {
            if (this.html5QrCode && this.html5QrCode.isScanning) {
                return this.html5QrCode.stop().catch(err => console.log("Stop failed", err));
            }
            return Promise.resolve();
        },

        submitScan(code) {
             this.isProcessing = true; // Ensure loading header stays
             const form = document.createElement('form');
             form.method = 'POST';
             form.action = '<?= base_url('driver/scan_qr') ?>';
             
             const hiddenField = document.createElement('input');
             hiddenField.type = 'hidden';
             hiddenField.name = 'booking_id';
             hiddenField.value = code;
             
             form.appendChild(hiddenField);
             document.body.appendChild(form);
             form.submit();
        },

        scanFromFile(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            // Show loading UI
            this.isProcessing = true;

            // Short delay to allow UI to render before heavy processing
            setTimeout(() => {
                // Lazy init if not exists (e.g. because of insecure context)
                if (this.html5QrCode === null) {
                    try {
                        this.html5QrCode = new Html5Qrcode("reader");
                    } catch (e) {
                         this.isProcessing = false;
                         alert("Gagal inisialisasi scanner: " + e.message);
                         return;
                    }
                }

                this.html5QrCode.scanFile(file, true)
                    .then(decodedText => {
                        console.log("File Scan result:", decodedText);
                        this.submitScan(decodedText);
                    })
                    .catch(err => {
                        this.isProcessing = false;
                        alert("Gagal memindai QR code. Pastikan gambar jelas/memuat QR, atau coba ambil foto ulang dengan pencahayaan cukup.");
                        console.error("File Scan error:", err);
                        
                        // Clear input so user can select same file again if needed
                        event.target.value = ''; 
                    });
            }, 100);
        }
    }));
});
</script>

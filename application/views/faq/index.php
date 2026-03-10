<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Raaster Shuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <?php $this->load->view('layout/header', ['title' => 'FAQ']); ?>

    <!-- Navigation (Simplified for FAQ page) -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= base_url() ?>" class="text-2xl font-bold text-indigo-700 tracking-tighter">Raaster<span class="text-indigo-400">.</span></a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url() ?>" class="text-gray-600 hover:text-indigo-600 font-medium">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">Pusat Bantuan</h1>
            <p class="text-xl text-gray-500">Pertanyaan yang sering diajukan seputar layanan Raaster Shuttle.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center bg-white hover:bg-gray-50 transition focus:outline-none" onclick="toggleFaq(1)">
                    <span class="font-bold text-lg text-gray-900">Bagaimana cara memesan tiket?</span>
                    <svg id="icon-1" class="w-6 h-6 text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="body-1" class="hidden px-6 pb-4 pt-2 text-gray-600 leading-relaxed border-t border-gray-50">
                    Anda dapat memesan tiket melalui website ini dengan mengklik tombol "Pesan Sekarang" atau melalui menu Rute. Pilih rute, jadwal, dan kursi yang tersedia, lalu lakukan pembayaran.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center bg-white hover:bg-gray-50 transition focus:outline-none" onclick="toggleFaq(2)">
                    <span class="font-bold text-lg text-gray-900">Metode pembayaran apa saja yang tersedia?</span>
                    <svg id="icon-2" class="w-6 h-6 text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="body-2" class="hidden px-6 pb-4 pt-2 text-gray-600 leading-relaxed border-t border-gray-50">
                    Kami menerima pembayaran melalui Transfer Bank (BCA, Mandiri, BRI, BNI) dan E-Wallet (GoPay, OVO, Dana). Konfirmasi otomatis setelah pembayaran berhasil.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center bg-white hover:bg-gray-50 transition focus:outline-none" onclick="toggleFaq(3)">
                    <span class="font-bold text-lg text-gray-900">Apakah bisa membatalkan pesanan?</span>
                    <svg id="icon-3" class="w-6 h-6 text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="body-3" class="hidden px-6 pb-4 pt-2 text-gray-600 leading-relaxed border-t border-gray-50">
                    Pembatalan maksimal dilakukan 24 jam sebelum keberangkatan dengan pengembalian dana 75%. Hubungi CS kami untuk proses pembatalan lebih lanjut.
                </div>
            </div>

             <!-- FAQ Item 4 -->
             <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center bg-white hover:bg-gray-50 transition focus:outline-none" onclick="toggleFaq(4)">
                    <span class="font-bold text-lg text-gray-900">Fasilitas apa saja yang didapatkan?</span>
                    <svg id="icon-4" class="w-6 h-6 text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="body-4" class="hidden px-6 pb-4 pt-2 text-gray-600 leading-relaxed border-t border-gray-50">
                    Setiap armada kami dilengkapi dengan AC dingin, kursi reclining yang nyaman, musik, dan air mineral gratis. Kami juga menggunakan armada terbaru seperti Hiace Premio.
                </div>
            </div>
        </div>
        
        <div class="mt-16 text-center">
             <p class="text-gray-500">Masih punya pertanyaan?</p>
             <a href="https://wa.me/6281234567890" class="inline-flex items-center mt-4 text-indigo-600 font-bold hover:underline">
                 <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                 Chat WhatsApp
             </a>
        </div>
    </div>

    <script>
        function toggleFaq(id) {
            const body = document.getElementById(`body-${id}`);
            const icon = document.getElementById(`icon-${id}`);
            
            if (body.classList.contains('hidden')) {
                body.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                body.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</body>
</html>

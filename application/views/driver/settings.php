<?php $this->load->view('layout/header', ['title' => 'Pengaturan']); ?>

<div class="bg-gray-100 min-h-screen pb-20">
    <div class="bg-white px-4 py-4 shadow-sm flex items-center sticky top-0 z-50">
        <a href="<?= base_url('driver/account') ?>" class="mr-4 text-gray-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-lg font-bold text-gray-800">Pengaturan</h1>
    </div>

    <div class="p-6 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Notifikasi</h3>
            <div class="flex items-center justify-between py-2">
                <span class="text-gray-700">Notifikasi Pesanan Baru</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                </label>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-gray-700">Notifikasi Chat</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                </label>
            </div>
        </div>
        
        <div class="text-center text-xs text-gray-400 mt-8">
            <p>Versi Aplikasi 1.0.0</p>
            <p>Raaster Shuttel &copy; 2025</p>
        </div>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>

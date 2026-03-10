<?php $this->load->view('layout/header', ['title' => 'Akun Saya']); ?>

<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
             <div class="flex items-center">
                <a href="<?= base_url('driver/dashboard') ?>" class="mr-4 text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-800">Akun Saya</h1>
            </div>
        </div>
    </div>

    <main class="max-w-lg mx-auto px-4 mt-8">
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 text-center">
            <div class="relative inline-block mb-4">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($this->session->userdata('name')) ?>&background=random&size=128&bold=true" alt="Profile" class="h-24 w-24 rounded-full border-4 border-white shadow-lg mx-auto">
                <div class="absolute bottom-0 right-0 h-6 w-6 bg-green-500 rounded-full border-2 border-white" title="Active"></div>
            </div>
            
            <h2 class="text-xl font-bold text-gray-800"><?= $this->session->userdata('name') ?></h2>
            <p class="text-gray-500 text-sm"><?= $this->session->userdata('email') ?></p>
            
            <div class="flex justify-center gap-2 mt-3">
                 <span class="bg-indigo-50 text-indigo-600 text-xs font-semibold px-3 py-1 rounded-full border border-indigo-100">
                    Driver Partner
                </span>
                 <span class="bg-yellow-50 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full border border-yellow-100 flex items-center gap-1">
                    <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    4.9
                </span>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center">
                 <div class="w-8 h-8 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 mb-2 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                 </div>
                 <h3 class="text-xl font-bold text-gray-800"><?= $stats['total_trips'] ?></h3>
                 <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wide">Total Trip</p>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center">
                 <div class="w-8 h-8 bg-green-50 rounded-full flex items-center justify-center text-green-600 mb-2 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                 </div>
                 <h3 class="text-xl font-bold text-gray-800"><?= $stats['weekly_trips'] ?></h3>
                 <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wide">Minggu Ini</p>
            </div>
        </div>

        <!-- Menu Actions List -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6 divide-y divide-gray-50">
            <a href="<?= base_url('driver/edit_profile') ?>" class="p-4 flex items-center hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-4 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-800">Edit Profil</h4>
                    <p class="text-xs text-gray-500">Ubah nama, email, dan foto</p>
                </div>
                <svg class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <a href="<?= base_url('driver/salary_history') ?>" class="p-4 flex items-center hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center mr-4 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-800">Riwayat Gaji</h4>
                    <p class="text-xs text-gray-500">Cek slip gaji dan insentif</p>
                </div>
                <svg class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <a href="<?= base_url('driver/settings') ?>" class="p-4 flex items-center hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center mr-4 text-purple-600">
                     <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-800">Pengaturan</h4>
                    <p class="text-xs text-gray-500">Aplikasi dan notifikasi</p>
                </div>
                <svg class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        
        <div class="space-y-3">
             <a href="<?= base_url('auth/logout') ?>" class="block w-full text-center py-4 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-100 transition-colors">
                Keluar Aplikasi
            </a>
        </div>

        <div class="text-center mt-8 text-gray-400 text-xs">
            Raaster Shuttle App v1.0 <br>
            &copy; 2025
        </div>
    </main>

    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 rounded-t-2xl shadow-[0_-5px_20px_rgba(0,0,0,0.05)]">
        <a href="<?= base_url('driver/dashboard') ?>" class="group flex flex-col items-center text-gray-400 hover:text-indigo-600 transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] font-medium mt-1">Beranda</span>
        </a>
        
        <a href="<?= base_url('chat') ?>" class="group flex flex-col items-center text-gray-400 hover:text-indigo-600 transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span class="text-[10px] font-medium mt-1">Chat</span>
        </a>
        
        <a href="<?= base_url('driver/account') ?>" class="flex flex-col items-center text-indigo-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
             <span class="text-[10px] font-medium mt-1">Akun</span>
        </a>
    </nav>
</div>

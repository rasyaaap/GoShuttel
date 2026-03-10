<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
             <div class="flex items-center">
                <a href="<?= base_url('customer/dashboard') ?>" class="mr-4 text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-800">Profil Saya</h1>
            </div>
        </div>
    </div>

    <div class="max-w-lg mx-auto px-4 mt-8">
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 text-center">
            <div class="relative inline-block mb-4">
                <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl font-bold mx-auto border-4 border-white shadow-lg">
                    <?= substr($user->name, 0, 1) ?>
                </div>
                <div class="absolute bottom-0 right-0 h-6 w-6 bg-green-500 rounded-full border-2 border-white"></div>
            </div>
            <h2 class="text-xl font-bold text-gray-800"><?= $user->name ?></h2>
            <p class="text-gray-500 text-sm"><?= $user->email ?></p>
            <p class="text-indigo-600 font-medium text-xs mt-1 bg-indigo-50 inline-block px-3 py-1 rounded-full">Customer Premium</p>
        </div>

        <!-- Info List -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-100 flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mr-4">
                     <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold">Nomor Telepon</p>
                    <p class="text-gray-800 font-medium"><?= $user->phone ?? '-' ?></p>
                </div>
            </div>
             <div class="p-4 flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mr-4">
                     <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold">Bergabung Sejak</p>
                    <p class="text-gray-800 font-medium"><?= date('d M Y', strtotime($user->created_at)) ?></p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
            <a href="<?= base_url('auth/logout') ?>" class="block w-full text-center py-4 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-100 transition-colors">
                Keluar Aplikasi
            </a>
        </div>
        
        <div class="text-center mt-8 text-gray-400 text-xs">
            Raaster Shuttle App v1.0 <br>
            &copy; 2025
        </div>
    </div>
</div>

<!-- Bottom Navigation (Mobile) -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 rounded-t-2xl shadow-[0_-5px_20px_rgba(0,0,0,0.05)] md:hidden">
    <a href="<?= base_url('customer/dashboard') ?>" class="flex flex-col items-center text-gray-400 hover:text-gray-600">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="text-[10px] font-medium mt-1">Home</span>
    </a>
    <a href="<?= base_url('booking') ?>" class="flex flex-col items-center text-gray-400 hover:text-gray-600">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
        </svg>
        <span class="text-[10px] font-medium mt-1">Tiket</span>
    </a>
    <a href="<?= base_url('chat') ?>" class="flex flex-col items-center text-gray-400 hover:text-gray-600">
         <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <span class="text-[10px] font-medium mt-1">Chat</span>
    </a>
    <a href="<?= base_url('customer/profile') ?>" class="flex flex-col items-center text-indigo-600">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span class="text-[10px] font-medium mt-1">Akun</span>
    </a>
</nav>

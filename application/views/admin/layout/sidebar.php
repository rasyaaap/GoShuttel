<div class="flex h-screen bg-gray-50 font-sans">
    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 z-20 bg-black bg-opacity-50 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 border-b border-gray-100">
            <h1 class="text-2xl font-bold text-indigo-600 tracking-tighter">Raaster<span class="text-gray-800">Travel</span></h1>
        </div>

        <!-- Nav Links -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main</p>
            
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'dashboard' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'dashboard' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>

            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Operasional</p>

            <a href="<?= base_url('admin/perjalanan') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'perjalanan' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                 <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'perjalanan' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Jadwal Perjalanan
            </a>

            <a href="<?= base_url('admin/rute') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'rute' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'rute' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.806-.98l-3.647-3.646-.1-.1a1 1 0 00-.7-.294A1 1 0 0015 2.764L9 5.236" />
                </svg>
                Rute Master
            </a>

            <a href="<?= base_url('admin/jadwal') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'jadwal' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'jadwal' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Jadwal Master
            </a>

            <a href="<?= base_url('admin/armada') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'armada' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'armada' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Armada & Kursi
            </a>

            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">User & Fitur</p>

            <a href="<?= base_url('admin/drivers') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'drivers' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'drivers' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Daftar Driver
            </a>

            <a href="<?= base_url('admin/info') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'info' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'info' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Info Terkini
            </a>

            <a href="<?= base_url('admin/users') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'users' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'users' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Data Pengguna
            </a>

            <a href="<?= base_url('admin/bookings') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'bookings' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'bookings' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Pemesanan Tiket
            </a>

            <a href="<?= base_url('admin/tracking') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'tracking' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                 <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'tracking' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Live Tracking
            </a>

            <a href="<?= base_url('admin/chat') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'chat' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                 <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'chat' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Chat
            </a>

            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Keuangan</p>

            <a href="<?= base_url('admin/payments') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'payments' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                 <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'payments' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pembayaran Driver
            </a>

            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Relasi</p>

            <a href="<?= base_url('admin/gallery') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'gallery' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                 <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'gallery' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Galeri Foto
            </a>

            <a href="<?= base_url('admin/news') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'news' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                 <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'news' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Berita Terkini
            </a>

            <a href="<?= base_url('admin/complaints') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'complaints' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                 <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'complaints' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Keluhan Pelanggan
            </a>

            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>

            <a href="<?= base_url('admin/landing_settings') ?>" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg <?= $this->uri->segment(2) == 'landing_settings' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                 <svg class="h-5 w-5 mr-3 <?= $this->uri->segment(2) == 'landing_settings' ? 'text-indigo-600' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Landing Page
            </a>
        </nav>

        <!-- User Profile & Logout -->
        <div class="border-t border-gray-200 p-4">
            <div class="flex items-center">
                <img class="h-9 w-9 rounded-full object-cover border border-gray-200" src="https://ui-avatars.com/api/?name=Admin&background=E0E7FF&color=4F46E5" alt="Avatar">
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">Admin</p>
                    <a href="<?= base_url('auth/logout') ?>" class="text-xs text-red-500 hover:text-red-700 font-medium">Logout</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-h-screen lg:ml-64 transition-all duration-300">
        <!-- Topbar Mobile -->
        <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200 lg:hidden">
            <button onclick="toggleSidebar()" class="text-gray-500 focus:outline-none">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <span class="font-bold text-gray-800 text-lg">Raaster.</span>
            <div class="w-6"></div> <!-- Spacer -->
        </header>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    }
</script>

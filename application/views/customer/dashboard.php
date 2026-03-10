<div class="min-h-screen bg-gray-50 pb-24">
    <!-- Top Header -->
    <div class="bg-indigo-600 pb-24 rounded-b-[40px] px-6 pt-8 relative overflow-hidden">
        <!-- Decorative Circles -->
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>

        <div class="flex justify-between items-center relative z-10">
            <div class="flex items-center space-x-3">
                <div class="h-12 w-12 rounded-full bg-white/20 backdrop-blur flex items-center justify-center border-2 border-white/30">
                    <span class="text-white font-bold text-xl"><?= substr($this->session->userdata('name'), 0, 1) ?></span>
                </div>
                <div>
                    <p class="text-indigo-100 text-sm">Selamat Datang,</p>
                    <h2 class="text-white font-bold text-xl truncate max-w-[150px]"><?= $this->session->userdata('name') ?></h2>
                </div>
            </div>
            <div class="flex space-x-2">
                 <!-- Notification (Bell) -->
                <a href="<?= base_url('customer/notifications') ?>" class="relative p-2 bg-white/10 rounded-full hover:bg-white/20 transition-colors group">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <?php if(isset($unread_count) && $unread_count > 0): ?>
                        <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-400 border-2 border-indigo-600 animate-pulse"></span>
                    <?php endif; ?>
                </a>
                <!-- Chat -->
                <a href="<?= base_url('chat') ?>" class="relative p-2 bg-white/10 rounded-full hover:bg-white/20 transition-colors">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Search / Booking Card Overlay -->
        <div class="mt-8 relative z-10">
            <h1 class="text-white text-3xl font-bold leading-tight">Mau pergi ke mana<br>hari ini?</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-6 -mt-16 relative z-20">
        <!-- Quick Booking Card -->
        <div class="bg-white rounded-3xl shadow-xl p-6 mb-8 transform transition hover:scale-[1.02] duration-300">
            <form action="<?= base_url('booking/search') ?>" method="GET">
                <div class="border-b border-gray-100 pb-4 mb-4 flex items-center">
                    <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center mr-3">
                        <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block">Dari</label>
                        <select name="origin" class="w-full font-bold text-gray-800 bg-transparent outline-none appearance-none cursor-pointer">
                            <?php foreach($origins as $city): ?>
                                <option value="<?= $city ?>"><?= $city ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="border-b border-gray-100 pb-4 mb-6 flex items-center">
                    <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center mr-3">
                        <svg class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block">Tujuan</label>
                        <select name="destination" class="w-full font-bold text-gray-800 bg-transparent outline-none appearance-none cursor-pointer">
                            <?php foreach($destinations as $city): ?>
                                <option value="<?= $city ?>"><?= $city ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all active:scale-95 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari Jadwal Perjalanan
                </button>
                <div class="mt-4 text-center">
                    <a href="<?= base_url('customer/schedules') ?>" class="text-sm text-indigo-600 font-medium hover:text-indigo-800 hover:underline">
                        Lihat Semua Jadwal & Rute Tersedia &rarr;
                    </a>
                </div>
            </form>
        </div>

        <!-- Info & Promo Slider -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 px-1">Info Terkini</h3>
            <div class="flex overflow-x-auto space-x-4 pb-4 -mx-6 px-6 snap-x no-scrollbar md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-6 md:space-x-0 md:mx-0 md:px-0 md:overflow-visible">
                
                <?php if(empty($info_terkini)): ?>
                    <div class="text-gray-400 text-sm px-1">Belum ada info terkini.</div>
                <?php else: ?>
                    <?php foreach($info_terkini as $info): ?>
                        <div class="flex-none w-[85vw] sm:w-80 md:w-auto snap-center">
                            <?php 
                                // Determine Styles
                                // Determine Styles
                                // Default (Info) - From plain white to subtle gradient
                                $cardClass = 'bg-gradient-to-br from-white to-slate-100 border border-slate-200 shadow-sm'; 
                                $textClass = 'text-slate-800';
                                $subtextClass = 'text-slate-500';
                                $iconClass = 'text-slate-400';
                                $circleClass = 'bg-slate-200 opacity-50'; // Decorative circle color for default

                                if($info->info_type == 'rute') {
                                    $cardClass = 'bg-gradient-to-br from-indigo-600 to-blue-700 text-white shadow-lg';
                                    $textClass = 'text-white';
                                    $subtextClass = 'text-indigo-100';
                                    $iconClass = 'text-indigo-200';
                                    $circleClass = 'bg-white opacity-10';
                                } elseif ($info->info_type == 'promo') {
                                    $cardClass = 'bg-gradient-to-br from-rose-500 to-pink-600 text-white shadow-lg';
                                    $textClass = 'text-white';
                                    $subtextClass = 'text-rose-100';
                                    $iconClass = 'text-rose-200';
                                    $circleClass = 'bg-white opacity-10';
                                } elseif ($info->info_type == 'news') {
                                    $cardClass = 'bg-gradient-to-br from-violet-600 to-purple-700 text-white shadow-lg';
                                    $textClass = 'text-white';
                                    $subtextClass = 'text-purple-100';
                                    $iconClass = 'text-purple-200';
                                    $circleClass = 'bg-white opacity-10';
                                } elseif ($info->info_type == 'warning') {
                                    $cardClass = 'bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-lg';
                                    $textClass = 'text-white';
                                    $subtextClass = 'text-orange-100';
                                    $iconClass = 'text-orange-200';
                                    $circleClass = 'bg-white opacity-10';
                                } elseif ($info->info_type == 'success') {
                                    $cardClass = 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg';
                                    $textClass = 'text-white';
                                    $subtextClass = 'text-emerald-100';
                                    $iconClass = 'text-emerald-200';
                                    $circleClass = 'bg-white opacity-10';
                                } elseif ($info->info_type == 'dark') {
                                    $cardClass = 'bg-gray-900 border border-gray-800 text-white shadow-lg';
                                    $textClass = 'text-white';
                                    $subtextClass = 'text-gray-400';
                                    $iconClass = 'text-gray-600';
                                    $circleClass = 'bg-gray-700 opacity-20';
                                }
                            ?>
                            
                            <?php
                                // Link Logic
                                $href = '#';
                                if(!empty($info->link_url)) {
                                    // Use external/custom link if provided
                                    $href = (strpos($info->link_url, 'http') === 0) ? $info->link_url : base_url($info->link_url);
                                } else {
                                    // Use internal detail view for Promo, News, Warning, Info, etc.
                                    $href = base_url('customer/read_info/' . $info->id);
                                }
                            ?>
                            
                            <a href="<?= $href ?>" class="block rounded-2xl p-5 relative overflow-hidden transition-transform hover:-translate-y-1 h-full flex flex-col justify-between group <?= $cardClass ?>">
                                
                                <!-- Decorative Circle -->
                                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-32 h-32 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500 <?= $circleClass ?>"></div>

                                <div class="relative z-10">
                                    <?php if($info->tag_text): ?>
                                        <span class="bg-white/20 backdrop-blur px-2 py-1 rounded text-[10px] font-bold uppercase mb-3 inline-block shadow-sm"><?= $info->tag_text ?></span>
                                    <?php endif; ?>
                                    
                                    <h4 class="text-xl font-bold mb-1 <?= $textClass ?>"><?= $info->title ?></h4>
                                    <p class="text-xs mb-4 line-clamp-2 <?= $subtextClass ?>"><?= $info->content ?></p>
                                </div>

                                <div class="relative z-10 flex items-center justify-between mt-auto">
                                    <span class="text-[10px] font-bold uppercase tracking-wider opacity-80">Lihat Detail</span>
                                    <svg class="w-4 h-4 <?= $iconClass ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>

        <!-- Section Title -->
        <div class="flex justify-between items-end mb-4">
            <h3 class="text-xl font-bold text-gray-800">Tiket Saya</h3>
            <a href="<?= base_url('customer/history') ?>" class="text-sm text-indigo-600 font-medium hover:underline">Riwayat</a>
        </div>

        <!-- Bookings List -->
        <?php if(empty($bookings)): ?>
            <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <h4 class="font-bold text-gray-800 mb-1">Belum ada tiket aktif</h4>
                <p class="text-gray-500 text-sm">Yuk pesan kursi favoritmu sekarang!</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach($bookings as $b): ?>
                    <!-- Clickable Card Wrapper -->
                    <a href="<?= base_url('booking/payment/'.$b->id) ?>" class="block bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                        <!-- Left Border Status Color -->
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 <?= $b->status_pembayaran == 'lunas' ? 'bg-green-500' : 'bg-yellow-500' ?>"></div>
                        
                        <div class="flex justify-between items-start mb-4 pl-3">
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1"><?= date('d M Y', strtotime($b->tanggal)) ?></p>
                                <h4 class="font-bold text-lg text-gray-800"><?= date('H:i', strtotime($b->jam_berangkat)) ?> WIB</h4>
                            </div>
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase <?= ($b->is_picked_up ?? false) ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : ($b->status_pembayaran == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700') ?>">
                                <?= ($b->is_picked_up ?? false) ? 'Dijemput' : $b->status_pembayaran ?>
                            </span>
                        </div>

                        <div class="flex items-center space-x-3 mb-4 pl-3 relative">
                            <!-- Dashed Line -->
                            <div class="absolute left-[3px] top-2 bottom-2 w-0.5 border-l border-dashed border-gray-300"></div>
                            
                            <!-- Origin -->
                            <div class="relative z-10 flex items-center">
                                <div class="w-2 h-2 rounded-full bg-white border-2 border-indigo-600 mr-3"></div>
                                <span class="text-sm font-medium text-gray-600"><?= $b->kota_asal ?></span>
                            </div>
                            
                            <!-- Destination -->
                            <div class="relative z-10 flex items-center mt-2"> <!-- Margin hack for alignment -->
                                <!-- We need separate divs for vertical alignment -->
                            </div>
                        </div>
                        <div class="flex items-center pl-3 mb-4">
                             <div class="w-2 h-2 rounded-full bg-indigo-600 mr-3"></div>
                             <span class="text-sm font-bold text-gray-800"><?= $b->kota_tujuan ?></span>
                        </div>

                        <div class="pl-3 pt-3 border-t border-gray-50 flex justify-between items-center">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase">Armada</p>
                                <p class="text-xs font-bold text-gray-700"><?= $b->nama_armada ?? '-' ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 uppercase">Kursi</p>
                                <p class="text-xs font-bold text-gray-700"><?= $b->nomor_kursi ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 rounded-t-2xl shadow-[0_-5px_20px_rgba(0,0,0,0.05)] md:hidden">
    <a href="<?= base_url('customer/dashboard') ?>" class="flex flex-col items-center text-indigo-600">
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
    <a href="<?= base_url('customer/profile') ?>" class="flex flex-col items-center text-gray-400 hover:text-gray-600">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span class="text-[10px] font-medium mt-1">Akun</span>
    </a>
</nav>

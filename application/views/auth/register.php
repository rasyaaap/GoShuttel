<?php $this->load->view('layout/header', ['title' => 'Register']); ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
        <div>
           <div class="flex justify-center mb-6">
                 <a href="<?= base_url() ?>" class="flex items-center gap-2 group">
                    <span class="text-3xl font-bold text-gray-900 tracking-tighter">Raaster<span class="text-indigo-600">Travel</span></span>
                </a>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 tracking-tight">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Mulai perjalanan anda bersama Raaster
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="<?= base_url('auth/register') ?>" method="POST">
             <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1"> Nama Lengkap </label>
                    <input id="name" name="name" type="text" required class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all" placeholder="John Doe">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1"> Nomor WhatsApp </label>
                    <input id="phone" name="phone" type="text" required class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all" placeholder="08123456789">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1"> Email address </label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all" placeholder="nama@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1"> Password </label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all" placeholder="Minimal 6 karakter">
                     <p class="text-xs text-gray-500 mt-1">Gunakan kombinasi huruf dan angka.</p>
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    Saya setuju dengan <a href="#" class="text-indigo-600 hover:text-indigo-500">Syarat & Ketentuan</a>
                </label>
            </div>

            <div>
                 <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-200 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:scale-[1.02]">
                    Buat Akun
                </button>
            </div>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Sudah punya akun? <a href="<?= base_url('auth/login') ?>" class="font-medium text-indigo-600 hover:text-indigo-500 transition">Masuk di sini</a>.
        </p>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>

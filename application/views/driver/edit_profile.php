<?php $this->load->view('layout/header', ['title' => 'Edit Profil']); ?>

<div class="bg-gray-100 min-h-screen pb-20">
    <div class="bg-white px-4 py-4 shadow-sm flex items-center sticky top-0 z-50">
        <a href="<?= base_url('driver/account') ?>" class="mr-4 text-gray-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-lg font-bold text-gray-800">Edit Profil</h1>
    </div>

    <div class="p-6">
        <form action="<?= base_url('driver/edit_profile') ?>" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="<?= $this->session->userdata('name') ?>" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email (Tidak dapat diubah)</label>
                <input type="email" value="<?= $this->session->userdata('email') ?>" disabled class="block w-full rounded-xl border-gray-300 bg-gray-100 shadow-sm text-gray-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                <input type="text" name="phone" value="<?= $this->session->userdata('phone') ?? '08123456789' // Fetch real phone if available from session or DB ?>" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="pt-4 border-t border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Password (Opsional)</label>
                <input type="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengganti" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition transform active:scale-95">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>

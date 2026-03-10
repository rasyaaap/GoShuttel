<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
        
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'customer') {
            redirect('auth/login');
        }
    }

    public function dashboard() {
        $user_id = $this->session->userdata('user_id');
        $data['bookings'] = $this->Booking_model->get_upcoming_bookings($user_id);
        
        // Dynamic search options
        $data['origins'] = $this->Booking_model->get_unique_origins();
        $data['destinations'] = $this->Booking_model->get_unique_destinations();

        // Notifications Check
        $this->load->model('Operational_model');
        $data['unread_count'] = $this->Operational_model->count_unread_inbox($user_id);
        
        // Info Terkini
        $this->load->model('Info_model');
        $data['info_terkini'] = $this->Info_model->get_all();

        $this->load->view('layout/header', ['title' => 'Dashboard Customer']);
        $this->load->view('customer/dashboard', $data);
        $this->load->view('layout/footer');
    }

    public function history() {
        $user_id = $this->session->userdata('user_id');
        $data['bookings'] = $this->Booking_model->get_history_bookings($user_id);
        
        $this->load->view('layout/header', ['title' => 'Riwayat Perjalanan']);
        $this->load->view('customer/history', $data);
        $this->load->view('layout/footer');
    }

    public function schedules() {
        $data['schedules'] = $this->Booking_model->get_all_schedules();
        
        $this->load->view('layout/header', ['title' => 'Semua Jadwal']);
        $this->load->view('customer/schedules', $data);
        $this->load->view('layout/footer');
    }

    public function profile() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->db->get_where('users', ['id' => $user_id])->row();
        
        $this->load->view('layout/header', ['title' => 'Profil Saya']);
        $this->load->view('customer/profile', $data);
        $this->load->view('layout/footer');
    }

    public function notifications() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Operational_model'); 
        
        // Fetch ALL messages received by this user (Admin + Drivers)
        $data['notifications'] = $this->Operational_model->get_inbox($user_id);
        
        // Mark ALL as read
        $this->Operational_model->mark_all_read($user_id);
        
        $this->load->view('layout/header', ['title' => 'Notifikasi']);
        $this->load->view('customer/notifications', $data);
        $this->load->view('layout/footer');
    }
    public function info($slug) {
        $data['slug'] = $slug;
        
        switch($slug) {
            case 'promo':
                $data['title'] = 'Promo Spesial';
                $data['content'] = [
                    'image' => 'assets/img/promo-banner.jpg', // Placeholder
                    'subtitle' => 'Diskon 10% Pengguna Baru',
                    'body' => '<p class="mb-4">Dapatkan potongan harga sebesar 10% untuk pemesanan pertama Anda di Raaster Shuttle!</p>
                               <ul class="list-disc ml-5 mb-4 text-gray-700">
                                   <li>Gunakan kode promo: <strong>BARU10</strong></li>
                                   <li>Berlaku untuk semua rute.</li>
                                   <li>Tanpa minimum transaksi.</li>
                                   <li>Hanya berlaku satu kali per akun.</li>
                               </ul>
                               <p>Jangan lewatkan kesempatan ini untuk menikmati perjalanan nyaman dengan harga lebih hemat.</p>'
                ];
                break;
            case 'cara-pesan':
                $data['title'] = 'Cara Pesan Tiket';
                $data['content'] = [
                    'image' => 'assets/img/guide.jpg',
                    'subtitle' => 'Panduan Pemesanan Mudah',
                    'body' => '<ol class="list-decimal ml-5 space-y-3 text-gray-700">
                                   <li><strong>Cari Jadwal:</strong> Pilih kota asal, tujuan, dan tanggal keberangkatan di halaman dashboard.</li>
                                   <li><strong>Pilih Kursi:</strong> Pilih armada dan nomor kursi yang Anda inginkan.</li>
                                   <li><strong>Isi Data:</strong> Lengkapi data diri penumpang atau pilih dari daftar penumpang tersimpan.</li>
                                   <li><strong>Pembayaran:</strong> Lakukan pembayaran melalui transfer bank atau e-wallet dan upload bukti bayar.</li>
                                   <li><strong>Selesai:</strong> E-Tiket akan terbit setelah pembayaran diverifikasi oleh admin.</li>
                               </ol>'
                ];
                break;
            case 'layanan-premium':
                $data['title'] = 'Layanan Premium';
                $data['content'] = [
                    'image' => 'assets/img/premium.jpg',
                    'subtitle' => 'Kenyamanan Ekstra Untuk Anda',
                    'body' => '<p class="mb-4">Armada kami dilengkapi dengan fasilitas terbaik untuk memastikan kenyamanan Anda selama perjalanan.</p>
                               <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                   <div class="bg-gray-50 p-4 rounded-lg">
                                       <h5 class="font-bold text-indigo-600">AC Dingin</h5>
                                       <p class="text-sm">Suhu kabin yang sejuk dan terjaga.</p>
                                   </div>
                                   <div class="bg-gray-50 p-4 rounded-lg">
                                       <h5 class="font-bold text-indigo-600">Reclining Seat</h5>
                                       <p class="text-sm">Kursi ergonomis yang bisa direbahkan.</p>
                                   </div>
                                   <div class="bg-gray-50 p-4 rounded-lg">
                                       <h5 class="font-bold text-indigo-600">USB Charger</h5>
                                       <p class="text-sm">Tetap eksis dengan baterai penuh.</p>
                                   </div>
                                   <div class="bg-gray-50 p-4 rounded-lg">
                                       <h5 class="font-bold text-indigo-600">Full Musik</h5>
                                       <p class="text-sm">Hiburan musik sepanjang perjalanan.</p>
                                   </div>
                               </div>'
                ];
                break;
            default:
                redirect('customer/dashboard');
        }

        $this->load->view('layout/header', ['title' => $data['title']]);
        $this->load->view('customer/info_detail', $data);
        $this->load->view('layout/footer');
    }

    public function notification_detail($id) {
        $user_id = $this->session->userdata('user_id');
        
        // Manual query to get specific notification
        $this->db->select('chat.*, users.name as sender_name, users.role as sender_role');
        $this->db->from('chat');
        $this->db->join('users', 'users.id = chat.sender_id');
        $this->db->where('chat.id', $id);
        $this->db->where('chat.receiver_id', $user_id);
        $notification = $this->db->get()->row();

        if (!$notification) {
            show_404();
        }

        // Mark as read if not already
        if ($notification->is_read == 0) {
            $this->db->where('id', $id);
            $this->db->update('chat', ['is_read' => 1]);
        }

        $this->load->view('layout/header', ['title' => 'Detail Notifikasi']);
        $this->load->view('customer/notification_detail', ['n' => $notification]);
        $this->load->view('layout/footer');
    }
    public function read_info($id) {
        $this->load->model('Info_model');
        $info = $this->Info_model->get_by_id($id);
        
        if(!$info) {
            redirect('customer/dashboard');
        }

        $this->load->view('layout/header', ['title' => $info->title]);
        $this->load->view('customer/read_info', ['info' => $info]);
        $this->load->view('layout/footer');
    }
}

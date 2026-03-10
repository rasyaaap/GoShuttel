<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->model('Operational_model');
        
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_userdata('redirect_back', current_url());
            redirect('auth/login');
        }
    }

    public function index() {
        // Default page (maybe show search form again or redirect)
        // Fix: Provide default keys to avoid undefined array key errors in view
        $data['jadwal'] = [];
        $data['search_meta'] = [
            'asal' => '', 
            'tujuan' => '', 
            'tanggal' => date('Y-m-d')
        ];
        
        $this->load->view('layout/header', ['title' => 'Cari Jadwal']);
        $this->load->view('booking/search_result', $data);
        $this->load->view('layout/footer');
    }

    public function search() {
        // Search & List
        $asal = $this->input->get('kota_asal') ?: $this->input->get('origin');
        $tujuan = $this->input->get('kota_tujuan') ?: $this->input->get('destination');
        $tanggal = $this->input->get('tanggal') ?: ($this->input->get('date') ?: date('Y-m-d'));

        $data['jadwal'] = $this->Booking_model->search_jadwal($asal, $tujuan, $tanggal);
        $data['search_meta'] = ['asal' => $asal, 'tujuan' => $tujuan, 'tanggal' => $tanggal];
        
        $this->load->view('layout/header', ['title' => 'Hasil Pencarian']);
        $this->load->view('booking/search_result', $data);
        $this->load->view('layout/footer');
    }

    public function select_seat($jadwal_id) {
        $tanggal = $this->input->get('tanggal') ?: date('Y-m-d');
        
        $data['jadwal'] = $this->Booking_model->get_jadwal_detail($jadwal_id, $tanggal);
        $data['booked_seats'] = $this->Booking_model->get_booked_seats($jadwal_id, $tanggal);
        $data['tanggal'] = $tanggal;
        
        // Use layout from DB (defaulting to 1-3-4 if null)
        $data['layout'] = $data['jadwal']->layout_kursi ?? '1-3-4'; 

        $this->load->view('layout/header', ['title' => 'Pilih Kursi']);
        $this->load->view('booking/select_seat', $data);
        $this->load->view('layout/footer');
    }

        $this->load->view('layout/footer');
    }

    public function check_trip_availability() {
        $jadwal_id = $this->input->get('jadwal_id');
        $tanggal = $this->input->get('tanggal');

        if(!$jadwal_id || !$tanggal) {
            echo json_encode(['status' => false]);
            return;
        }

        $trip = $this->Booking_model->check_trip($jadwal_id, $tanggal);
        
        if ($trip) {
            echo json_encode([
                'status' => true,
                'exists' => true,
                'data' => [
                    'nama_armada' => $trip->nama_armada,
                    'no_plat' => $trip->no_plat,
                    'driver_name' => $trip->driver_name,
                    'kapasitas' => $trip->kapasitas
                ]
            ]);
        } else {
            echo json_encode([
                'status' => true,
                'exists' => false,
                'message' => 'Detail armada belum ditentukan untuk tanggal ini (Akan dipilih otomatis)'
            ]);
        }
    }

    public function process_booking() {
        $seats_input = $this->input->post('seats'); // Can be string "1A,1B" or array depending on JS
        
        // Handle if string (imploded by JS) or array
        $seats = is_array($seats_input) ? $seats_input : explode(',', $seats_input);
        
        // Filter empty elements if any
        $seats = array_filter($seats);

        if (empty($seats)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu kursi!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $jadwal_id = $this->input->post('jadwal_id');
        $tanggal = $this->input->post('tanggal');
        $harga = $this->input->post('harga');
        
        $data_pemesanan = [
            'customer_id' => $this->session->userdata('user_id'),
            'nama_pemesan' => $this->session->userdata('name'),
            'jadwal_id' => $jadwal_id,
            'tanggal' => $tanggal,
            'total_harga' => $harga * count($seats),
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
            'alamat' => $this->input->post('alamat')
        ];

        // Pass array directly
        $booking_id = $this->Booking_model->create_booking($data_pemesanan, $seats);

        if ($booking_id) {
            redirect('booking/payment/'.$booking_id);
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses pesanan.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function payment($id) {
        // Fetch Booking
        $this->load->model('Booking_model');
        // Need to add get_booking_by_id in model
        $data['booking'] = $this->Booking_model->get_booking_by_id($id);
        
        if (!$data['booking'] || $data['booking']->customer_id != $this->session->userdata('user_id')) {
            show_404();
        }

        $this->load->view('layout/header', ['title' => 'Pembayaran']);
        $this->load->view('booking/payment', $data);
        $this->load->view('layout/footer');
    }

    public function process_payment() {
        $id = $this->input->post('booking_id');
        
        // Configuration for Upload
        $config['upload_path']   = './uploads/bukti_bayar/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti_bayar')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('booking/payment/'.$id);
        } else {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            // Update Database
            $this->db->where('id', $id);
            $this->db->update('pemesanan', [
                'bukti_bayar' => $file_name,
                'status_pembayaran' => 'pending' // Still pending until approved
            ]);
            
            $this->session->set_flashdata('success', 'Bukti pembayaran berhasil dikirim! Mohon tunggu verifikasi admin.');
            redirect('booking/payment/'.$id);
        }
    }

    public function ticket($id) {
        $this->load->model('Booking_model');
        $data['booking'] = $this->Booking_model->get_booking_by_id($id);

        if (!$data['booking'] || $data['booking']->status_pembayaran != 'lunas') {
            redirect('booking/payment/'.$id);
        }

        $this->load->view('layout/header', ['title' => 'E-Ticket']);
        $this->load->view('booking/ticket', $data);
        $this->load->view('layout/footer');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Driver_model');
        
        // Allow admin to peek or strictly driver
        if (!$this->session->userdata('logged_in') || !in_array($this->session->userdata('role'), ['driver', 'admin'])) {
            redirect('auth/login');
        }
    }

    public function dashboard() {
        $user_id = $this->session->userdata('user_id');
        $data['trips'] = $this->Driver_model->get_todays_trips($user_id);
        $data['armada'] = $this->Driver_model->get_assigned_armada($user_id);
        
        // Notifications
        $this->load->model('Operational_model');
        $data['unread_count'] = $this->Operational_model->count_unread_inbox($user_id);
        
        $this->load->view('layout/header', ['title' => 'Driver Dashboard']);
        $this->load->view('driver/dashboard', $data);
        $this->load->view('layout/footer');
    }

    public function trip_detail($id) {
        $data['passengers'] = $this->Driver_model->get_passengers_by_trip($id);
        $data['trip'] = $this->Driver_model->get_trip_detail($id);
        
        $this->load->view('layout/header', ['title' => 'Detail Perjalanan']);
        $this->load->view('driver/trip_detail', $data);
        $this->load->view('layout/footer');
    }

    public function finish_trip($id) {
        // Mark trip as 'selesai'
        $this->db->where('id', $id);
        $this->db->update('perjalanan', [
            'status' => 'selesai', 
            'jam_selesai' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 'Tugas selesai! Perjalanan telah ditandai selesai.');
        redirect('driver/dashboard');
    }

    public function account() {
        $user_id = $this->session->userdata('user_id');
        $data['stats'] = $this->Driver_model->get_driver_stats($user_id);

        $this->load->view('layout/header', ['title' => 'Akun Saya']);
        $this->load->view('driver/account', $data);
        $this->load->view('layout/footer');
    }

    public function notifications() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Operational_model');
        
        $data['notifications'] = $this->Operational_model->get_inbox($user_id);
        $this->Operational_model->mark_all_read($user_id);
        
        $this->load->view('layout/header', ['title' => 'Notifikasi']);
        $this->load->view('driver/notifications', $data);
        $this->load->view('layout/footer');
    }

    public function edit_profile() {
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('phone', 'Nomor HP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', ['title' => 'Edit Profil']);
            $this->load->view('driver/edit_profile');
            $this->load->view('layout/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone')
            ];
            
            // Password update logic
            $password = $this->input->post('password');
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            $this->db->where('id', $this->session->userdata('user_id'));
            $this->db->update('users', $data);
            
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
            redirect('driver/account');
        }
    }

    // --- REAL TIME LOCATION API ---
    public function update_location() {
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $user_id = $this->session->userdata('user_id');

        if ($user_id && $lat && $lng) {
             $data = [
                 'latitude' => $lat,
                 'longitude' => $lng,
                 'last_location_update' => date('Y-m-d H:i:s')
             ];
             // Check if driver detail exists
             $exists = $this->db->get_where('driver_detail', ['user_id' => $user_id])->num_rows() > 0;
             if($exists) {
                 $this->db->where('user_id', $user_id);
                 $this->db->update('driver_detail', $data);
                 echo json_encode(['status' => 'success']);
             } else {
                 echo json_encode(['status' => 'error', 'message' => 'Not a driver']);
             }
        } else {
             echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        }
    }



    public function salary_history() {
        $this->load->model('Financial_model');
        $user_id = $this->session->userdata('user_id');
        
        $data['salary'] = $this->Financial_model->get_driver_payments($user_id);
        
        $this->load->view('layout/header', ['title' => 'Riwayat Gaji']);
        $this->load->view('driver/salary_history', $data);
        $this->load->view('layout/footer');
    }

    public function salary_slip($id) {
        $this->load->model('Financial_model');
        $user_id = $this->session->userdata('user_id');
        
        // Fetch specific payment
        $payment = $this->Financial_model->get_payment_by_id($id);
        
        // Security check: ensure payment belongs to this driver
        if (!$payment || $payment->user_id != $user_id) {
            show_error('Struk tidak ditemukan atau Anda tidak memiliki akses.', 403);
            return;
        }
        
        $data['payment'] = $payment;
        $this->load->view('driver/salary_slip', $data);
    }

    public function settings() {
        $this->load->view('layout/header', ['title' => 'Pengaturan']);
        $this->load->view('driver/settings');
        $this->load->view('layout/footer');
    }

    public function chat() {
        $this->load->model('Chat_model');
        $user_id = $this->session->userdata('user_id');
        
        $data['conversations'] = $this->Chat_model->get_conversations($user_id, 'driver');
        
        $this->load->view('layout/header', ['title' => 'Riwayat Chat']);
        $this->load->view('driver/chat_list', $data);
        $this->load->view('layout/footer');
    }

    public function pickup_passenger($booking_id) {
        $this->_process_pickup($booking_id);
        $this->session->set_flashdata('success', 'Status penumpang berhasil diperbarui!');
        redirect($_SERVER['HTTP_REFERER']);
    }

    private function _process_pickup($booking_id) {
        // 1. Update Booking Status
        $this->db->where('id', $booking_id);
        $this->db->update('pemesanan', ['is_picked_up' => 1]);
        
        // 2. Fetch Info for Notification
        $booking = $this->db->get_where('pemesanan', ['id' => $booking_id])->row();
        
        if ($booking) {
             $driver_name = $this->session->userdata('name');
             
             // 3. Notify Admin (Send Chat)
             $this->load->model('Operational_model');
             $chat_admin = [
                 'sender_id' => $this->session->userdata('user_id'),
                 'receiver_id' => 1, // Admin
                 'message' => "Laporan: Penumpang untuk Booking ID #{$booking_id} SUDAH DIJEMPUT oleh {$driver_name}.",
                 'is_read' => 0
             ];
             $this->Operational_model->insert_chat($chat_admin);

             // 4. Notify Customer (Send Chat)
             $chat_customer = [
                 'sender_id' => $this->session->userdata('user_id'),
                 'receiver_id' => $booking->customer_id, // To Passenger
                 'message' => "Status Penjemputan: Halo, Anda telah berstatus SUDAH DIJEMPUT (DIJEMPUT).\nBooking #{$booking_id}.\nSelamat menikmati perjalanan!",
                 'is_read' => 0
             ];
             $this->Operational_model->insert_chat($chat_customer);
        }
    }

    public function scanner() {
        $this->load->view('layout/header', ['title' => 'Scan Tiket']);
        $this->load->view('driver/scanner');
        $this->load->view('layout/footer');
    }

    public function scan_qr() {
        $booking_id = $this->input->post('booking_id');
        if ($booking_id) {
            $result = $this->Driver_model->validate_ticket($booking_id);
            if ($result['status']) {
                // If valid, also mark as picked up
                $this->_process_pickup($booking_id);
                $this->session->set_flashdata('success', $result['message']);
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
        }
        redirect('driver/scanner'); 
    }
}

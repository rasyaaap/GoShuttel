<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        // $this->load->model('Booking_model'); // Will create later
        
        // Strict Role Check
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    public function dashboard() {
        $this->load->model('Operational_model');
        $this->load->model('Booking_model'); // Load Booking Model
        $this->load->model('Settings_model'); // NEW: Load settings

        // --- AUTO SCHEDULE CHECK ---
        $auto_update = $this->Settings_model->get_setting('schedule_auto_update');
        
        if ($auto_update == '1') {
            $last_update = $this->Settings_model->get_setting('schedule_last_update');
            $should_run = false;
            
            if (!$last_update) {
                $should_run = true;
            } else {
                $time_diff = time() - strtotime($last_update);
                if ($time_diff >= (3 * 3600)) { // 3 Hours
                    $should_run = true;
                }
            }

            if ($should_run) {
                $count = $this->Operational_model->generate_future_trips(7); // Generate for next 7 days
                $this->Settings_model->update_setting('schedule_last_update', date('Y-m-d H:i:s'));
                if($count > 0) {
                     $this->session->set_flashdata('info', "Auto Update: $count perjalanan baru berhasil dijadwalkan.");
                }
            }
        }
        // ---------------------------
        
        $data = [
            'total_bookings' => $this->Operational_model->count_bookings(),
            'active_drivers' => $this->Operational_model->count_drivers(),
            'todays_trips' => $this->Operational_model->count_todays_trips(),
            'revenue' => $this->Operational_model->sum_revenue(),
            'recent_activity' => $this->Booking_model->get_recent_bookings() // Add this
        ];
        
        $this->load->view('layout/header', ['title' => 'Admin Dashboard']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layout/footer');
    }

    public function schedule_settings() {
        $enable = $this->input->post('auto_update') ? '1' : '0';
        $this->load->model('Settings_model');
        $this->Settings_model->update_setting('schedule_auto_update', $enable);
        
        $status = $enable == '1' ? 'diaktifkan' : 'dinonaktifkan';
        $this->session->set_flashdata('success', 'Auto Update Jadwal berhasil ' . $status);
        redirect('admin/jadwal');
    }

    // --- Perjalanan (Trip) Management ---
    public function perjalanan() {
        $this->load->model('Operational_model');
        $data['perjalanan'] = $this->Operational_model->get_all_perjalanan();
        
        $this->load->view('layout/header', ['title' => 'Manajemen Perjalanan']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/perjalanan/index', $data);
        $this->load->view('layout/footer');
    }

    // --- PERJALANAN MANAGEMENT ---
    // (Existing method above)
    
    // START NEW METHODS
    public function perjalanan_edit($id) {
        $this->load->model('Driver_model');
        $this->load->model('Operational_model');
        
        $data['perjalanan'] = $this->Driver_model->get_trip_detail($id);
        
        // Get Drivers and Armada for dropdowns
        $data['drivers'] = $this->db->get_where('users', ['role' => 'driver'])->result();
        $data['armada_list'] = $this->Operational_model->get_all_armada();

        $this->load->view('layout/header', ['title' => 'Edit Perjalanan']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/perjalanan/edit', $data);
        $this->load->view('layout/footer');
    }

    public function perjalanan_update() {
        $id = $this->input->post('id');
        $data = [
            'driver_id' => $this->input->post('driver_id'),
            'armada_id' => $this->input->post('armada_id'),
            'status' => $this->input->post('status')
        ];
        
        $this->db->where('id', $id);
        $this->db->update('perjalanan', $data);
        
        $this->session->set_flashdata('success', 'Perjalanan berhasil diperbarui!');
        redirect('admin/perjalanan');
    }

    public function perjalanan_detail($id) {
        $this->load->model('Driver_model');
        
        $data['perjalanan'] = $this->Driver_model->get_trip_detail($id);
        // Get passengers with seats grouped
        // Custom query to group seats
        $this->db->select('pemesanan.*, users.name as nama_customer, users.phone, pemesanan.is_picked_up');
        $this->db->select('(SELECT GROUP_CONCAT(nomor_kursi SEPARATOR ", ") FROM pemesanan_seat WHERE pemesanan_seat.pemesanan_id = pemesanan.id) as nomor_kursi_list');
        $this->db->from('pemesanan');
        $this->db->join('users', 'users.id = pemesanan.customer_id');
        $this->db->where('pemesanan.perjalanan_id', $id);
        $this->db->where('pemesanan.status_pembayaran', 'lunas'); // Only paid logic
        $data['passengers'] = $this->db->get()->result();

        $this->load->view('layout/header', ['title' => 'Laporan Perjalanan']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/perjalanan/detail', $data);
        $this->load->view('layout/footer');
    }
    
    // --- FINANCE / SALARY ---
    public function payments() {
        $this->load->model('Financial_model');
        $data['drivers'] = $this->Financial_model->get_driver_salary_summary();
        
        $this->load->view('layout/header', ['title' => 'Manajemen Gaji Driver']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/finance/salary_index', $data);
        $this->load->view('layout/footer');
    }

    public function update_salary_rate() {
        $user_id = $this->input->post('user_id');
        $rate = $this->input->post('rate');

        $this->load->model('Financial_model');
        $this->Financial_model->update_driver_rate($user_id, $rate);
        
        $this->session->set_flashdata('success', 'Tarif gaji driver berhasil diperbarui.');
        redirect('admin/payments');
    }

    public function payments_bulk_update() {
        $rate = $this->input->post('global_rate');
        if($rate) {
            // Update all active drivers
            $this->db->query("UPDATE driver_detail SET gaji_per_trip = ?", [$rate]);
            $this->session->set_flashdata('success', 'Tarif semua driver berhasil diupdate menjadi Rp ' . number_format($rate,0,',','.'));
        }
        redirect('admin/payments');
    }

    public function payment_history() {
        $this->load->model('Financial_model');
        $data['payments'] = $this->Financial_model->get_all_payments();
        
        $this->load->view('layout/header', ['title' => 'Riwayat Pembayaran Driver']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/finance/payment_history', $data);
        $this->load->view('layout/footer');
    }
    // END NEW METHODS

    public function perjalanan_add() {
        $this->load->model('Operational_model');
        $this->load->model('User_model'); // For drivers
        
        $this->form_validation->set_rules('jadwal_id', 'Jadwal', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['jadwal_list'] = $this->Operational_model->get_all_jadwal();
            $data['armada_list'] = $this->Operational_model->get_all_armada();
            // Get all drivers
            $data['driver_list'] = $this->db->get_where('users', ['role' => 'driver'])->result();
            
            $this->load->view('layout/header', ['title' => 'Buat Perjalanan Baru']);
            $this->load->view('admin/layout/sidebar');
            $this->load->view('admin/perjalanan/form', $data);
            $this->load->view('layout/footer');
        } else {
            $data = [
                'jadwal_id' => $this->input->post('jadwal_id'),
                'tanggal' => $this->input->post('tanggal'),
                'armada_id' => $this->input->post('armada_id') ?: NULL,
                'driver_id' => $this->input->post('driver_id') ?: NULL,
                'status' => 'dijadwalkan'
            ];
            $this->Operational_model->insert_perjalanan($data);
            $this->session->set_flashdata('success', 'Perjalanan berhasil dijadwalkan!');
            redirect('admin/perjalanan');
        }
    }

    public function perjalanan_delete($id) {
         // Check usage in pemesanan
         $used = $this->db->get_where('pemesanan', ['perjalanan_id' => $id])->num_rows() > 0;
         
         if ($used) {
             $this->session->set_flashdata('error', 'Gagal: Perjalanan ini tidak bisa dihapus karena memiliki data pemesanan (tiket).');
         } else {
             $this->load->model('Operational_model');
             $this->Operational_model->delete_perjalanan($id);
             $this->session->set_flashdata('success', 'Perjalanan dihapus!');
         }
         redirect('admin/perjalanan');
    }

    public function perjalanan_bulk_delete() {
        $ids = $this->input->post('ids');
        if ($ids && is_array($ids)) {
            // Check usage in pemesanan
            $this->db->select('perjalanan_id');
            $this->db->distinct();
            $this->db->where_in('perjalanan_id', $ids);
            $used_trips = $this->db->get('pemesanan')->result_array();
            $used_ids = array_column($used_trips, 'perjalanan_id');
            
            // Filter deletable IDs
            $deletable_ids = array_diff($ids, $used_ids);
            
            $deleted_count = 0;
            if (!empty($deletable_ids)) {
                $this->db->where_in('id', $deletable_ids);
                $this->db->delete('perjalanan');
                $deleted_count = $this->db->affected_rows();
            }
            
            $msg = '';
            if ($deleted_count > 0) {
                $msg .= $deleted_count . ' perjalanan berhasil dihapus. ';
            }
            
            if (count($used_ids) > 0) {
                $msg .= count($used_ids) . ' perjalanan TIDAK DIHAPUS karena memiliki data pemesanan (tiket).';
                $this->session->set_flashdata('error', $msg); // Show error for partial failure so user notices
            } else {
                $this->session->set_flashdata('success', $msg);
            }
            
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data yang dipilih.');
        }
        redirect('admin/perjalanan');
    }

    // --- Rute Management ---
    public function rute() {
      // --- RUTE ---
        $search = $this->input->get('search');
        
        $this->db->select('*');
        if($search) {
             $this->db->group_start();
             $this->db->like('kota_asal', $search);
             $this->db->or_like('kota_tujuan', $search);
             $this->db->group_end();
        }
        $data['rute'] = $this->db->get('rute')->result();
        $data['search'] = $search;

        $this->load->view('layout/header', ['title' => 'Manajemen Rute']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/rute/index', $data);
        $this->load->view('layout/footer');
    }

    public function rute_bulk_delete() {
        $ids = $this->input->post('ids');
        if ($ids && is_array($ids)) {
            $this->db->where_in('id', $ids);
            $this->db->delete('rute');
            $this->session->set_flashdata('success', count($ids) . ' rute berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data yang dipilih.');
        }
        redirect('admin/rute');
    }

    public function rute_add() {
        $this->load->model('Operational_model');
        
        $this->form_validation->set_rules('kota_asal', 'Kota Asal', 'required');
        $this->form_validation->set_rules('kota_tujuan', 'Kota Tujuan', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
             // Show form (reused index usually or separate modal, but for full page:)
            $this->load->view('layout/header', ['title' => 'Tambah Rute']);
            $this->load->view('admin/layout/sidebar');
            $this->load->view('admin/rute/form');
            $this->load->view('layout/footer');
        } else {
            $data = [
                'kota_asal' => $this->input->post('kota_asal'),
                'kota_tujuan' => $this->input->post('kota_tujuan'),
                'harga' => $this->input->post('harga'),
                'estimasi_waktu' => $this->input->post('estimasi_waktu'),
                'jarak_km' => $this->input->post('jarak_km')
            ];
            $this->Operational_model->insert_rute($data);
            $this->session->set_flashdata('success', 'Rute berhasil ditambahkan!');
            redirect('admin/rute');
        }
    }

    // --- Rute Methods ---
    public function rute_edit($id) {
        $this->load->model('Operational_model');
        $data['rute'] = $this->Operational_model->get_rute_by_id($id);
        
        $this->load->view('layout/header', ['title' => 'Edit Rute']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/rute/form', $data);
        $this->load->view('layout/footer');
    }

    public function rute_update() {
        $this->load->model('Operational_model');
        $id = $this->input->post('id');
        $data = [
            'kota_asal' => $this->input->post('kota_asal'),
            'kota_tujuan' => $this->input->post('kota_tujuan'),
            'harga' => $this->input->post('harga'),
            'estimasi_waktu' => $this->input->post('estimasi_waktu'),
            'jarak_km' => $this->input->post('jarak_km')
        ];
        $this->Operational_model->update_rute($id, $data);
        $this->session->set_flashdata('success', 'Rute berhasil diperbarui!');
        redirect('admin/rute');
    }

    public function rute_delete($id) {
        $this->load->model('Operational_model');
        $this->Operational_model->delete_rute($id);
        $this->session->set_flashdata('success', 'Rute dihapus!');
        redirect('admin/rute');
    }

    // --- JADWAL ---
    public function jadwal() {
        $search = $this->input->get('search');
        
        $this->load->model('Operational_model');
        $this->load->model('Settings_model');

        $this->db->select('jadwal.*, rute.kota_asal, rute.kota_tujuan, armada.nama_armada, users.name as nama_driver');
        $this->db->from('jadwal');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = jadwal.armada_id', 'left');
        $this->db->join('users', 'users.id = jadwal.driver_id', 'left');
        
        if($search) {
             $this->db->group_start();
             $this->db->like('rute.kota_asal', $search);
             $this->db->or_like('rute.kota_tujuan', $search);
             $this->db->or_like('jadwal.jam_berangkat', $search);
             $this->db->group_end();
        }
        $data['jadwal'] = $this->db->get()->result();
        $data['search'] = $search;
        $data['auto_update'] = $this->Settings_model->get_setting('schedule_auto_update');

        $this->load->view('layout/header', ['title' => 'Manajemen Jadwal']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/jadwal/index', $data);
        $this->load->view('layout/footer');
    }

    public function jadwal_bulk_delete() {
        $ids = $this->input->post('ids');
        if ($ids && is_array($ids)) {
            $this->db->where_in('id', $ids);
            $this->db->delete('jadwal');
            $this->session->set_flashdata('success', count($ids) . ' jadwal berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data yang dipilih.');
        }
        redirect('admin/jadwal');
    }

    public function jadwal_add() {
        $this->load->model('Operational_model');
        
        $this->form_validation->set_rules('rute_id', 'Rute', 'required');
        $this->form_validation->set_rules('jam_berangkat', 'Jam Berangkat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['rute'] = $this->Operational_model->get_all_rute();
            $data['armada_list'] = $this->Operational_model->get_all_armada();
            $data['driver_list'] = $this->Operational_model->get_all_drivers();
            
            $this->load->view('layout/header', ['title' => 'Tambah Jadwal']);
            $this->load->view('admin/layout/sidebar');
            $this->load->view('admin/jadwal/form', $data);
            $this->load->view('layout/footer');
        } else {
            $data = [
                'rute_id' => $this->input->post('rute_id'),
                'jam_berangkat' => $this->input->post('jam_berangkat'),
                'hari_aktif' => '["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"]', // Default All
                'status' => 'aktif',
                'armada_id' => $this->input->post('armada_id') ?: NULL,
                'driver_id' => $this->input->post('driver_id') ?: NULL
            ];
            $this->Operational_model->insert_jadwal($data);
            $this->session->set_flashdata('success', 'Jadwal berhasil ditambahkan!');
            redirect('admin/jadwal');
        }
    }

    // --- Jadwal Methods ---
    public function jadwal_edit($id) {
        $this->load->model('Operational_model');
        $data['jadwal'] = $this->Operational_model->get_jadwal_by_id($id);
        $data['rute'] = $this->Operational_model->get_all_rute();
        $data['armada_list'] = $this->Operational_model->get_all_armada();
        $data['driver_list'] = $this->Operational_model->get_all_drivers();
        
        $this->load->view('layout/header', ['title' => 'Edit Jadwal']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/jadwal/form', $data);
        $this->load->view('layout/footer');
    }

    public function jadwal_update() {
        $this->load->model('Operational_model');
        
        $id = $this->input->post('id');
        $data = [
            'rute_id' => $this->input->post('rute_id'),
            'jam_berangkat' => $this->input->post('jam_berangkat'),
            'status' => $this->input->post('status'),
            'armada_id' => $this->input->post('armada_id') ?: NULL,
            'driver_id' => $this->input->post('driver_id') ?: NULL
        ];
        
        $this->Operational_model->update_jadwal($id, $data);
        $this->session->set_flashdata('success', 'Jadwal berhasil diperbarui!');
        redirect('admin/jadwal');
    }

    public function news_save() {
        $this->load->model('News_model');
        
        // DEBUG: Log POST data
        log_message('error', 'NEWS SAVE POST: ' . print_r($_POST, true)); // Keep existing
        file_put_contents(FCPATH . 'debug_news_post.txt', print_r($_POST, true)); // Add file log


        $id = $this->input->post('id');
        $data = [
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content')
        ];

        // Handle Image Upload
        if (!empty($_FILES['image_file']['name'])) {
            $config['upload_path']   = FCPATH . 'assets/uploads/news/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 5048; // 5MB
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config); // Re-initialize for safety

            if ($this->upload->do_upload('image_file')) {
                $uploadData = $this->upload->data();
                $data['image'] = base_url('assets/uploads/news/' . $uploadData['file_name']);
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                // Redirect back to form if upload fails? Or just continue without image?
                // For now, let's redirect back to show error
                 if($id) {
                    redirect('admin/news_edit/'.$id);
                } else {
                    redirect('admin/news_add');
                }
                return;
            }
        } else {
             // Fallback to URL input if provided and no file uploaded
             if($this->input->post('image_url')) {
                 $data['image'] = $this->input->post('image_url');
             }
        }

        if($id) {
            $this->News_model->update($id, $data);
        } else {
            $this->News_model->insert($data);
        }
        $this->session->set_flashdata('success', 'Berita berhasil disimpan!');
        redirect('admin/news');
    }

    public function jadwal_delete($id) {
        $this->load->model('Operational_model');
        $this->Operational_model->delete_jadwal($id);
        $this->session->set_flashdata('success', 'Jadwal dihapus!');
        redirect('admin/jadwal');
    }

    // --- Armada Management ---
    // --- ARMADA ---
    public function armada() {
        $search = $this->input->get('search');

        if($search) {
             $this->db->like('nama_armada', $search);
             $this->db->or_like('plat_nomor', $search);
             $this->db->or_like('status', $search);
        }
        $data['armada'] = $this->db->get('armada')->result();
        $data['search'] = $search;

        $this->load->view('layout/header', ['title' => 'Manajemen Armada']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/armada/index', $data);
        $this->load->view('layout/footer');
    }

    public function armada_bulk_delete() {
        $ids = $this->input->post('ids');
        if ($ids && is_array($ids)) {
            $this->db->where_in('id', $ids);
            $this->db->delete('armada');
            $this->session->set_flashdata('success', count($ids) . ' armada berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data yang dipilih.');
        }
        redirect('admin/armada');
    }

    public function armada_add() {
        $this->load->model('Operational_model');
        
        $this->form_validation->set_rules('nama_armada', 'Nama Armada', 'required');
        $this->form_validation->set_rules('plat_nomor', 'Plat Nomor', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', ['title' => 'Tambah Armada']);
            $this->load->view('admin/layout/sidebar');
            $this->load->view('admin/armada/form');
            $this->load->view('layout/footer');
        } else {
            $data = [
                'nama_armada' => $this->input->post('nama_armada'),
                'plat_nomor' => $this->input->post('plat_nomor'),
                'kapasitas' => $this->input->post('kapasitas') ?: 8, 
                'layout_kursi' => $this->input->post('layout_kursi') ?: '1-3-4',
                'status' => 'tersedia'
            ];
            $this->Operational_model->insert_armada($data);
            $this->session->set_flashdata('success', 'Armada berhasil ditambahkan!');
            redirect('admin/armada');
        }
    }

    // --- Armada Methods ---
    public function armada_edit($id) {
        $this->load->model('Operational_model');
        $data['armada'] = $this->Operational_model->get_armada_by_id($id);
        
        $this->load->view('layout/header', ['title' => 'Edit Armada']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/armada/form', $data);
        $this->load->view('layout/footer');
    }

    public function armada_update() {
        $this->load->model('Operational_model');
        $id = $this->input->post('id');
        $data = [
            'nama_armada' => $this->input->post('nama_armada'),
            'plat_nomor' => $this->input->post('plat_nomor'),
            'kapasitas' => $this->input->post('kapasitas'),
            'layout_kursi' => $this->input->post('layout_kursi'),
            'status' => $this->input->post('status')
        ];
        $this->Operational_model->update_armada($id, $data);
        $this->session->set_flashdata('success', 'Armada berhasil diperbarui!');
        redirect('admin/armada');
    }
    
    public function armada_delete($id) {
        $this->load->model('Operational_model');
        $this->Operational_model->delete_armada($id);
        $this->session->set_flashdata('success', 'Armada dihapus!');
        redirect('admin/armada');
    }

    // --- DRIVERS MANAGEMENT ---
    public function drivers() {
        $search = $this->input->get('search');
        
        $this->db->select('users.*, armada.nama_armada, armada.plat_nomor, armada.status as status_armada');
        $this->db->from('users');
        $this->db->join('driver_detail', 'driver_detail.user_id = users.id', 'left');
        $this->db->join('armada', 'armada.id = driver_detail.current_armada_id', 'left');
        $this->db->where('users.role', 'driver');
        
        if($search) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('armada.nama_armada', $search);
            $this->db->group_end();
        }
        
        $data['drivers'] = $this->db->get()->result();
        $data['search'] = $search;

        $this->load->view('layout/header', ['title' => 'Daftar Driver']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/drivers/index', $data);
        $this->load->view('layout/footer');
    }

    // --- USERS ---
    public function users() {
        $search = $this->input->get('search');
        
        $this->db->select('*');
        $this->db->from('users');
        if($search) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('role', $search);
            $this->db->group_end();
        }
        $data['users'] = $this->db->get()->result();
        $data['search'] = $search;

        $this->load->view('layout/header', ['title' => 'Kelola User']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/users/index', $data);
        $this->load->view('layout/footer');
    }

    public function users_bulk_delete() {
        $ids = $this->input->post('ids');
        if ($ids && is_array($ids)) {
            $this->db->where_in('id', $ids);
            $this->db->delete('users');
            $this->session->set_flashdata('success', count($ids) . ' user berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada user yang dipilih.');
        }
        redirect('admin/users');
    }
    
    public function user_add() {
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->model('Operational_model');
            $data['armada_list'] = $this->Operational_model->get_all_armada();
            
            // Allow pre-selecting role via query param
            $data['preselected_role'] = $this->input->get('role');

            $this->load->view('layout/header', ['title' => 'Tambah User']);
            $this->load->view('admin/layout/sidebar');
            $this->load->view('admin/users/form', $data);
            $this->load->view('layout/footer');
        } else {
            // NEW: Check if armada is taken
            $armada_id = $this->input->post('armada_id');
            if ($this->input->post('role') == 'driver' && !empty($armada_id)) {
                 $this->load->model('Operational_model');
                 if ($this->Operational_model->is_armada_taken($armada_id)) {
                     $this->session->set_flashdata('error', 'Gagal: Armada ini sudah dipakai driver lain!');
                     redirect('admin/user_add'); // Redirect back to form
                     return;
                 }
            }
            
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role' => $this->input->post('role'),
                'phone' => $this->input->post('phone')
            ];
            
            if ($this->User_model->register($data)) {
                 // If driver, add to driver detail defaults
                 if($data['role'] == 'driver') {
                     $user_id = $this->db->insert_id();
                     $this->db->insert('driver_detail', [
                         'user_id' => $user_id,
                         'current_armada_id' => !empty($armada_id) ? $armada_id : NULL
                     ]);
                 }
                 $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
            } else {
                 $this->session->set_flashdata('error', 'Gagal menambah user.');
            }
            redirect('admin/users');
        }
    }

    public function user_reset_password($id) {
        // Default reset password
        $new_pass = 'raaster123';
        $hash = password_hash($new_pass, PASSWORD_BCRYPT);
        
        $this->User_model->update_password($id, $hash);
        $this->session->set_flashdata('success', 'Password berhasil direset menjadi: <strong>'.$new_pass.'</strong>');
        redirect('admin/users');
    }

    public function user_edit($id) {
        $this->load->model('Operational_model');
        $data['user'] = $this->User_model->get_user_by_id($id);
        
        // Fetch current armada if driver
        $driver_detail = $this->db->get_where('driver_detail', ['user_id' => $id])->row();
        $data['current_armada_id'] = $driver_detail ? $driver_detail->current_armada_id : null;

        $data['armada_list'] = $this->Operational_model->get_all_armada();
        
        $this->load->view('layout/header', ['title' => 'Edit User']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/users/form', $data);
        $this->load->view('layout/footer');
    }

    public function user_update() {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'role' => $this->input->post('role')
        ];
        
        // Handle Password only if filled
        $password = $this->input->post('password');
        if (!empty($password)) {
             $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // NEW: Check if armada is taken (exclude current user)
        $armada_id = $this->input->post('armada_id');
        if ($this->input->post('role') == 'driver' && !empty($armada_id)) {
             $this->load->model('Operational_model');
             if ($this->Operational_model->is_armada_taken($armada_id, $id)) {
                 $this->session->set_flashdata('error', 'Gagal Update: Armada ini sudah dipakai driver lain!');
                 redirect('admin/user_edit/' . $id);
                 return;
             }
        }

        $this->db->where('id', $id);
        $this->db->update('users', $data);
        
        // Handle Driver Armada Update
        if($this->input->post('role') == 'driver') {
            // Check if driver_detail exists
            $exists = $this->db->get_where('driver_detail', ['user_id' => $id])->num_rows() > 0;
            if($exists) {
                $this->db->where('user_id', $id);
                $this->db->update('driver_detail', ['current_armada_id' => !empty($armada_id) ? $armada_id : NULL]);
            } else {
                 $this->db->insert('driver_detail', ['user_id' => $id, 'current_armada_id' => !empty($armada_id) ? $armada_id : NULL]);
            }
        }

        $this->session->set_flashdata('success', 'User berhasil diperbarui!');
        redirect('admin/users');
    }

    public function user_delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
        $this->session->set_flashdata('success', 'User dihapus!');
        redirect('admin/users');
    }

    // --- Extra Features ---
    public function tracking() {
        $this->load->view('layout/header', ['title' => 'Live Tracking Armada']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/tracking/index');
        $this->load->view('layout/footer');
    }
    
    public function get_locations_api() {
        $this->load->model('Operational_model');
        $locations = $this->Operational_model->get_driver_locations();
        echo json_encode($locations);
    }

    public function chat() {
        $this->load->view('layout/header', ['title' => 'Admin Chat']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/chat/index');
        $this->load->view('layout/footer');
    }

    // --- Chat APIs ---
    public function chat_get_contacts() {
        $role = $this->input->get('role') ?: 'driver';
        $this->load->model('Operational_model');
        $data = $this->Operational_model->get_chat_contacts($role);
        echo json_encode($data);
    }

    public function chat_get_messages() {
        $partner_id = $this->input->get('user_id');
        $my_id = $this->session->userdata('user_id');
        
        $this->load->model('Operational_model');
        
        // Mark as read when fetching messages
        $this->Operational_model->mark_messages_read($partner_id, $my_id);
        
        $messages = $this->Operational_model->get_conversation($my_id, $partner_id);
        echo json_encode($messages);
    }
    
    public function chat_mark_read() {
        $sender_id = $this->input->post('sender_id'); // Content sender (partner)
        $my_id = $this->session->userdata('user_id'); // Me (receiver)
        
        $this->load->model('Operational_model');
        $this->Operational_model->mark_messages_read($sender_id, $my_id);
        echo json_encode(['status' => 'success']);
    }

    public function chat_send() {
        $receiver_id = $this->input->post('receiver_id');
        $message = $this->input->post('message');
        $my_id = $this->session->userdata('user_id');

        if ($receiver_id && $message) {
            $data = [
                'sender_id' => $my_id,
                'receiver_id' => $receiver_id,
                'message' => $message,
                'is_read' => 0
            ];
            $this->load->model('Operational_model');
            $this->Operational_model->insert_chat($data);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // --- BOOKING / PEMESANAN ---
    public function bookings() {
        $this->db->select('pemesanan.*, users.name as nama_pemesan, users.email, users.phone, rute.kota_asal, rute.kota_tujuan, perjalanan.tanggal, armada.nama_armada');
        $this->db->from('pemesanan');
        $this->db->join('users', 'users.id = pemesanan.customer_id');
        $this->db->join('perjalanan', 'perjalanan.id = pemesanan.perjalanan_id');
        $this->db->join('jadwal', 'jadwal.id = perjalanan.jadwal_id');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = perjalanan.armada_id', 'left');
        $this->db->order_by('pemesanan.tanggal_pemesanan', 'DESC');
        $data['bookings'] = $this->db->get()->result();

        $this->load->view('layout/header', ['title' => 'Manajemen Pemesanan']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/bookings/index', $data);
        $this->load->view('layout/footer');
    }

    public function booking_verify($id, $action) {
        $status = ($action == 'approve') ? 'lunas' : 'batal';
        
        // 1. Update Status
        $this->db->where('id', $id);
        $this->db->update('pemesanan', ['status_pembayaran' => $status]);

        // 2. Fetch Customer ID
        $booking = $this->db->get_where('pemesanan', ['id' => $id])->row();
        
        if($booking) {
            $customer_id = $booking->customer_id;
            $admin_id = $this->session->userdata('user_id') ?: 1; // Fallback to 1 if session weird

            // 3. Compose Message
            if($status == 'lunas') {
                $msg = "Halo! Pembayaran Anda untuk pesanan #{$id} telah diverifikasi & DITERIMA. \nSilakan cek detail tiket Anda di menu 'Tiket Saya' atau klik tombol download tiket.";
            } else {
                $msg = "Mohon maaf, pembayaran untuk pesanan #{$id} DITOLAK. \nSilakan hubungi Admin untuk informasi lebih lanjut atau upload ulang bukti pembayaran yang valid.";
            }

            // 4. Send Notification (Insert to Chat)
            $chat_data = [
                'sender_id' => $admin_id,
                'receiver_id' => $customer_id,
                'message' => $msg,
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('chat', $chat_data);
        }

        $this->session->set_flashdata('success', 'Status pemesanan #'.$id.' diubah menjadi '.ucfirst($status).' dan notifikasi dikirim.');
        redirect('admin/bookings');
    }

    // --- FINANCIAL / PAYMENTS ---


    public function payment_add() {
        $this->load->model('Financial_model');
        
        $this->form_validation->set_rules('user_id', 'Driver', 'required');
        $this->form_validation->set_rules('amount', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('payment_date', 'Tanggal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['drivers'] = $this->db->get_where('users', ['role' => 'driver'])->result();
            
            // Pre-fill data from GET params
            $data['pre_driver_id'] = $this->input->get('driver_id');
            $data['pre_amount'] = $this->input->get('amount');
            
            $this->load->view('layout/header', ['title' => 'Buat Pembayaran']);
            $this->load->view('admin/layout/sidebar');
            $this->load->view('admin/payments/form', $data);
            $this->load->view('layout/footer');
        } else {
            $data = [
                'user_id' => $this->input->post('user_id'),
                'admin_id' => $this->session->userdata('user_id'),
                'amount' => $this->input->post('amount'),
                'payment_date' => str_replace('T', ' ', $this->input->post('payment_date')), // Format: Y-m-d H:i
                'note' => $this->input->post('note')
            ];
            
            if ($this->Financial_model->insert_payment($data)) {
                $this->session->set_flashdata('success', 'Pembayaran berhasil disimpan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan pembayaran.');
            }
            redirect('admin/payments');
        }
    }

    // --- BERITA (NEWS) ---
    public function news() {
        $this->load->model('News_model');
        $data['news'] = $this->News_model->get_all();
        
        $this->load->view('layout/header', ['title' => 'Kelola Berita']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/news/index', $data);
        $this->load->view('layout/footer');
    }

    public function news_add() {
        $this->load->view('layout/header', ['title' => 'Tambah Berita']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/news/form');
        $this->load->view('layout/footer');
    }

    public function news_edit($id) {
        $this->load->model('News_model');
        $data['news'] = $this->News_model->get_by_id($id);
        
        $this->load->view('layout/header', ['title' => 'Edit Berita']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/news/form', $data);
        $this->load->view('layout/footer');
    }



    public function news_delete($id) {
        $this->load->model('News_model');
        $this->News_model->delete($id);
        $this->session->set_flashdata('success', 'Berita dihapus!');
        redirect('admin/news');
    }

    // --- KELUHAN (COMPLAINTS) ---
    public function complaints() {
        $this->load->model('Complaint_model');
        $data['complaints'] = $this->Complaint_model->get_all();
        
        $this->load->view('layout/header', ['title' => 'Keluhan Pelanggan']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/complaints/index', $data);
        $this->load->view('layout/footer');
    }

    public function complaint_resolve($id) {
        $this->load->model('Complaint_model');
        $this->Complaint_model->update_status($id, 'resolved');
        $this->session->set_flashdata('success', 'Keluhan ditandai selesai!');
        redirect('admin/complaints');
    }

    public function complaint_delete($id) {
        $this->load->model('Complaint_model');
        $this->Complaint_model->delete($id);
        $this->session->set_flashdata('success', 'Keluhan dihapus!');
        redirect('admin/complaints');
    }

    // --- GALLERY ---
    public function gallery() {
        $this->load->model('Gallery_model');
        $data['gallery'] = $this->Gallery_model->get_all();
        
        $this->load->view('layout/header', ['title' => 'Galeri Foto']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/gallery/index', $data);
        $this->load->view('layout/footer');
    }

    public function gallery_add() {
        $this->load->view('layout/header', ['title' => 'Tambah Foto']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/gallery/form');
        $this->load->view('layout/footer');
    }

    public function gallery_edit($id) {
        $this->load->model('Gallery_model');
        $data['gallery'] = $this->Gallery_model->get_by_id($id);
        
        $this->load->view('layout/header', ['title' => 'Edit Foto']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/gallery/form', $data);
        $this->load->view('layout/footer');
    }

    public function gallery_save() {
        $this->load->model('Gallery_model');
        $id = $this->input->post('id');
        
        $data = [
            'title' => $this->input->post('title'),
            'category' => $this->input->post('category'),
            'description' => $this->input->post('description'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Handle Image Upload
        if (!empty($_FILES['image_file']['name'])) {
            $config['upload_path']   = FCPATH . 'assets/uploads/gallery/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 5048; // 5MB
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config); // Re-initialize

            if ($this->upload->do_upload('image_file')) {
                $uploadData = $this->upload->data();
                $data['image'] = base_url('assets/uploads/gallery/' . $uploadData['file_name']);
            } else {
                 $this->session->set_flashdata('error', $this->upload->display_errors());
                 if($id) {
                    redirect('admin/gallery_edit/'.$id);
                } else {
                    redirect('admin/gallery_add');
                }
                return;
            }
        } else {
             // Fallback to URL input
             if($this->input->post('image_url')) {
                 $data['image'] = $this->input->post('image_url');
             }
        }
        
        if($id) {
            unset($data['created_at']); // Don't reset date on edit
            $this->Gallery_model->update($id, $data);
            $this->session->set_flashdata('success', 'Foto diperbarui!');
        } else {
            $this->Gallery_model->insert($data);
            $this->session->set_flashdata('success', 'Foto ditambahkan!');
        }
        redirect('admin/gallery');
    }

    public function gallery_delete($id) {
        $this->load->model('Gallery_model');
        $this->Gallery_model->delete($id);
        $this->session->set_flashdata('success', 'Foto dihapus!');
        redirect('admin/gallery');
    }

    // --- LANDING PAGE SETTINGS ---
    public function landing_settings() {
        $this->load->model('Settings_model');
        $data['settings'] = $this->Settings_model->get_all_settings();
        
        $this->load->view('layout/header', ['title' => 'Pengaturan Landing Page']);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/settings/landing', $data);
        $this->load->view('layout/footer');
    }

    public function update_landing_settings() {
        $this->load->model('Settings_model');
        
        $hero_tagline = $this->input->post('hero_tagline');
        $hero_title = $this->input->post('hero_title');
        $hero_subtitle = $this->input->post('hero_subtitle');
        $hero_image = $this->input->post('hero_image'); // Fallback URL

        // Handle File Upload
        if (!empty($_FILES['hero_image_file']['name'])) {
            $config['upload_path']   = './assets/uploads/hero/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 5048; // 5MB
            $config['encrypt_name']  = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('hero_image_file')) {
                $uploadData = $this->upload->data();
                $hero_image = base_url('assets/uploads/hero/' . $uploadData['file_name']);
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/landing_settings');
                return;
            }
        }

        $this->Settings_model->update_setting('hero_tagline', $hero_tagline);
        $this->Settings_model->update_setting('hero_title', $hero_title);
        $this->Settings_model->update_setting('hero_subtitle', $hero_subtitle);
        $this->Settings_model->update_setting('hero_image', $hero_image);

        $this->session->set_flashdata('success', 'Tampilan Landing Page berhasil diperbarui.');
        redirect('admin/landing_settings');
    }
    // --- INFO TERKINI CRUD ---
    public function info() {
        $this->load->model('Info_model');
        $data['infos'] = $this->Info_model->get_all();
        $this->load->view('layout/header', ['title' => 'Manajemen Info Terkini']);
        $this->load->view('admin/layout/sidebar', ['role' => 'admin']);
        $this->load->view('admin/info/index', $data);
        $this->load->view('layout/footer');
    }

    public function info_add() {
        $this->load->view('layout/header', ['title' => 'Tambah Info Terkini']);
        $this->load->view('admin/layout/sidebar', ['role' => 'admin']);
        $this->load->view('admin/info/form');
        $this->load->view('layout/footer');
    }

    public function info_edit($id) {
        $this->load->model('Info_model');
        $data['info'] = $this->Info_model->get_by_id($id);
        
        $this->load->view('layout/header', ['title' => 'Edit Info Terkini']);
        $this->load->view('admin/layout/sidebar', ['role' => 'admin']);
        $this->load->view('admin/info/form', $data); // Reuse form
        $this->load->view('layout/footer');
    }

    public function info_save() {
        $this->load->model('Info_model');
        
        $id = $this->input->post('id');
        $data = [
            'title' => $this->input->post('title'),
            'info_type' => $this->input->post('info_type'),
            'content' => $this->input->post('content'),
            'link_url' => $this->input->post('link_url'),
            'tag_text' => $this->input->post('tag_text'),
        ];

        if ($id) {
            $this->Info_model->update($id, $data);
            $this->session->set_flashdata('success', 'Info berhasil diperbarui.');
        } else {
            $this->Info_model->insert($data);
            $this->session->set_flashdata('success', 'Info berhasil ditambahkan.');
        }

        redirect('admin/info');
    }

    public function info_delete($id) {
        $this->load->model('Info_model');
        $this->Info_model->delete($id);
        $this->session->set_flashdata('success', 'Info berhasil dihapus.');
        redirect('admin/info');
    }
}
